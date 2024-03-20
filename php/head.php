<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/functions.php';
$auth = $_SESSION['auth'] ?? null;