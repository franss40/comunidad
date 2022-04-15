<?php

function redirect($pagina) {
    session_write_close();
    header('location:' . URLROOT . '/' . $pagina);
}

function salvaHtml($variable) {
    return htmlentities($variable, ENT_NOQUOTES, "UTF-8");
}

function urlAmigable($url) {
    return str_replace(' ', '_', $url);
}

function deleteUrlAmigable($url) {
    return str_replace('_', ' ', $url);
}

/**
 * Función para pruebas
 * Comprobamos si el parámetro esperado está incluido en el parámetro actúal
 * y mostramos la salida. Son arrays.
 * 
 * @param type $esperado
 * @param type $actual
 * @param type $salida
 */
function assertArrayEquals($esperado, $actual, $salida) {
    if (in_array($esperado, $actual)) {
        echo "<h4>$salida: <strong style='color: green'>TRUE</strong></h4>";
    } else {
        echo "<h4>$salida: <strong style='color: red'>FALSE</strong></h4>";
    }
}
/**
 * Función para pruebas
 * La diferencia con el anterior es que aquí no son arrays. 
 * Comprobamos que sean iguales los valores
 * 
 * @param type $esperado
 * @param type $actual
 * @param type $salida
 */
function assertEquals($esperado, $actual, $salida) {
    if ($esperado==$actual) {
        echo "<h4>$salida: <strong style='color: green'>TRUE</strong></h4>";
    } else {
        echo "<h4>$salida: <strong style='color: red'>FALSE</strong></h4>";
    }
}