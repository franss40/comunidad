<?php

function redirect($pagina) {
    session_write_close();
    header('location:' . URLROOT . '/' . $pagina);
}

function salvaHtml($variable) {
    return htmlentities($variable, ENT_NOQUOTES, "UTF-8");
}

function urlAmigable($url) {
    return str_replace(' ', '-', $url);
}

function deleteUrlAmigable($url) {
    return str_replace('-', ' ', $url);
}