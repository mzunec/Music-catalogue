<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if(isset($_GET['pjesma_id'])){
		$upit="SELECT * FROM pjesma WHERE pjesma_id='".$_GET['pjesma_id']."'";
		$rezultat=izvrsiUpit($veza,$upit);
		while($red=mysqli_fetch_array($rezultat)){
			$naziv = $red["naziv"];
			$poveznica = $red["poveznica"];
			$opis = $red["opis"];
		}
	}
?>

<!DOCTPYE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='06.08.2022.'>
		<title>Uredi pjesmu</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<h1 id="naslov">Ažuriraj pjesmu</h1>
	<div class="obrazac">
		<form method="POST" action="uredi_pjesmu.php">
			<label for="uredi_id">ID pjesme: </label><br/>
				<input name="uredi_id" id="uredi_id" type="number" readonly value="<?php echo $_GET["pjesma_id"] ?>" /><br/>
			<label for="uredi_naziv">Naziv pjesme:</label><br>
				<input name="uredi_naziv" id="uredi_naziv" type="text" value="<?php if(isset($_GET["pjesma_id"])) { echo $naziv; } ?>"/><br>
			<label for="uredi_link">Poveznica:</label><br>
				<input style="width: 98%;" name="uredi_link" id="uredi_link" type="url" value="<?php if(isset($_GET["pjesma_id"])) { echo $poveznica; } ?>"/><br>
			<label for="uredi_opis">Opis pjesme:</label><br>
				<textarea name="uredi_opis" id="uredi_opis" cols="6" rows="10"><?php if(isset($_GET["pjesma_id"])) { echo $opis; } ?></textarea><br>
			<input class="gumb" type="submit" name="update_pjesme" id="update_pjesme" value="Uredi">
			<input class="gumb" type="submit" name="delete_pjesme" id="delete_pjesme" value="Izbriši" />
		</form>
		<form method="POST" action="sve_pjesme.php">
			<input class="gumb" type="submit" name="odustani" id="odustani" value="Odustani">
		</form>
	</div>
	</body>
</html>
	
<?php
	if(isset($_POST['update_pjesme'])){
		$upit="UPDATE pjesma SET 
		naziv = '".$_POST["uredi_naziv"]."', 
		poveznica = '".$_POST["uredi_link"]."', 
		opis = '".$_POST["uredi_opis"]."' 
		WHERE pjesma_id = ".$_POST["uredi_id"]."";
		
		$rezultat=izvrsiUpit($veza,$upit);
		header("Location: sve_pjesme.php");
	}
	
	if(isset($_POST["delete_pjesme"])){
		$upit="DELETE FROM pjesma WHERE pjesma_id='".$_POST["uredi_id"]."'";
		$rezultat=izvrsiUpit($veza,$upit);
		header("Location: sve_pjesme.php");
	}
?>
