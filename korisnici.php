<body>
	<table border="1" class='tablica'>
		<caption id='naslov'>Pregled korisnika</caption>
			<tbody class='tijelo-tablice'>
			<tr class='zaglavlje-tablice'>
				<th>ID</th>
				<th>Ime</th>
				<th>Prezime</th>
				<th>Tip korisnika</th>
				<th>Medijska kuća</th>
				<th>Uređivanje</th>
				<th>Dodjela</th>
			</tr>
<?php
	include("zaglavlje.php");
	
    $veza =spojiSeNaBazu();
	
	$rezultati_po_stranici = 10;
    $upit = "SELECT * FROM korisnik";
    $rezultat=izvrsiUpit($veza, $upit);
	$broj_rezultata=mysqli_num_rows($rezultat);
	
	$broj_stranica=ceil($broj_rezultata/$rezultati_po_stranici);
	
	if(!isset($_GET["stranica"])){
		$stranica = 1;
	} else {
		$stranica = $_GET["stranica"];
	}
	
	$inicijalna=($stranica-1)*$rezultati_po_stranici;
	
	$upit = "SELECT * FROM korisnik ORDER BY tip_korisnika_id LIMIT ".$inicijalna.",".$rezultati_po_stranici;
	$rezultat=izvrsiUpit($veza, $upit);	
	if(mysqli_num_rows($rezultat)){
		while($red=mysqli_fetch_assoc($rezultat)){
				
			$id=$red["korisnik_id"];
			$ime=$red["ime"];
			$prezime=$red["prezime"];
			$tip=$red["tip_korisnika_id"];
			$medijska_kuca=$red["medijska_kuca_id"];
			$korime=$red["korime"];
			
		if(isset($_SESSION['tip']) && $_SESSION['tip'] == 0){
			echo "<tr>
				<td>$id</td>
				<td>$ime</td>
				<td>$prezime</td>
				<td>$tip</td>
				<td>$medijska_kuca</td>";
			echo "<td>
					<form method='POST'><a href='uredi_korisnika.php?korisnik_id=" . $red['korisnik_id'] . "'>
					<button type='button' class='gumb'>Uredi</button></td>";
				if(isset($red["tip_korisnika_id"]) && $red["tip_korisnika_id"]==1){
			echo "<td>
					<form method='POST'><a href='dodijeli_medijsku_kucu.php?korisnik_id=" . $red['korisnik_id'] . "'>
					<button type='button' class='gumb'>Dodijeli medijsku kuću</button></td>";
				}
			echo "</tr>";
			
		} else {
			echo "<tr>
				<td>$id</td>
				<td>$ime</td>
				<td>$prezime</td>
				<td>$tip</td>
				<td>$medijska_kuca</td>
				<td>-</td>
				<td>-</td>
				</tr>";
		}
		}
	}
		echo "</tbody>";
		echo "</table>";
	
	echo "<div class='stranicenje'>";
		for($stranica = 1; $stranica<=$broj_stranica; $stranica++) {  
			echo '<a class="stranicenje-veza" href = "korisnici.php?stranica='.$stranica.'">'.$stranica.'</a>';  
		}
	echo "</div>";
    zatvoriVezuNaBazu($veza);	
?>