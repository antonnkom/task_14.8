<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$auth = $_SESSION['auth'] ?? null;