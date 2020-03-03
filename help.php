<?php


include 'common.php';

$template->assign_vars(array(
        'DOCDIR' => $DOCDIR, // Set document direction (set in includes/messages.XX.inc.php) ltr/rtl
        'PAGE_TITLE' => $system->SETTINGS['sitename'] . ' ' . $MSG['5236'],
        'CHARSET' => $CHARSET,
        'LOGO' => ($system->SETTINGS['logo']) ? '<a href="' . $system->SETTINGS['siteurl'] . 'index.php?"><img src="' . $system->SETTINGS['siteurl'] . 'uploaded/logo/' . $system->SETTINGS['logo'] . '" border="0" alt="' . $system->SETTINGS['sitename'] . '"></a>' : "&nbsp;",
        'SITEURL' => $system->SETTINGS['siteurl'],
        'THEME' => $system->SETTINGS['theme']
        ));

    include 'header.php';
// Retrieve FAQs categories from the database
$query = "SELECT * FROM " . $DBPrefix . "faqscat_translated WHERE lang = :language ORDER BY category ASC";
$params = array();
$params[] = array(':language', $language, 'str');
$db->query($query, $params);
while ($cat = $db->fetch()) {
    $template->assign_block_vars('cats', array(
            'CAT' => $cat['category'],
            'ID' => $cat['id']
            ));
}

$template->set_filenames(array(
        'body' => 'help.tpl'
        ));
$template->display('body');
include 'footer.php';
