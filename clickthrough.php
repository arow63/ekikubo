<?php


include 'common.php';

// Handle banners clickthrough
$query = "SELECT url FROM " . $DBPrefix . "banners WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $_GET['banner'], 'int');
$db->query($query, $params);
$URL = $db->result('url');

// Update clickthrough counter in the database
$query = "UPDATE " . $DBPrefix . "banners set clicks = clicks + 1 WHERE id = :banner_id";
$params = array();
$params[] = array(':banner_id', $_GET['banner'], 'int');
$db->query($query, $params);

// Redirect
header('location: ' . $URL);
exit;
