<?php
	require("functions.php");
	
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
		
	}





?>
<h1>Leht</h1>

<?php //echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">logi välja</a>
</p>

