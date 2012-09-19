<?php

echo '' . $numGrupos . ' grupos asignados al id= ' . $idCurso . '<br>';
if (isset($grupos)) {
    print_r($grupos);
} else {
    echo'no hay grupos';
}
?>