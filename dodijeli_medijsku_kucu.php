<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if(isset($_GET["korisnik_id"])){
		$upit="SELECT * FROM korisnik WHERE korisnik_id='".$_GET["korisnik_id"]."'";
		$rezultat=izvrsiUpit($veza,$upit);
		while($red=mysqli_fetch_array($rezultat)){
			$medijska_kuca_id=$red['medijska_kuca_id'];
		}
	}
	
	if(isset($_POST['dodijeli'])){
		$nova_medijska_kuca=$_POST['odaberi_kucu'];
		$azuriraj_id=$_POST['azuriraj_id'];
		$upit="UPDATE korisnik SET medijska_kuca_id='".$nova_medijska_kuca."' WHERE korisnik_id='".$azuriraj_id."'";
		$rezultat=izvrsiUpit($veza,$upit);
		header("Location: korisnici.php");
	}
?>

<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Monika Žunec">
		<meta name="date" content="11.08.2022.">
		<title>Dodjela moderatora</title>
		<link rel="stylesheet" type="text/css" href="dizajn.css">
	</head>
	<body>
		<h2 id="naslov">Dodjela moderatora</h2> 
		<div class="obrazac">
		<form name="moderator"  id="moderator" method="POST" action="dodijeli_medijsku_kucu.php" >
			<label for="odaberi_kucu">Odaberite medijsku kuću: </label><br>
			<?php if(isset($medijska_kuca_id) && $medijska_kuca_id==1){ ?>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=1 checked="checked"/>Novi pokret<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=2/>Klasika<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=3/>Rokaši studio<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=4/>Mild One<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=5/>Folklor<br>
			<?php } ?>
			<?php if(isset($medijska_kuca_id) && $medijska_kuca_id==2){ ?>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=1/>Novi pokret<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=2 checked="checked"/>Klasika<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=3/>Rokaši studio<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=4/>Mild One<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=5/>Folklor<br>
			<?php } ?>
			<?php if(isset($medijska_kuca_id) && $medijska_kuca_id==3){ ?>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=1/>Novi pokret<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=2/>Klasika<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=3 checked="checked"/>Rokaši studio<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=4/>Mild One<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=5/>Folklor<br>
			<?php } ?>
			<?php if(isset($medijska_kuca_id) && $medijska_kuca_id==4){ ?>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=1/>Novi pokret<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=2/>Klasika<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=3/>Rokaši studio<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=4 checked="checked"/>Mild One<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=5/>Folklor<br>
			<?php } ?>
			<?php if(isset($medijska_kuca_id) && $medijska_kuca_id==5){ ?>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=1/>Novi pokret<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=2/>Klasika<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=3/>Rokaši studio<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=4/>Mild One<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=5 checked="checked"/>Folklor<br>
			<?php } ?>
			<?php if(isset($medijska_kuca_id) && empty($medijska_kuca_id)){ ?>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=1/>Novi pokret<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=2/>Klasika<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=3/>Rokaši studio<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=4/>Mild One<br>
				<input name="odaberi_kucu" id="odaberi_kucu" type="radio" value=5/>Folklor<br>
			<?php } ?>
			<input type="hidden" name="azuriraj_id" id="azuriraj_id" value="<?php if(isset($_GET["korisnik_id"])) echo $_GET["korisnik_id"]; ?>">
			<input class="gumb" type="submit" name="dodijeli" id="dodijeli" value="Dodijeli medijsku kuću" />
		</form>
		<form method="POST" action="korisnici.php">
			<input class="gumb" type="submit" name="odustani" id="odustani" value="Odustani" />
		</form>	
		</div>
	</body>
</html>


