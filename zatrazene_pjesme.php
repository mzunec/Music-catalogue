<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='12.08.2022.'>
		<title>Glazbeni katalog</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form method='POST' action='index.php'>
			<input class='gumb' style='margin-left: 5px; float: left;' type='submit' name='povratak' id='povratak' value='Povratak' />
		</form>
		<table border=1 class='tablica'>
			<tr class='zaglavlje-tablice'>
				<th>Naziv</th>
				<th>Poveznica</th>
				<th>Status kupnje</th>
			</tr>

<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if(isset($_SESSION['tip']) && $_SESSION['tip']==1) {
		$upit="SELECT * FROM korisnik WHERE korisnik_id=".$_SESSION['id']."";
		$rezultat=izvrsiUpit($veza,$upit);
		$red=mysqli_fetch_assoc($rezultat);

		$upit="SELECT * FROM pjesma WHERE medijska_kuca_id IS NOT NULL AND medijska_kuca_id='".$red['medijska_kuca_id']."'";
		$rezultat=izvrsiUpit($veza,$upit);
	
	if(mysqli_num_rows($rezultat)==0){
		echo "<tr>";
		echo "<td colspan=5>Vaša medijska kuća nije kupila/zatražila kupnju ni jedne pjesme.</td>";
		echo "</tr>";
	} else {
			while($red=mysqli_fetch_assoc($rezultat)){

				$naziv=$red["naziv"];
				$opis=$red["opis"];
				$poveznica=$red["poveznica"];
				$kupljena=$red["datum_vrijeme_kupnje"];
				$medijska_id=$red["medijska_kuca_id"];
				
				if(!empty($kupljena) && !empty($medijska_id)){
					echo "<tr>";
					echo "<td>" . $naziv . "</td>";
					echo "<td><audio controls><source src='" . $poveznica . "' type='audio/mp3'></audio></td>";
					echo "<td>Kupljena</td>";
					echo "</tr>";
				} elseif(empty($kupljena) && !empty($medijska_id)){
					echo "<tr>";
					echo "<td>" . $naziv . "</td>";
					echo "<td><audio controls><source src='" . $poveznica . "' type='audio/mp3'></audio></td>";
					echo "<td>Zatražena kupnja</td>";
					echo "</tr>";
				}
			}
		}
	}
?>






