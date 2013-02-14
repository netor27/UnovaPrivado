<?php

function descargarArchivo($file_path) {
    echo "filepath=".$file_path;
    $path_parts = pathinfo($file_path);
    $file_name = $path_parts['basename'];
    $file_ext = $path_parts['extension'];
    $file_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $file_path;
    if (is_file($file_path)) {
        header("Pragma: public");
        header("Expires: -1");
        header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
        
        $ctype_default = "application/octet-stream";
        $content_types = array(
            "mp3" => "audio/mpeg",
            "ogg" => "audio/ogg",
            "mp4" => "video/mp4",
            "webm" => "video/webm",
            "doc" => "application/msword",
            "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "ppt" => "application/vnd.ms-powerpoint",
            "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "pdf" => "application/pdf",
            "xls" => "application/vnd.ms-excel",
            "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "avi" => "video/x-msvideo",
            "mpg" => "video/mpeg",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
        );
        $ctype = isset($content_types[$file_ext]) ? $content_types[$file_ext] : $ctype_default;
        header("Content-Type: " . $ctype);
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        header('X-Sendfile: ' . $file_path);
        exit;
    } else {
        //El archivo no existe
        header("HTTP/1.0 404 Not Found");
        exit;
    }
}

?>