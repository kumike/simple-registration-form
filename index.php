<?php
session_start();
//***служебные ошибки***
ini_set('display_errors',1);
error_reporting(E_ALL);

//*** автоматическая загрузка нужных класов
spl_autoload_register(function($class){include 'classes/'.$class.'Class.php';});

$html = new Html();
$menu = new Menu();

$html->setTitle('индексная страница');
$html->getHeader(); 

//*** в зависимости от сессионных переменных показываем форму логина или контент для зарегестрированых юзеров
if (empty($_SESSION['login']) or empty($_SESSION['id'])){
	$menu->getMenu();
	$form = new Form('log.php','Войти','Войти');
	$form->getForm();
} else {
	$menu->getLogInMenu();
	echo '<p>Контент для зарегистрированных пользователей. Перевод айпи адреса в бинарное представление.</p>';
	$ipform = new Form('index.php','Перевести','Введите IP адрес');
	$ipform->getIpForm();	

	/*
	* про функцию decbin() я в курсе,
	* можно также вывести двоичное представление числа через функцию printf()
	* понимаю что ip2bin функцию можно было написать чуток проще
	* просто ради фана решил реализовать свой велосипед перевода десятичного числа в двоичное
	* функция принимает на вход строку с корректным айпи адресом
	* например $_SERVER['HTTP_HOST']
	*/
	function ip2bin($ipstr){
		$iarr = explode('.',$ipstr);
		$binarr = [];
		$ipbin = '';
		foreach ($iarr as $k => $num){
			$binary = '';
			//*** этим циклом переводим десятичное число в бинарь
			while ($num>0){
				$val = $num/2;
				//*** отбрасываем дробную часть, можно сравнение сделать через деление по модулю, но так меньше операций
				$inte = intval($val);				
				if ($val == $inte){
					$binary = '0'.$binary;
					$num = $inte;
				} else {
					$binary = '1'.$binary;
					$num = $inte;
				}
			}
			//*** если получилось число большее 8 бит(считаем по одному октету) знач адрес ввели некоректный, возвращаем сообщение
			if (strlen($binary) > 8){
				return '<span style="color:red">Это значение не является ip адресом!</span>';
			} 
			//*** добавляем недостающие ноли в начало
			if (strlen($binary) < 8){
				$bit = 8 - strlen($binary);
				while ($bit > 0){
					$binary = '0'.$binary;
					$bit--;
				}
			}
			//*** добавляем значения переменной в масив по номеру ключа исодного масива
			$binarr[$k] = $binary;
			//*** собираем строку с бинарным представлением адреса, отсекая точку после 4 октета
			if ($k < 3){
				$ipbin .= $binarr[$k].'.';
			} else {
				$ipbin .= $binarr[$k];
				}
		}//end foreach
		return $ipbin;
	}//end func

	//*** проверка и вызов
	if (isset($_POST['ip'])){
		//*** полностью проверить коректность ип адреса регуляркой пока не осилил, может както можно
		if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',$_POST['ip'])){
			$ipstr = $_POST['ip'];
			#echo '<p style="margin-top:64px;border:1px solid">ASDFGHJ<div id="pip"><p>'.ip2bin($ipstr).'</p></div></p>';
			echo '<div id="pip"><p>'.ip2bin($ipstr).'</p></div>';
		} else {
			echo '<div id="pip"><p><span style="color:red">ONO this value is not ip address!!</span></p></div>';
		}
	}
}//end else
$html->getFooter();
