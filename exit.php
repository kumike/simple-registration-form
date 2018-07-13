<?php
session_start();
//*** уничтожаем переменные в сессии
unset($_SESSION['login']);
unset($_SESSION['id']);

//*** вызываем перенаправление абсолютным путём, как напмсано в доках
$uri = dirname($_SERVER['PHP_SELF']);
header("Location: http://{$_SERVER['HTTP_HOST']}$uri/index.php");
?>
