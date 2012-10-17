<?php

function using_ie() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = False;
    if (preg_match('/MSIE/i', $u_agent)) {
        $ub = True;
    }

    return $ub;
}

if (using_ie()) {
    echo 'ES INTERNET EXPLORER';
} else {
    echo 'NO es internet explorer';
}
?>