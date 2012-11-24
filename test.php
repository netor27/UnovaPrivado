<?php

if (isset($_POST['dato'])) {
    print_r($_POST);
    echo '<br><br><br>Imagen:<br>';
    print_r($_FILES['imagen']);
} else {
    ?>
    <script src="lib/js/ajaxFileUpload/webtoolkit.aim.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    </script>

    <form action="subirArchivos.php?a=subirImagen" method="post" enctype="multipart/form-data">
        <div>
            <label>Name:</label>
            <input name="dato" type="text" />
        </div>
        <div>
            <label>File:</label>
            <input name="imagen" type="file" />
        </div>
        <div>
            <input type="submit" value="SUBMIT" />
        </div>
    </form>
    <?php

}
?>