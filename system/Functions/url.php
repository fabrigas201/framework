<?php
// Стандарт

function get_url() {
    $args = func_get_args();
    if (count($args) === 1) return BASE_URL . $args[0];

    $url = '';
    foreach ($args as $param) {
        if (strlen($param)) {
            $url .= $param{0} == '#' ? $param: '/'. $param;
        }
    }
    return BASE_URL . preg_replace('/^\/(.*)$/', '$1', $url);
}

if(!function_exists('asset')){
	function asset($asset){
		return get_url('public/templates/remaller/'.$asset);
	}
}



function redirect($url) {
    header('Location: '.$url); exit;
}

