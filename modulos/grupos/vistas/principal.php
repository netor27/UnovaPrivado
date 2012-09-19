<?php

echo 'total de grupos = ' . $numGrupos . '<br>';
if (isset($grupos)) {
    print_r($grupos);
} else {
    echo 'no hay grupos';
}
?>