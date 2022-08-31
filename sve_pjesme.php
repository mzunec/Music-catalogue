<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if (isset($_POST['filtriraj'])) {
		$pocetak = $_POST['pocetak'];
		$zavrsetak = $_POST['zavrsetak'];
	} else {
		$pocetak = date("Y-m-d H:i:s", strtotime("2020-03-10 12:12:00"));
		$zavrsetak = date("Y-m-d H:i:s");
	}
	
	if (isset($_GET['id'])) {
    $upit="SELECT * FROM korisnik WHERE korisnik_id=".$_SESSION['id'];
    $rezultat=izvrsiUpit($veza,$upit);
    $red=mysqli_fetch_assoc($rezultat);

    $upit="UPDATE pjesma SET medijska_kuca_id=".$red['medijska_kuca_id']." WHERE pjesma_id=".$_GET['id'];
    $rezultat=izvrsiUpit($veza,$upit);
}

?>

<?php if (isset($_SESSION['id']) && isset($_SESSION['korime'])) {
				if($_SESSION['tip'] == 0) { ?>
			<p class="korisnik">Administrator: <?php print $_SESSION['ime'] ?></p>
				<?php } elseif ($_SESSION['tip'] == 1) { ?>
			<p class="korisnik">Moderator: <?php print $_SESSION['ime'] ?></p>
				<?php } elseif ($_SESSION['tip'] == 2) {?>
			<p class="korisnik">Korisnik: <?php print $_SESSION['ime'] ?></p>
			<?php } ?> <?php } ?>

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
		<form class='filter' name="filter" id="filter" style="margin-left: 10%; margin-right: 10%;" method='POST' action='sve_pjesme.php'>
			<div style="float:left; width:25%;">
			<label for='datum_od' style="font-weight: bolder;">Datum i vrijeme kreiranja (od):</label><br>
				<input type='text' style="width: 70%; text-align: center; padding: 0px;" name='datum_od' id='datum_od' value="<?php print date("d.m.Y H:i:s", strtotime($pocetak)); ?>">
			</div>
			<div style="float:left; width:25%;">
			<label for='datum_do' style="font-weight: bolder;">Datum i vrijeme kreiranja (do):</label><br>
				<input type='text' style="width: 70%; text-align: center; padding: 0px;" name='datum_do' id='datum_do' value="<?php print date("d.m.Y H:i:s", strtotime($zavrsetak)); ?>">
			</div>
			<div style="float:left; width:50%;">
			<label for='med_kuc' style="font-weight: bolder;">Medijska kuća:</label><br>
			<?php
				$upit="SELECT * FROM medijska_kuca";
				$rezultat=izvrsiUpit($veza,$upit);
					foreach($rezultat as $v) {
						print "<input type='checkbox' name='med_kuc[]' value='".$v['medijska_kuca_id']."'>".$v['naziv']."";
					}
			?>
			</div>
			<br>
			<br>
			<input class="gumb" style="margin-left: 30%; margin-right: 30%;" type="submit" name="filter" id="filter" value="Filtriraj">
		</form>
			<table border=1 class='tablica'>
				<tr class='zaglavlje-tablice'>
					<th>Naziv</th>
					<th>Kreirana</th>
					<th>Medijska kuća</th>
					<th>Korisnik</th>
					<th>Kupnja</th>
					<th>Uređivanje</th>
				</tr>
				
