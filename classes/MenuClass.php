<?php
class Menu{
	function getMenu(){
		echo <<<EOT
<header id="header">
	<span id="cname">PHP7 Powered :)</span>
	<ul id="nav">
		<li><a id="lnav" href="index.php">Главная</a></li>
        <li><a id="lnav" href="regform.php">Регистрация</a></li>
	</ul>
</header>\n
EOT;
	}
	function getLoginMenu(){
		echo <<<EOT
<header id="header">
	<span id="cname">PHP7 Powered :)</span><span id="lname">Привет, <strong>{$_SESSION['login']}</strong> </span>
	<ul id="nav">
		<li><a id="lnav" href="index.php">Главная</a></li>
        <li><a id="lnav" href="profile.php">Мой профиль</a></li>
        <li><a id="lnav" href="exit.php">Выход</a></li>
	</ul>
</header>\n
EOT;
	}

	function getLogInMenu2(){
		echo <<<EOT
<p>Привет, <strong>{$_SESSION['login']}</strong> 
 | <a href='index.php'>Главная</a> | <a href='profile.php?id={$_SESSION['id']}'>Мой профиль</a> | <a href='exit.php'>Выход</a> | </p> 
EOT;
	}
}

?>
