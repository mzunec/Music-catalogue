<?php 
session_start();

session_unset();
session_destroy();

header("odjava.php");
?>

<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Monika Žunec">
		<meta name="date" content="21.07.2022.">
		<title>Glazbeni katalog</title>
		<link href="dizajn.css" rel="stylesheet" type="text/css">
	</head>
	<body style="text-align: center; margin-top: 150px; font-size: 45px; color: #210203;">
		<h1 style="font-family: Source Sans Pro;">Uspješno ste se odjavili!</h2>
		<form action="prijava.php">
			<input class="gumb" style="font-size: 25px;"  type="submit" name="ponovna_prijava" id="ponovna_prijava" 
					   value="Ponovo se prijavi" action="prijava.php" />
		</form>
		<form action="index.php">
			<input class="gumb" style="font-size: 25px;"  type="submit" name="gost" id="gost" 
					   value="Nastavi kao gost" action="index.php" />
		</form>
	</body>
</html>