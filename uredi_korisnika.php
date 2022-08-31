<?php
	include("baza.php");
	session_start();
	
	$veza=spojiSeNaBazu();
	
	if(isset($_GET['korisnik_id'])){
		$upit="SELECT * FROM korisnik WHERE korisnik_id='".$_GET['korisnik_id']."'";
		$rezultat=izvrsiUpit($veza,$upit);
		while($red=mysqli_fetch_array($rezultat)){
			$ime = $red["ime"];
			$prezime = $red["prezime"];
			$tip = $red["tip_korisnika_id"];
			$email = $red["email"];
			$korime = $red["korime"];
		}
	}
?>
<!DOCTPYE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='06.08.2022.'>
		<title>Uredi korisnika</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<h1 id="naslov">Uredi korisnika</h1>
	<div  class="obrazac" >
		<form method="POST" action="uredi_korisnika.php">
			<label for="uredi_id">ID korisnika: </label><br/>
				<input name="uredi_id" id="uredi_id" type="number" readonly value="<?php echo $_GET['korisnik_id'] ?>" /><br/>
			<label for="uredi_tip_korisnika">Tip korisnika:</label><br>
		<?php if(isset($tip) && $tip==0){ ?>
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=0 checked="checked"/>Administrator
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=1/>Moderator
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=2/>Korisnik<br/>
		<?php } ?>
		<?php if(isset($tip) && $tip==1){ ?>
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=0/>Administrator
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=1 checked="checked"/>Moderator
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=2/>Korisnik<br/>
		<?php } ?>
		<?php if(isset($tip) && $tip==2){ ?>
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=0 checked="checked"/>Administrator
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=1/>Moderator
				<input name="uredi_tip_korisnika" id="uredi_tip_korisnika" type="radio" value=2 checked="checked"/>Korisnik<br/>
		<?php } ?>
			<label for="uredi_ime">Ime:</label><br>
				<input name="uredi_ime" id="uredi_ime" type="text" value="<?php if(isset($_GET["korisnik_id"])) { echo $ime; } ?>"/><br>
			<label for="uredi_prezime">Prezime:</label><br>
				<input name="uredi_prezime" id="uredi_prezime" type="text" value="<?php if(isset($_GET["korisnik_id"])) { echo $prezime; } ?>"/><br>
			<label for="uredi_email">Email:</label><br>
				<input name="uredi_email" id="uredi_email" type="text" value="<?php if(isset($_GET["korisnik_id"])) { echo $email; } ?>"/><br>
			<label for="uredi_korime">Korisničko ime:</label><br>
				<input name="uredi_korime" id="uredi_korime" type="text" value="<?php if(isset($_GET["korisnik_id"])) { echo $korime; } ?>"/><br>
			<br>
			<input class="gumb" type="submit" name="unesi_korisnika" id="unesi_korisnika" value="Spremi">
			<input class="gumb" type="submit" name="delete_korisnika" id="delete_korisnika" value="Izbriši">
		</form>
		<form action="korisnici.php" method="POST">
				<input class="gumb" type="submit" name="odustani" id="odustani" value="Odustani" />
		</form>
	</div>
	</body>
</html>

<?php
	
	if(isset($_POST['unesi_korisnika'])){
		$novi_id=$_POST["uredi_id"];
		$novi_ime=$_POST["uredi_ime"];
		$novi_prezime=$_POST["uredi_prezime"];
		$novi_email=$_POST["uredi_email"];
		$novi_tip=$_POST["uredi_tip_korisnika"];
		$novi_korime=$_POST["uredi_korime"];
		header("Location: korisnici.php");
		
		$upit="UPDATE korisnik SET 
		ime = '".$novi_ime."', 
		prezime = '".$novi_prezime."', 
		email = '".$novi_email."', 
		tip_korisnika_id = '".$novi_tip."', 
		korime = '".$novi_korime."'
		WHERE korisnik_id = '".$novi_id."'";
		
		$rezultat=izvrsiUpit($veza,$upit);
		
		if(isset($_POST["uredi_tip_korisnika"]) && $_POST["uredi_tip_korisnika"] !== 1){
			$upit="UPDATE korisnik SET medijska_kuca_id=null WHERE korisnik_id='".$novi_id."'";
			$rezultat=izvrsiUpit($veza,$upit);
		}
	}
	
	if(isset($_POST["delete_korisnika"])){
		$upit="DELETE FROM korisnik WHERE korisnik_id='".$_POST["uredi_id"]."'";
		$rezultat=izvrsiUpit($veza,$upit);
		header("Location: korisnici.php");
	}
?>

		