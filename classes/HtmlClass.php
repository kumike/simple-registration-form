<?php
class Html{
	protected $title;
#	public $footer; 
	
#	function __construct(){
#		$this->footer = $this->constFooter();
#	}

	function setTitle($title){
		$this->title = $title;
	}

	function getHeader(){
		echo <<<EOT
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<!--[if lte IE 8]>
    <script>
      document.createElement("header");
      document.createElement("footer");
    </script>
    <![endif]-->
	<link rel="stylesheet" href="css/style.css">
   	<title>{$this->title}</title>
</head>
<body>
<div id="container">\n
EOT;
	}

	function getFooter(){
		$date = date('Y');
		echo <<<EOT
\n<footer id="footer">
	<p>PHP7 Powered :) &copy {$date}</p>
</footer>
</div>
</body>
</html>
EOT;
	}

#	function getFooter(){
#		echo $this->footer;
#	}

	function getMess($mess,$opt = 0,$patch = 0,$value = 0){
		$id = $opt ? 'ok' : 'error';
		$href = $patch ? 'index.php' : 'regform.php';
		$val = $value ? 'Главная' : 'Назад' ;
		return <<<EOT
<div id='{$id}'>
	<p>{$mess}</p>
</div>
<div id="lback">
	<p><span id="button"><a href='{$href}'>{$val}</a></span></p>
</div>
EOT;
	}
	
	function getIpMess(){
		
	}
}// end class

?>
