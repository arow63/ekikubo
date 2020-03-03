<?php


$error = true;
include 'common.php';

$template->assign_vars(array(
        'ERROR' => print_r($_SESSION['SESSION_ERROR'], true),
        'DEBUGGING' => false, // set to true when trying to fix the script
        'ERRORTXT' => $system->SETTINGS['errortext']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'error.tpl'
        ));
$template->display('body');
include 'footer.php';
