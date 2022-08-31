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
		<title>Nova medijska kuća</title>
		<link rel="stylesheet" type="text/css" href="dizajn.css">
	</head>
	<body>
		<h2 id="naslov">Nova medijska kuća:</h2> 
		<div class="obrazac">
		<form name="nova_kuca"  id="nova_kuca" method="POST" action="dodaj_medijsku_kucu.php" >
				<label for="naziv_nova">Naziv medijske kuce: </label>
					<input style="width: 90%" name="naziv_nova" id="naziv_nova" type="text" required="required"/><br/>
				<label for="opis_nova">Opis medijske kuce: </label>
					<textarea style="width: 90%" name="opis_nova" id="opis_nova" rows="5" cols="40" required="required"></textarea><br/>
				<input class="gumb"  type="submit" name="unos_medijske_kuce" id="unos_medijske_kuce"
					   value="Dodaj medijsku kucu" />
		</form>
		<form action="medijske_kuce.php" method="POST">
				<input class="gumb" type="submit" name="odustani" id="odustani" 
					   value="Odustani" />
		</form>	
		</div>
	</body>
</html>

<?php

	if(isset($_POST['unos_medijske_kuce'])){
		$naziv = $_POST['naziv_nova'];
		$opis =  $_POST['opis_nova'];
		header("Location: medijske_kuce.php");
	
		$upit="INSERT INTO medijska_kuca VALUES ('','$naziv','$opis')";
		$rezultat=izvrsiUpit($veza,$upit);
	}		
?>


