<?
$db = new PDO("mysql:host=localhost;dbname=pikseli", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// Räjäytä skripti heti ekan SQL-virheen kohdalla
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
##EOF