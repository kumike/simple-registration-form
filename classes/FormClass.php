<?php

class Form{
	protected $value;
	protected $action;
	protected $legend;
	protected $rform;
	protected $strform = '';

	function __construct($action,$value,$legend,$rform=0){
		$this->action = $action;
		$this->value = $value;
		$this->legend = $legend;
		$this->rform = $rform;

		if ($this->rform){
			$this->strform = <<<EOT
			<li>
				<label for="password2">Повторите пароль:</label>
				<input type="password" name="password2" placeholder="Повторно введите пароль">
			</li>
EOT;
		}
}	

	function getForm(){
		echo <<<EOT
<form action="{$this->action}" method="POST">
	<fieldset>
	<legend>{$this->legend}</legend>
		<ol>
			<li>
				<label for="login">Логин:</label>
				<input type="text" name="login" placeholder="Введите логин">
			</li>
			<li>
				<label for="password">Пароль:</label>
				<input type="password" name="password" placeholder="Введите пароль">
			</li>
{$this->strform}
			<li>
				<input type="submit" value="{$this->value}">
			</li>
		</ol>
	</fieldset>
</form>\n
EOT;
	}

	function getIpForm(){
		echo <<<EOT
<form action="{$this->action}" method="post" id="ipform">
	<fieldset>
	<legend>{$this->legend}</legend>
		<ol>
			<li>
				<input type="text" name="ip" placeholder="Введите IP адрес">
			</li>
			<li>
				<input type="submit" value="{$this->value}">
			</li>
		</ol>
	</fieldset>
</form>
EOT;
	}

} // end class
?>

