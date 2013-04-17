<?php
$breadCrumbs = getBreadCrumbs();
$n = sizeof($breadCrumbs);
if ($n > 0 && !isset($noBreadCrumbs)) {
    ?>
    <div class="row-fluid">
        <ul class="breadcrumb ">
            <li><a href="/">Inicio</a></li>
            <?php
            $i = 0;
            for ($i = 0; $i < $n; $i++) {
                if ($i == $n - 1)
                    echo '<li class="active"><span class="divider">/</span>' . $breadCrumbs[$i]["txt"] . '</li>';

                else
                    echo '<li ><span class="divider">/</span> <a href="' . $breadCrumbs[$i]["url"] . '">' . $breadCrumbs[$i]["txt"] . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <?php
}
?>