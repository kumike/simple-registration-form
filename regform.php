<?php
session_start();
//***служебные ошибки***
ini_set('display_errors',1);
error_reporting(E_ALL);

//*** запрещаем прямой доступ зарегестрированого юзера
if (!empty($_SESSION['login'])){
	$uri = dirname($_SERVER['PHP_SELF']);
	//*** вызываем перенаправление абсолютным путём, как напмсано в доках
	header("Location: http://{$_SERVER['HTTP_HOST']}$uri/index.php");
	die();
}

//*** автоматическая загрузка нужных класов
spl_autoload_register(function($class){include 'classes/'.$class.'Class.php';});

$html = new Html();
$html->setTitle('Форма регистрации');
$html->getHeader();

$menu = new Menu();
$menu->getMenu();

$form = new Form('ver.php','Зарегистрироватся','Регистрация нового пользователя',1);
$form->getForm();

$html->getFooter();
?>
