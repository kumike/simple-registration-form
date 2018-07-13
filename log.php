<?php
session_start();
//***служебные ошибки***
ini_set('display_errors',1);
error_reporting(E_ALL);

//*** автоматическая загрузка нужных класов
spl_autoload_register(function($class){include 'classes/'.$class.'Class.php';});

$html = new Html();
$html->GetHeader();

$menu = new Menu();
$menu->getMenu();

//var_dump(isset($_POST['login']));

include 'pdodb.php';
//*** чистим юзерский ввод от нежелательных символов
$login = trim(stripslashes(htmlentities($_POST['login'],ENT_QUOTES))) ?? false;
//*** подготавливаем мускуел запрос и выполняем его
$result = $dbh->prepare("SELECT id,password FROM user WHERE login=:login");
$result->execute([':login'=>$login]);
//*** достаем строку с нужными значениями из обьекта PDOStatement который вернул запрос,
//*** по умолчанию PDO::FETCH_BOTH тоесть и по номеру и по имени можно обращатся
$row = $result->fetch();
//*** если проверка пароля пройдена пользователь вошел, если нет пишем ему соопщение
if (password_verify($_POST['password'],$row['password'])){
	//*** назначаем сессионным переменным значения, их будет с собой носить юзер, для проверки его на залогинистость и тп.
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['id'] = $row['id'];	
	//*** после успешного входа, перенаправляем юзера на главную страницу 
	//*** вырезаем путь
	$uri = dirname($_SERVER['PHP_SELF']);
	//*** вызываем перенаправление абсолютным путём, как напмсано в доках
	header("Location: http://{$_SERVER['HTTP_HOST']}$uri/index.php");
} else {
	echo $html->getMess('Логин или пароль неверны!',0,1);
}

$html->GetFooter();
?>
