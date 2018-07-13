<?php
//***служебные ошибки***
ini_set('display_errors',1);
error_reporting(E_ALL);

//*** какая никакая защита от прямого доступа к этому скрипту
if (!isset($_POST['login']) or !isset($_POST['password'])){
	$uri = dirname($_SERVER['PHP_SELF']);
	//*** вызываем перенаправление абсолютным путём, как напмсано в доках
#	header("Location: http://{$_SERVER['HTTP_HOST']}$uri/index.php");
}

//require 'FormClass.php';
//require 'HtmlClass.php';
//require 'MenuClass.php';

//*** автоматическая загрузка нужных класов
spl_autoload_register(function($class){include 'classes/'.$class.'Class.php';});

$html = new Html();
$html->setTitle('Форма регистрации');
$html->getHeader();

$menu = new Menu();
$menu->getMenu();

//*** регистрируем функцию которая сработает после вызова exit или при окончании работы скрипта
//*** важно зарегестрировать до вызовов exit. функция выводит футер страницы
register_shutdown_function('exite');

//*** если было незаполнено поле формы то $_POST['login'] содержит пустую строку, 
//*** в таком случае isset() возвращает true (пустая строка !=NULL) потому проверяем на пустое значение 
//*** и если пустое (не заполнено поле формы) выходим и пишем сообщение,
//*** если поле формы было заполнено, чистим значение от нежелательных символом
//*** и назначаем значение переменной $login.
//*** Что интересно если в поле логин содержит 0 или "0" то empty возвращает true, тоесть пользователя с логином 0 не зарегаем :)

var_dump($_POST['login']);
var_dump(empty($_POST['login']));
var_dump(isset($_POST['login']));

//if ($_POST['login'] == '0' or empty($_POST['login'])){
	$login = empty($_POST['login']) ? exit($html->getMess('Введите логин!')) : trim(stripslashes(htmlentities($_POST['login'],ENT_QUOTES)));
//} elseif (empty($_POST['login'])){
//	echo $messageLogin;
//}

//*** также проверяем поле формы с паролем только не чистим его, 
//*** в нем приветствуются разные символы и он шифруется перед записью в базу
if (empty($_POST['password'])){
	exit($html->getMess('Введите пароль!'));
}
if (empty($_POST['password2'])){
	exit($html->getMess('Введите подтверждение пароля!'));
}
//*** проверяем чи сходятся введённый пароли
if ($_POST['password'] != $_POST['password2']){
	exit($html->getMess('Введённые пароли не совпадают!'));
}
//*** ели не сработали екситы то пост[пасворд] существует, значит хешируем значение и назаначаем его переменной
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

//*** проверяем уникальность логина юзера ***
//*** создаем объект подключения к базе
include 'pdodb.php';
//*** подготавливаем мускуел запрос и выполняем его
$result = $dbh->prepare("SELECT id FROM user WHERE login=:login");
$result->execute([':login'=>$login]);
//*** достаем строку с нужными значениями из обьекта PDOStatement который вернул запрос,
//*** по умолчанию PDO::FETCH_BOTH то есть и по номеру и по имени можно обращатся
$row = $result->fetch();
if (isset($row['id'])) {
    //*** если такой пользователь уже есть пишем сообщение
    exit($html->getMess('Пользователь с таким логином уже существует!'));
}

//*** если такого логина нету (exit не сработал) заносим в базу регданные нового пользователя
$insert = $dbh->prepare("INSERT INTO user (login, password) VALUES (:login,:Password)");
$insert->execute([':login'=>$login,':Password'=>$password]);
echo $html->getMess('Вы успешно зарегестрировались!',1,1,1);

//*** исполняется после срабатывания exit или при конце работы скрипта, рисует футер
function exite(){
	global $html;
//	$html->getfooter(); //*** работает
	call_user_func([$html,'getFooter']); //*** и так тоже срабатывает
}

?>
