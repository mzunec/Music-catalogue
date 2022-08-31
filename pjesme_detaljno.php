<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if(isset($_GET['id_like'])) {
    $upit="UPDATE pjesma SET broj_svidanja=broj_svidanja+1 WHERE pjesma_id=".$_GET['id'];
    $rezultat=izvrsiUpit($veza,$upit);
}
?>

<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='29.07.2022.'>
		<title>Detalji pjesme</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
			<h2 id="naslov">Detalji pjesme</h2>
		<form method='POST' action='sve_pjesme.php'>
			<input class='gumb' style='margin-left: 5px; margin-top: 2%; float: left;' type='submit' name='povratak' id='povratak' value='Povratak' />
		</form>
		<div style="border: 2px solid black; margin-left:10%; margin-right:10%; margin-top: 2%; margin-bottom: 2%; text-align: center; background-color: #C79F81; font-family: Source Sans Pro; font-size: 20px;">
<?php

	$upit_pjesma="SELECT * FROM pjesma WHERE pjesma_id='".$_GET['id']."'";
	$rezultat_pjesma=izvrsiUpit($veza,$upit_pjesma);
	$red_pjesma=mysqli_fetch_assoc($rezultat_pjesma);
	
	$upit_korisnik="SELECT * FROM korisnik WHERE korisnik_id='".$red_pjesma['korisnik_id']."'";
	$rezultat_korisnik=izvrsiUpit($veza,$upit_korisnik);
	$red_korisnik=mysqli_fetch_assoc($rezultat_korisnik);
	
			echo "<h3>Naziv pjesme:</h3>";
			echo $red_pjesma['naziv'];
			echo "<h3>Datum i vrijeme kreiranja pjesme:</h3>";
			echo $red_pjesma['datum_vrijeme_kreiranja'];
			echo "<h3>Broj sviđanja pjesme:</h3>";
			echo $red_pjesma['broj_svidanja'];
			echo "<h3>Audio zapis:</h3>";
			echo "<audio controls><source src='" . $red_pjesma['poveznica'] . "' type='audio/mp3'></audio>";
			echo "<h3>Opis pjesme:</h3>";
			echo $red_pjesma['opis'];
			echo "<h3>Korisnik koji je kreirao pjesmu:</h3>";
			echo $red_korisnik['ime']." ".$red_korisnik['prezime'];
			
	if(!empty($red_pjesma['medijska_kuca_id'])){
		$upit_medijska="SELECT * FROM medijska_kuca WHERE medijska_kuca_id='".$red_pjesma['medijska_kuca_id']."'";
		$rezultat_medijska=izvrsiUpit($veza,$upit_medijska);
		$red_medijska=mysqli_fetch_assoc($rezultat_medijska);
	
		echo "<h3>Medijska kuća (vlasnik pjesme):</h3>";
			echo $red_medijska['naziv'];
	} else {
		echo "<h3>Medijska kuća (vlasnik pjesme):</h3>";
			echo "-";
	}
	
			echo "<br>";
			echo "<br>";
			echo "<a href='pjesme_detaljno.php?id=".$_GET['id']."&id_like=".$_GET['id']."'><button id='like' class='gumb'>Sviđa mi se</button></a>";
		?>	
		</div>
	</body>
</html>