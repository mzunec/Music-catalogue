<?php
	session_start();
	include("baza.php");
	$veza = spojiSeNaBazu();
?>

<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Monika Žunec">
		<meta name="date" content="20.07.2022.">
		<title>Nova pjesma</title>
		<link rel="stylesheet" type="text/css" href="dizajn.css">
	</head>
	<body>
		<h2 id="naslov">Nova pjesma:</h2> 
		<div class="obrazac">
		<form name="nova_pjesma"  id="nova_pjesma" method="POST" action="kreiraj_pjesmu.php" >
				<label for="naziv">Naziv pjesme: </label>
					<input style="width: 90%" name="naziv" id="naziv" type="text" required="required"/><br/>
				<label for="poveznica">Poveznica: </label>
					<input style="width: 90%" name="poveznica" id="poveznica" type="url" required="required" placeholder="https://www.poveznicadopjesme.mp3"/><br/>
				<label for="opis">Opis pjesme: </label>
					<textarea style="width: 90%" name="opis" id="opis" rows="5" cols="40" required="required"></textarea><br/>
				<input class="gumb"  type="submit" name="unos_pjesme" id="unos_pjesme"
					   value="Kreiraj pjesmu" />
		</form>
		<form action="sve_pjesme.php" method="POST">
				<input class="gumb" type="submit" name="odustani" id="odustani" 
					   value="Odustani" />
		</form>	
		</div>
	</body>
</html>

<?php

	if(isset($_POST['unos_pjesme'])){
		$korisnik = $_SESSION['id'];
		$naziv =  $_POST['naziv'];
		$poveznica = $_POST['poveznica'];
		$opis =  $_POST['opis'];
		$datum = date("Y-m-d H:i:s");
		header("Location: sve_pjesme.php");
	
		$upit="INSERT INTO pjesma VALUES ('','$korisnik',NULL,'$naziv', '$poveznica', '$opis',	'$datum',NULL,'')";
		$rezultat=izvrsiUpit($veza,$upit);
	}
?>

