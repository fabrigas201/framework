<?php
// Стандарт

function e($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8') ;
}


function html_decode($string) {
    return html_entity_decode($string, ENT_QUOTES, 'UTF-8') ;
}