<?php			
		$veza = spojiSeNaBazu();
		
			if(isset($_POST['filter'])){
				$pocetak=date("Y-m-d H:i:s", strtotime($_POST['datum_od']));
				$zavrsetak=date("Y-m-d H:i:s", strtotime($_POST['datum_do']));
				//$medijska_kuca=$_POST['med_kuc'];
				$oznaceno=implode(',', $_POST['med_kuc']);
				
				$upit="SELECT pjesma_id, naziv, pjesma.medijska_kuca_id, datum_vrijeme_kreiranja, datum_vrijeme_kupnje, CONCAT (ime,' ',prezime) 
						AS korisnik FROM korisnik, pjesma WHERE pjesma.medijska_kuca_id IN (".$oznaceno.") AND datum_vrijeme_kreiranja 
						BETWEEN '$pocetak' AND '$zavrsetak' AND
						pjesma.korisnik_id = korisnik.korisnik_id";
			
				$rezultat=izvrsiUpit($veza,$upit);

				if(mysqli_num_rows($rezultat)){
					while($red=mysqli_fetch_assoc($rezultat)){
				
						$pjesma_id=$red["pjesma_id"];
						$naziv=$red["naziv"];
						$kreirana=$red["datum_vrijeme_kreiranja"];
						$kupljena=$red["datum_vrijeme_kupnje"];
						$korisnik=$red['korisnik'];
						$medijska_kuca=$red['medijska_kuca_id'];
						
						if(isset($_SESSION['tip']) && $_SESSION['tip']==1) {
							if(empty($kupljena) && empty($medijska_kuca)) {
								print "<tr>";
									print "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
									print "<td>" . $kreirana . "</td>";
									print "<td>" . $medijska_kuca . "</td>";
									print "<td>" . $korisnik . "</td>";
									print "<td><a href='sve_pjesme.php?id=".$red['pjesma_id']."'><button id='kupnja' class='gumb'>Kupi</button></a></td>";
									print "<td>-</td>";
								print "</tr>";
							} elseif(empty($kupljena) && !empty($medijska_kuca)) {
								print "<tr style='background-color: #4d3b38; color: #b99f9b'>";
									print "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
									print "<td>" . $kreirana . "</td>";
									print "<td>" . $medijska_kuca . "</td>";
									print "<td>" . $korisnik . "</td>";
									print "<td>Kupnja zatražena</td>";	
									print "<td>-</td>";
								print "</tr>";
							} elseif (!empty($medijska_kuca) && !empty($kupljena)){
								print "<tr style='background-color: #4d3b38; color: #b99f9b'>";
									print "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
									print "<td>" . $kreirana . "</td>";
									print "<td>" . $medijska_kuca . "</td>";
									print "<td>" . $korisnik . "</td>";
									print "<td>Kupljena</td>";
									print "<td>-</td>";
							print "</tr>";
							}
						} elseif(isset($_SESSION['tip']) && $_SESSION['tip']==2) {
							print "<tr>";
								print "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
								print "<td>" . $kreirana . "</td>";
								print "<td>" . $medijska_kuca . "</td>";
								print "<td>" . $korisnik . "</td>";
								print "<td>-</td>";
								print "<td>-</td>";
							print "</tr>";
						} elseif(isset($_SESSION['tip']) && $_SESSION['tip']==0){
							print "<tr>";
								print "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
								print "<td>" . $kreirana . "</td>";
								print "<td>" . $medijska_kuca . "</td>";
								print "<td>" . $korisnik . "</td>";
								print "<td>-</td>";
								print "<td><form method='POST'><a href='uredi_pjesmu.php?pjesma_id=" . $red['pjesma_id'] . "'><button type='button' class='gumb'>Uredi</button></td>";
							print "</tr>";
						}
					}
				}
		} else {
			$upit="SELECT pjesma_id, naziv, pjesma.medijska_kuca_id, datum_vrijeme_kreiranja, datum_vrijeme_kupnje, CONCAT (ime,' ',prezime) AS korisnik 
			FROM korisnik, pjesma  WHERE pjesma.korisnik_id = korisnik.korisnik_id";	
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
					print "<tr>";
					print "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					print "<td>" . $kreirana . "</td>";
					print "<td>" . $medijska_kuca . "</td>";
					print "<td>" . $korisnik . "</td>";
					print "<td><a href='sve_pjesme.php?id=".$red['pjesma_id']."'><button id='kupnja' class='gumb'>Kupi</button></a></td>";
					print "<td>-</td>";
					print "</tr>";
					} elseif(empty($kupljena) && !empty($medijska_kuca)) {
					print "<tr style='background-color: #4d3b38; color: #b99f9b'>";
					print "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					print "<td>" . $kreirana . "</td>";
					print "<td>" . $medijska_kuca . "</td>";
					print "<td>" . $korisnik . "</td>";
					print "<td>Kupnja zatražena</td>";	
					print "<td>-</td>";
					print "</tr>";
					} elseif (!empty($medijska_kuca) && !empty($kupljena)){
					print "<tr style='background-color: #4d3b38; color: #b99f9b'>";
					print "<td><a style='color: #b99f9b;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					print "<td>" . $kreirana . "</td>";
					print "<td>" . $medijska_kuca . "</td>";
					print "<td>" . $korisnik . "</td>";
					print "<td>Kupljena</td>";
					print "<td>-</td>";
					print "</tr>";
					}
			} elseif(isset($_SESSION['tip']) && $_SESSION['tip']==2) {
					print "<tr>";
					print "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					print "<td>" . $kreirana . "</td>";
					print "<td>" . $medijska_kuca . "</td>";
					print "<td>" . $korisnik . "</td>";
					print "<td>-</td>";
					print "<td>-</td>";
					print "</tr>";
			} elseif(isset($_SESSION['tip']) && $_SESSION['tip']==0){
					print "<tr>";
					print "<td><a style='color: black;' href='pjesme_detaljno.php?id=$pjesma_id'>" . $naziv . "</a></td>";
					print "<td>" . $kreirana . "</td>";
					print "<td>" . $medijska_kuca . "</td>";
					print "<td>" . $korisnik . "</td>";
					print "<td>-</td>";
					print "<td><form method='POST'><a href='uredi_pjesmu.php?pjesma_id=" . $red['pjesma_id'] . "'><button type='button' class='gumb'>Uredi</button></td>";
					print "</tr>";
		}
	} print "</table>";
		}
		}
	print "</body>";
zatvoriVezuNaBazu($veza);
?>
		
		
		
		