<?php

//Load de sdk
require_once 'vendor/autoload.php';

//Para acceder al S3
use Aws\Common\Aws;
//Para subir archivos grandes
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Model\MultipartUpload\UploadBuilder;

function uploadFileToS3($sourceFile, $folder = "") {
    $resultado = array("res" => false);
    // Instanciamos un cliente de s3
    $client = Aws::factory(getServerRoot() . '/modulos/aws/modelos/configurationFile.php')->get('s3');

    $bucket = getBucketName();
    $key = generateFileKey($sourceFile, $folder);
    while ($client->doesObjectExist($bucket, $key)) {
        //Si ese objeto ya existe, generamos otro key
        //Este caso es muy raro, debido a la generación,
        //Pero puede pasar
        $key = generateFileKey($sourceFile, $folder);
    }
    require_once 'funcionesPHP/funcionesParaArchivos.php';
    //Si el archivo es más grande que 10MB, utilizamos la función
    //para subir por partes
    $megabytesLimit = 10 * 1048576;
    if (getFileSize($sourceFile) < $megabytesLimit) {
        $client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $sourceFile,
            'ACL' => 'public-read'
        ));
        $resultado["res"] = true;
    } else {
        $uploader = UploadBuilder::newInstance()
                ->setClient($client)
                ->setSource($sourceFile)
                ->setBucket($bucket)
                ->setKey($key)
                ->setOption('ACL', 'public-read')
                ->build();
        try {
            $uploader->upload();
            $resultado["res"] = true;
        } catch (MultipartUploadException $e) {
            $uploader->abort();
            $resultado["res"] = false;
        }
    }
    if ($resultado['res']) {
        $resultado["bucket"] = $bucket;
        $resultado["key"] = $key;
        $prefijoLink = getPrefijoLink();
        $resultado["link"] = $prefijoLink . $bucket . "/" . $key;
    }
    return $resultado;
}

function generateFileKey($sourceFile, $folder = "") {
    $pathInfo = pathinfo($sourceFile);
    if ($folder === "") {
        $folder = getFolderName($pathInfo['extension']);
    }
    $fileName = getUniqueCode(150) . '.' . $pathInfo['extension'];
    $fileKey = $folder . '/' . $fileName;
    return $fileKey;
}

function getPrefijoLink() {
    require_once 'modulos/principal/modelos/variablesDeProductoModelo.php';
    return getVariableDeProducto("prefijoLink");
}

function getBucketName() {
    require_once 'modulos/principal/modelos/variablesDeProductoModelo.php';
    return getVariableDeProducto("defaultBucketName");
}

function getFolderName($extension) {
    $extension = strtolower($extension);
    switch ($extension) {
        case 'pdf':
        case 'doc':
        case 'docx':
        case 'ppt':
        case 'pptx':
        case 'xls':
        case 'xlsx':
            $folder = 'documentos';
            break;
        case 'mov':
        case 'mp4':
        case 'wmv':
        case 'avi':
        case '3gp':
        case 'avi':
        case 'flv':
        case 'mpg':
        case 'mpeg':
        case 'mpe':
        case 'ogv':
        case 'mp3':
        case 'ogg':
        case 'wav':
        case 'm4a':
        case 'wmva':
            //Estos archivos no se han transformado,
            //Se guardan en un folder de archivos sin transformar
            $folder = 'porTransformar';
            break;
        default:
            $folder = 'otros';
            break;
    }
    return $folder;
}

function deleteFileFromS3($key) {
    $client = Aws::factory(getServerRoot() . '/modulos/aws/modelos/configurationFile.php')->get('s3');
    $bucket = getBucketName();
    try {
        $client->deleteObject(array(
            'Bucket' => $bucket,
            'Key' => $key
        ));
        return true;
    } catch (Exception $e) {
        //echo 'No se borro el archivo ' . $bucket . "/" . $key;
        require_once 'modulos/principal/modelos/variablesDeProductoModelo.php';
        agregarArchivoPendientePorBorrar($bucket . "/" . $key);
        return false;
    }
}

function deleteFileFromS3ByUrl($url) {
    $prefijo = getPrefijoLink();
    $url = str_ireplace($prefijo, "", $url);
    list($bucket, $key) = explode("/", $url, 2);
    return deleteFileFromS3($key);
}

?>