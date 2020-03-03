<?php


include 'common.php';

$UPLOADED_PICTURES = $_SESSION['UPLOADED_PICTURES'];
$img = $_GET['img'];

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'IMG' => UPLOAD_FOLDER . session_id() . '/' . $UPLOADED_PICTURES[$img]
        ));
$template->set_filenames(array(
        'body' => 'preview_gallery.tpl'
        ));
$template->display('body');
