<?php
session_start();
$_SESSION['easter_egg'] = 'EASTER2025';
header('Location: play.php');
?>