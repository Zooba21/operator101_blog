<?php
include('localhost/blog/application/config/config.php');
const GET_TITLE = "SELECT `postTitle` FROM `post` WHERE `postTitle`=?"

$dbh = new PDO($config['dsn'], $config['user'], $congif['password'], 'SET NAMES utf8');

 ?>
