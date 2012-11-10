<?php
$path = "/";
if(isset($_POST['path'])){
    $path = $_POST['path'];
}


require_once 'funcionesPHP/funcionesGenerales.php';
echo 'Path ' . $path . '<br><br>';
print_r(pathinfo($path));
echo '<br>';
echo 'Espacio total en disco = ' . bytesToString(disk_total_space($path),4). '<br>';
echo 'Espacio disponible     = ' . bytesToString(disk_free_space($path),4).'<br>';
?>

<br><br><br>
<form action="test.php" method="post">
    <input type="text" name="path"/>
</form>
?>