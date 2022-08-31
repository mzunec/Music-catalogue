<?php
	include("baza.php");
	session_start();
?>

<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='18.07.2022.'>
		<title>Kupljene pjesme</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form method='POST' action='index.php'>
			<input class='gumb' style='margin-left: 5px; float: left;' type='submit' name='povratak' id='povratak' value='Povratak' />
		</form>
			<table border=1 class='tablica'>
				<tr class='zaglavlje-tablice'>
					<th>Naziv</th>
					<th>Audio zapis</th>
					<th>Korisnik</th>
					<th>Broj sviđanja</th>
				</tr>
				
<?php			
		$veza = spojiSeNaBazu();
				
		$upit="SELECT korime AS korisnik, naziv, poveznica, broj_svidanja, pjesma.medijska_kuca_id 
		FROM korisnik, pjesma
		WHERE pjesma.korisnik_id = korisnik.korisnik_id 
		AND pjesma.medijska_kuca_id IS NOT NULL 
		ORDER BY broj_svidanja DESC";	
		$rezultat=izvrsiUpit($veza,$upit);
				
		if(mysqli_num_rows($rezultat)){
			while($red=mysqli_fetch_assoc($rezultat)){
				$naziv=$red["naziv"];
				$poveznica=$red["poveznica"];
				$korisnik=$red['korisnik'];
				$broj_svidanja=$red["broj_svidanja"];
					echo "<tr>";
					echo "<td>" . $naziv . "</td>";
					echo "<td><audio controls><type='audio/mp3'></td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>" . $broj_svidanja . "</td>";
					echo "</tr>";
				} echo "</table>";
			}
			if(isset($_SESSION['id'])){ 
				echo "<a href='kreiraj_pjesmu.php'>";
			echo "<input class='gumb' style='position: relative; left: 80%;' type='submit' name='dodaj_pjesmu' id='dodaj_pjesmu' value='Kreiraj pjesmu' />";
				echo "</a>";
			}
	echo "</body>";
	
zatvoriVezuNaBazu($veza);
?>
		
		
		