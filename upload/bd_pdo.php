<?php
require_once(__DIR__ .'/../config.php');
$config = require_once('config_db.php');
require_once(__DIR__ . '/Classes/PDODriver.php');
require_once(__DIR__ .'/Classes/apiplus-v1.php');
require_once(__DIR__ . '/Classes/DownloadImages.php');
require_once(__DIR__ .'/Classes/PHPExcel.php');

$pdo_driver = new  PDODriver($config['host'],$config['username'], $config['password'], $config['database']);
//var_dump($pdo_driver);
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$id = 1; // id компании поставщика, это  Brain
$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);
$sql = $pdo->getConnection()->prepare("SELECT * FROM login_password_to_suppliers WHERE id_supplier=:id");
$sql->execute(array('id' => $id));
$result = $sql->fetch(PDO::FETCH_ASSOC);
//var_dump($result);
 $login = $result['login'];
 $password = $result['password'];
/*$supplier = $result['supplier'];*/
// ***************** КОНЕЦ   вытаскиваем из базы  логин и пароль  нашего постащика *******************************

// authorize to get SID
$AP = new apiplus();
$session_id = $AP->_api_auth($login, $password);
/*echo $session_id;*/