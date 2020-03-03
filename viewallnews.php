<?php


include 'common.php';

$query = "SELECT id, title FROM " . $DBPrefix . "news WHERE suspended = 0 ORDER BY new_date";
$db->direct_query($query);

while ($row = $db->fetch()) {
    $template->assign_block_vars('news', array(
            'TITLE' => $row['title'],
            'ID' => $row['id']
            ));
}

include 'header.php';
$template->set_filenames(array(
        'body' => 'viewallnews.tpl'
        ));
$template->display('body');
include 'footer.php';
