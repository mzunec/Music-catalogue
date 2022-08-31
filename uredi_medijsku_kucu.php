<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if(isset($_GET["medijska_kuca_id"])){
		$upit="SELECT * FROM medijska_kuca WHERE medijska_kuca_id='".$_GET["medijska_kuca_id"]."'";
		$rezultat=izvrsiUpit($veza,$upit);
		while($red=mysqli_fetch_array($rezultat)){
			$naziv=$red["naziv"];
			$opis=$red["opis"];
		}
	}
?>


<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='06.08.2022.'>
		<title>Uredi medijsku kuću</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<h1 id="naslov">Uredi medijsku kuću</h1>
	<div class="obrazac">
		<form name="uredi_medijsku_kucu" id="uredi_medijsku_kucu" method="POST" action="uredi_medijsku_kucu.php">
			<label for="id_medijske_kuce_update">ID:</label><br>
				<input name="id_medijske_kuce_update" id="id_medijske_kuce_update" type="number" readonly value="<?php echo $_GET['medijska_kuca_id'] ?>" /><br>
			<label for="naziv_update">Naziv: </label><br>
				<input name="naziv_update" id="naziv_update" type="text" required = "required" value="<?php if(isset($_GET["medijska_kuca_id"])) { echo $naziv; } ?>" /><br/>
			<label for="opis_update">Opis: </label><br>
				<input name="opis_update" id="opis_update" type="text" required = "required" value="<?php if(isset($_GET["medijska_kuca_id"])) { echo $opis; } ?>" /><br/>
			<input class="gumb" type="submit" name="update_medijske_kuce" id="update_medijske_kuce" value="Spremi" />
			<input class="gumb" type="submit" name="delete_medijske_kuce" id="delete_medijske_kuce" value="Izbriši" />			
		</form>
		<form method="POST" action="medijske_kuce.php">
			<input class="gumb" type="submit" name="odustani" id="odustani" value="Odustani">
		</form>
	</div>
<?php

	if(isset($_POST["update_medijske_kuce"])){
		$upit="UPDATE medijska_kuca SET naziv='".$_POST["naziv_update"]."', opis='".$_POST["opis_update"]."' 
		WHERE medijska_kuca_id='".$_POST["id_medijske_kuce_update"]."'";
		$rezultat=izvrsiUpit($veza,$upit);
		header("Location: medijske_kuce.php");
	}
	
	if(isset($_POST["delete_medijske_kuce"])){
		$upit="DELETE FROM medijska_kuca WHERE medijska_kuca_id='".$_POST["id_medijske_kuce_update"]."'";
		$rezultat=izvrsiUpit($veza,$upit);
		header("Location: medijske_kuce.php");
	}
?>