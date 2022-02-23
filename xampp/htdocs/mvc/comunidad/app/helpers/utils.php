<?php

function redirect($pagina) {
    header('location:' . URLROOT . '/' . $pagina);
}

function salvaHtml($variable) {
    return htmlentities($variable, ENT_NOQUOTES, "UTF-8");
}

function urlAmigable($url) {
    return str_replace(' ', '-', $url);
}