<?php
	include("baza.php");
	session_start();
	
	$veza = spojiSeNaBazu();

	if(isset($_GET['prihvati'])){
		$datum_kupnje=date("Y-m-d H:i:s");
		$upit="UPDATE pjesma SET datum_vrijeme_kupnje='".$datum_kupnje."' WHERE pjesma_id=".$_GET['prihvati'];
		$rezultat=izvrsiUpit($veza,$upit);
	} else if (isset($_GET['odbaci'])) {
		$upit="UPDATE pjesma SET medijska_kuca_id=NULL WHERE pjesma_id=".$_GET['odbaci'];
		$rezultat=izvrsiUpit($veza,$upit);
	}
?>

<?php if (isset($_SESSION['id']) && isset($_SESSION['korime'])) {
				if($_SESSION['tip'] == 0) { ?>
			<p class="korisnik">Administrator: <?php echo $_SESSION['ime'] ?></p>
				<?php } elseif ($_SESSION['tip'] == 1) { ?>
			<p class="korisnik">Moderator: <?php echo $_SESSION['ime'] ?></p>
				<?php } elseif ($_SESSION['tip'] == 2) {?>
			<p class="korisnik">Korisnik: <?php echo $_SESSION['ime'] ?></p>
			<?php } ?> <?php } ?>
		
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='26.07.2022.'>
		<title>Moje pjesme</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form method='POST' action='index.php'>
			<input class='gumb' style='margin-left: 5px; float: left;' type='submit' name='povratak' id='povratak' 
			value='Povratak' />
		</form>
			<table border=1 class='tablica'>
				<tr class='zaglavlje-tablice'>
					<th>ID</th>
					<th>Korisnik</th>
					<th>Naziv</th>
					<th>Medijska kuća</th>
					<th>Opis</th>
					<th>Kreirana</th>
					<th>Kupljena</th>
					<th>Audio zapis</th>
					<th>Uređivanje</th>
				</tr>
				
<?php			
		$upit="SELECT prezime AS korisnik, pjesma_id, pjesma.medijska_kuca_id, naziv, opis, datum_vrijeme_kreiranja, datum_vrijeme_kupnje, poveznica 
		FROM korisnik, pjesma 
		WHERE pjesma.korisnik_id = korisnik.korisnik_id AND pjesma.korisnik_id='".$_SESSION['id']."'";
		
		$rezultat=izvrsiUpit($veza,$upit);
				
		if(mysqli_num_rows($rezultat)==0){
			echo "<tr>";
			echo "<td colspan='9'> Niste kreirali ni jednu pjesmu</td>";
			echo "</tr>";
		} else {
			while($red=mysqli_fetch_assoc($rezultat)){
				$pjesma_id=$red["pjesma_id"];
				$korisnik=$red["korisnik"];
				$medijska_kuca=$red["medijska_kuca_id"];
				$naziv=$red["naziv"];
				$opis=$red["opis"];
				$datum_kreiranja=$red["datum_vrijeme_kreiranja"];
				$datum_kupnje=$red["datum_vrijeme_kupnje"];
				$poveznica=$red["poveznica"];
				
				if(empty($red["datum_vrijeme_kupnje"]) && !empty($red["medijska_kuca_id"])){
					echo "<tr>";
					echo "<td>" . $pjesma_id . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>" . $naziv . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $opis . "</td>";
					echo "<td>" . $datum_kreiranja . "</td>";
					echo "<td> - </td>";
					echo "<td><audio controls><source src=" . $poveznica . " type='audio/mpeg'></audio></td>";
					echo "<td>";
						echo "<a href='pjesme_korisnika.php?prihvati=".$red['pjesma_id']."'>
								<button class='gumb' name='prihvati' id='prihvati'>Prihvati kupnju</button>
							</a>";
						echo "<a href='pjesme_korisnika.php?odbaci=".$red['pjesma_id']."'>
								<button class='gumb' name='odbaci' id='odbaci'>Odbaci kupnju</button>
							</a>";
					echo "</td>";
					echo "</tr>";
					
				}
				
				if(!empty($red["datum_vrijeme_kupnje"]) && !empty($red["medijska_kuca_id"])){ 
					echo "<tr>";
					echo "<td>" . $pjesma_id . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>" . $naziv . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $opis . "</td>";
					echo "<td>" . $datum_kreiranja . "</td>";
					echo "<td>" . $datum_kupnje . "</td>";
					echo "<td><audio controls><source src=" . $poveznica . " type='audio/mpeg'></audio></td>";
					echo "<td> - </td>";
					echo "</tr>";
				}
				
				if(empty($red["datum_vrijeme_kupnje"]) && empty($red["medijska_kuca_id"])){ 
					echo "<tr>";
					echo "<td>" . $pjesma_id . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>" . $naziv . "</td>";
					echo "<td> - </td>";
					echo "<td>" . $opis . "</td>";
					echo "<td>" . $datum_kreiranja . "</td>";
					echo "<td> - </td>";
					echo "<td><audio controls><source src='" . $poveznica . "' type='audio/mpeg'></audio></td>";
					echo "<td><form method='POST'><a href='uredi_pjesmu.php?pjesma_id=" . $red['pjesma_id'] . "'>
							<button type='button' class='gumb'>Uredi</button>
						</td>";
					echo "</tr>";	
				}
			}
		} echo "</table>"; 
	echo "</body>";
	
zatvoriVezuNaBazu($veza);
?>