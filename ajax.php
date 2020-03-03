<?php


include 'common.php';
include INCLUDE_PATH . 'functions_ajax.php';

$do = alphanumeric($_GET['do']);

switch ($do) {
    case 'uploadaucimages':
        upload_images();
        break;
    case 'getupldtable':
        getupldtable();
        break;
}
