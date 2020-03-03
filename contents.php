<?php


include 'common.php';

switch ($_GET['show']) {
    case 'terms':
        $TITLE = $MSG['5086'];
        $CONTENT = $system->SETTINGS['termstext'];
        break;
    case 'priv':
        $TITLE = $MSG['401'];
        $CONTENT = $system->SETTINGS['privacypolicytext'];
        break;
    case 'cookies':
        $TITLE = $MSG['cookie_policy'];
        $CONTENT = $system->SETTINGS['cookiespolicytext'];
        break;
    default:
    case 'aboutus':
        $TITLE = $MSG['5085'];
        $CONTENT = $system->SETTINGS['aboutustext'];
        break;
}

$template->assign_vars(array(
        'TITLE' => $TITLE,
        'CONTENT' => $CONTENT
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'contents.tpl'
        ));
$template->display('body');
include 'footer.php';
