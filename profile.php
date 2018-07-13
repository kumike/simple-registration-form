<?php session_start();

//***служебные ошибки***
ini_set('display_errors',1);
error_reporting(E_ALL);

//*** защита от прямого доступа к файлу незарегестрированых юзеров.
if (empty($_SESSION['login']) or empty($_SESSION['id'])){
	$uri = dirname($_SERVER['PHP_SELF']);
	//*** вызываем перенаправление абсолютным путём, как напмсано в доках
	header("Location: http://{$_SERVER['HTTP_HOST']}$uri/index.php");
	die();
}

//*** автоматическая загрузка нужных класов
spl_autoload_register(function($class){include 'classes/'.$class.'Class.php';});

$html = new Html();
$html->getHeader('Профиль пользователя'); 
$menu = new Menu();

$menu->getLogInMenu();

$dbh = new PDO('mysql:host=localhost;dbname=regPass;charset=utf8', 'mishele', '1437');
//*** подготавливаем мускуел запрос и выполняем его
$result = $dbh->prepare("SELECT id,login FROM user WHERE id=:id");
$result->execute([':id'=>$_SESSION['id']]);
$row = $result->fetch();

echo $row['id'];
echo $row['login'];

echo '<br>';

var_dump($_COOKIE);
echo '<br>';
echo $_COOKIE['PHPSESSID'];

$html->getFooter();


?>
