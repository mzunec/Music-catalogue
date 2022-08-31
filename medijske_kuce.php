<body>
	<table border="1" class='tablica'>
		<caption id='naslov'>Pregled medijskih kuća</caption>
			<tbody class='tijelo-tablice'>
			<tr class='zaglavlje-tablice'>
				<th>Naziv</th>
				<th>Opis</th>
				<th>Uređivanje</th>
			</tr>
<?php
	include("zaglavlje.php");	
    $veza =spojiSeNaBazu();

    $upit = "SELECT medijska_kuca_id, naziv, opis FROM medijska_kuca";
    $rezultat=izvrsiUpit($veza, $upit);
	

	if(mysqli_num_rows($rezultat)){
		while($red=mysqli_fetch_assoc($rezultat)){
			$naziv=$red["naziv"];
			$opis=$red["opis"];
			$medijska_kuca_id=$red["medijska_kuca_id"];
			
		echo"<tr>
            <td>$naziv</td>
			<td>$opis</td>
			<td><form method='GET'><a href='uredi_medijsku_kucu.php?medijska_kuca_id=" . $red['medijska_kuca_id'] . "'><button type='button' class='gumb'>Uredi</button></td>
			</tr>";
		}
		echo "</tbody>";
	}
	echo "</table>";

	if(isset($_SESSION['tip']) && $_SESSION['tip']==0){
?>
<table border=1 class="tablica" style="margin-bottom: 2px;">
<caption id='naslov'>Broj sviđanja po medijskim kućama</caption>
				<tr class="zaglavlje-tablice">
					<th>Naziv medijske kuće</th>
					<th>Broj sviđanja</th>
				</tr>
<?php
	
	$upit="SELECT m.naziv,SUM(p.broj_svidanja) as ukupan_broj_svidanja FROM pjesma p, medijska_kuca m WHERE p.medijska_kuca_id=m.medijska_kuca_id AND p.datum_vrijeme_kupnje IS NOT NULL GROUP BY p.medijska_kuca_id";
	$rezultat=izvrsiUpit($veza,$upit);
	
	if(mysqli_num_rows($rezultat)){
		while($red=mysqli_fetch_assoc($rezultat)){
			$naziv=$red['naziv'];
			$broj_svidanja=$red['ukupan_broj_svidanja'];
			
			if(isset($_SESSION['tip']) && $_SESSION['tip']==0) {
				echo "<tr>";
					echo "<td>" . $naziv . "</a></td>";
					echo "<td>" . $broj_svidanja . "</td>";
				echo "</tr>";
			}
        }
    }
	echo "</table>";
	}
?>	
	</body>
</html>
<?php
	echo "</body>";
    zatvoriVezuNaBazu($veza);	
?>




