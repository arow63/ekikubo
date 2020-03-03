
<?php


include 'common.php';

// If user is not logged in redirect to login page
if (!$user->checkAuth()) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'yourmessages.php';
    header('location: user_login.php');
    exit;
}

$messageid = intval($_GET['id']);
// check message is to user
$query = "SELECT m.*, u.nick FROM " . $DBPrefix . "messages m
		LEFT JOIN " . $DBPrefix . "users u ON (u.id = m.sentfrom)
		WHERE m.sentto = :user_id AND m.id = :message_id";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$params[] = array(':message_id', $messageid, 'int');
$db->query($query, $params);

if ($db->numrows() == 0) {
    $_SESSION['message'] = $ERR_070;
    header('location: mail.php');
}

$array = $db->result();
$sent = $dt->formatDate($array['sentat'], 'M d, Y H:ia');
$subject = $array['subject'];
$message = $array['message'];
$hash = md5(rand(1, 9999));
$array['message'] = str_replace('<br>', '', $array['message']);

if ($array['sentfrom'] == 0 && !empty($array['fromemail'])) {
    $sendusername = $array['fromemail'];
    $senderlink = $sendusername;
} elseif ($array['sentfrom'] == 0 && empty($array['fromemail'])) {
    $sendusername = $MSG['110'];
    $senderlink = $sendusername;
} else {
    $sendusername = $array['nick'];
    $senderlink = '<a href="profile.php?user_id=1&auction_id=' . $array['sentfrom'] . '">' . $sendusername . '</a>';
}

// Update message
$query = "UPDATE " . $DBPrefix . "messages SET isread = :read WHERE id = :message_id";
$params = array();
$params[] = array(':read', 1, 'int');
$params[] = array(':message_id', $messageid, 'int');
$db->query($query, $params);

// set session for reply
$_SESSION['subject' . $hash] = (substr($subject, 0, 3) == 'Re:') ? $subject : 'Re: ' . $subject;
$_SESSION['sendto' . $hash] = $sendusername;
$_SESSION['reply' . $hash] = $messageid;
$_SESSION['reply_of' . $hash] = ($array['reply_of'] == 0) ? $messageid : $array['reply_of'];
$_SESSION['question' . $hash] = $array['question'];

$template->assign_vars(array(
        'SUBJECT' => $subject,
        'SENDERNAME' => (isset($senderlink)) ? $senderlink : $sendusername,
        'SENT' => $sent,
        'MESSAGE' => $message,
        'ID' => $messageid,
        'HASH' => $hash
        ));

include 'header.php';
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
        'body' => 'yourmessages.tpl'
        ));
$template->display('body');
include 'footer.php';