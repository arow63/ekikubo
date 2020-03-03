<?php


include 'common.php';

if ($system->SETTINGS['boards'] == 'n') {
    header('location: index.php');
}

if (!$user->checkAuth()) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'boards.php';
    header('location: user_login.php');
    exit;
}

// Retrieve message boards from the database
$query = "SELECT * FROM " . $DBPrefix . "community WHERE active = 1 ORDER BY name";
$db->direct_query($query);
while ($row = $db->fetch()) {
    $template->assign_block_vars('boards', array(
            'NAME' => $row['name'],
            'ID' => $row['id'],
            'NUMMSG' => $row['messages'],
            'LASTMSG' => ($row['messages'] > 0) ? $dt->formatDate($row['lastmessage']) : '--'
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'boards.tpl'
        ));
$template->display('body');
include 'footer.php';
