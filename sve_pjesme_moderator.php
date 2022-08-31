<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if (isset($_POST['filter'])) {
		$pocetak = $_POST['pocetak'];
		$zavrsetak = $_POST['zavrsetak'];
	} else {
		$pocetak = date("Y-m-d H:i:s", strtotime("2020-03-10 12:12:00"));
		$zavrsetak = date("Y-m-d H:i:s");
	}

?>

<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='29.07.2022.'>
		<title>Popis pjesama</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form method='POST' action='index.php'>
			<input class='gumb' style='margin-left: 5px; float: left;' type='submit' name='povratak' id='povratak' value='Povratak' />
		</form>
		<form class='obrazac' style="border: 1px solid black;" name="filter" id="filter" style="margin-left: 10%; margin-right: 10%;" method='POST' action='sve_pjesme.php'>
			<label for='datum_od'>Datum i vrijeme kreiranja (od):</label>
				<input type='text' name='datum_od' id='datum_od' value="<?php echo date("d.m.Y H:i:s", strtotime($pocetak)); ?>"><br>
			<label for='datum_do'>Datum i vrijeme kreiranja (do):</label>
				<input type='text' name='datum_do' id='datum_do' value="<?php echo date("d.m.Y H:i:s", strtotime($zavrsetak)); ?>"><br>
			<label for='med_kuc'>Medijska kuća:</label>
			<select name='med_kuc' id='med_kuc'>
			<?php
				$upit="SELECT * FROM medijska_kuca";
				$rezultat=izvrsiUpit($veza,$upit);
					echo "<option selected='selected' value='-1'>Sve medijske kuće</option>";
					foreach($rezultat as $v) {
						echo "<option value='".$v['medijska_kuca_id']."'>".$v['naziv']."</option>";
					}
			?>
			</select><br>
			<input class="gumb" type="submit" name="filter" id="filter" value="Filtriraj">
		</form>
			<table border=1 class='tablica'>
				<tr class='zaglavlje-tablice'>
					<th>Naziv</th>
					<th>Kreirana</th>
					<th>Medijska kuća</th>
					<th>Korisnik</th>
					<th>Kupnja</th>
				</tr>
<?php			
		$veza = spojiSeNaBazu();
		
		if(isset($_POST['filter'])){
				$pocetak=$_POST['datum_od'];
				$zavrsetak=$_POST['datum_do'];
				$medijska_kuca=$_POST['med_kuc'];
				
				$upit="SELECT * FROM pjesma WHERE medijska_kuca_id=".$medijska_kuca." AND datum_vrijeme_kreiranja BETWEEN '".$pocetak."' AND '".$zavrsetak."'";
				$rezultat=izvrsiUpit($veza,$upit);
				
				if(mysqli_num_rows($rezultat)){
					while($red=mysqli_fetch_assoc($rezultat)){
						$pjesma_id=$red["pjesma_id"];
						$naziv=$red["naziv"];
						$medijska_kuca=$red["medijska_kuca_id"];
						$kreirana=$red["datum_vrijeme_kreiranja"];
						$kupljena=$red["datum_vrijeme_kupnje"];
						$korisnik=$red["korisnik_id"];
				
					if(isset($_SESSION['tip']) && $_SESSION['tip']==1) {
						if(empty($kupljena) && empty($medijska_kuca)) {
							echo "<tr>";
								echo "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
								echo "<td>" . $kreirana . "</td>";
								echo "<td>" . $medijska_kuca . "</td>";
								echo "<td>" . $korisnik . "</td>";
								echo "<td><form name='kupnja' method='GET' action='sve_pjesme.php?id=".$red['pjesma_id']."'><input type='submit' name='kupnja' id='kupnja' value='Kupi'></form></td>";
								echo "<td>-</td>";
					echo "</tr>";
					} elseif(empty($kupljena) && !empty($medijska_kuca)) {
					echo "<tr style='background-color: #4d3b38; color: #b99f9b'>";
					echo "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					echo "<td>" . $kreirana . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>Kupnja zatražena</td>";	
					echo "<td>-</td>";
					echo "</tr>";
					} elseif (!empty($medijska_kuca) && !empty($kupljena)){
					echo "<tr style='background-color: #4d3b38; color: #b99f9b'>";
					echo "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					echo "<td>" . $kreirana . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>Kupljena</td>";
					echo "<td>-</td>";
					echo "</tr>";
					}
					}
					}
				}

		} else {
			$upit="SELECT pjesma_id, naziv, pjesma.medijska_kuca_id, datum_vrijeme_kreiranja, datum_vrijeme_kupnje, CONCAT (ime,' ',prezime) AS korisnik FROM korisnik, pjesma  WHERE pjesma.korisnik_id = korisnik.korisnik_id";	
			$rezultat=izvrsiUpit($veza,$upit);
				
		if(mysqli_num_rows($rezultat)){
			while($red=mysqli_fetch_assoc($rezultat)){
				
				$pjesma_id=$red["pjesma_id"];
				$naziv=$red["naziv"];
				$medijska_kuca=$red["medijska_kuca_id"];
				$kreirana=$red["datum_vrijeme_kreiranja"];
				$kupljena=$red["datum_vrijeme_kupnje"];
				$korisnik=$red['korisnik'];
			
			
				
				if(isset($_SESSION['tip']) && $_SESSION['tip']==1) {
					if(empty($kupljena) && empty($medijska_kuca)) {
					echo "<tr>";
					echo "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					echo "<td>" . $kreirana . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td><form name='kupnja' method='GET' action='sve_pjesme.php?id=".$red['pjesma_id']."'><input type='submit' name='kupnja' id='kupnja' value='Kupi'></form></td>";
					echo "<td>-</td>";
					echo "</tr>";
					} elseif(empty($kupljena) && !empty($medijska_kuca)) {
					echo "<tr style='background-color: #4d3b38; color: #b99f9b'>";
					echo "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					echo "<td>" . $kreirana . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>Kupnja zatražena</td>";	
					echo "<td>-</td>";
					echo "</tr>";
					} elseif (!empty($medijska_kuca) && !empty($kupljena)){
					echo "<tr style='background-color: #4d3b38; color: #b99f9b'>";
					echo "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					echo "<td>" . $kreirana . "</td>";
					echo "<td>" . $medijska_kuca . "</td>";
					echo "<td>" . $korisnik . "</td>";
					echo "<td>Kupljena</td>";
					echo "<td>-</td>";
					echo "</tr>";
					}
					} echo "</table>";
		}
		}
		}
			if(isset($_SESSION['id'])){ 
				echo "<a href='kreiraj_pjesmu.php'>";
				echo "<button type='button' class='gumb' style='position: relative; left: 80%;'>Kreiraj pjesmu</button>";
				echo "</a>";
			}		
			
		if(isset($_POST['kupnja'])){
			$upit="SELECT * FROM korisnik WHERE korisnik_id=".$_SESSION['id']."";
			$rezultat=izvrsiUpit($veza,$upit);
		if($rezultat){
			$podatak=mysqli_fetch_array($rezultat);
			$upit="UPDATE pjesma SET medijska_kuca_id='".$podatak['medijska_kuca_id']."' WHERE pjesma_id=".$_GET['id']."";
		$rezultat=izvrsiUpit($veza,$upit);
		}
	}
	echo "</body>";
zatvoriVezuNaBazu($veza);
?>