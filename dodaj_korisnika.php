<?php
	session_start();
	include("baza.php");
	$veza = spojiSeNaBazu();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='Monika Žunec'>
		<meta name='date' content='26.07.2022.'>
		<title>Novi korisnik</title>
		<link href='dizajn.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<h2 id="naslov">Unesite novog korisnika:</h2> 
<div class="obrazac">
		<form name="novi_korisnik"  id="novi_korisnik" method="POST" action="dodaj_korisnika.php" >
			<label for="tip_korisnika">Odaberite tip korisnika: </label><br/>
				<input name="tip_korisnika" id="tip_korisnika" type="radio" value=0/>Administrator
				<input name="tip_korisnika" id="tip_korisnika" type="radio" value=1/>Moderator
				<input name="tip_korisnika" id="tip_korisnika" type="radio" value=2 checked="checked" />Korisnik<br/>
			<label for="ime">Ime: </label><br/>
				<input name="ime" id="ime" type="text" required="required"/><br/>
			<label for="prezime">Prezime: </label><br/>
				<input name="prezime" id="prezime" type="text" required="required"/><br/>
			<label for="email">E-mail: </label><br/>
				<input name="email" id="email" type="email"/><br/>
			<label for="korisnicko_ime">Korisničko ime: </label><br/>
				<input name="korisnicko_ime" id="korisnicko_ime" type="text" required = "required" /><br/>
			<label for="lozinka">Lozinka: </label><br/>
				<input name="lozinka" id="lozinka" type="text" required = "required"/></br>
			<input class="gumb"  type="submit" name="unos_korisnika" id="unos_korisnika" 
					   value="Unesi korisnika" />
		</form>
		<form action="korisnici.php" method="POST">
				<input class="gumb" type="submit" name="odustani" id="odustani" 
					   value="Odustani" />
		</form>
	</div>
	</body>
</html>

<?php

	if(isset($_POST['unos_korisnika'])){
		$korisnik_tip = $_POST['tip_korisnika'];
		$ime =  $_POST['ime'];
		$prezime = $_POST['prezime'];
		$email =  $_POST['email'];
		$korime = $_POST['korisnicko_ime'];
		$lozinka = $_POST['lozinka'];
		header("Location: korisnici.php");
	
		$upit="INSERT INTO korisnik VALUES ('','$korisnik_tip','','$korime', '$ime', '$prezime','$email','$lozinka')";
		$rezultat=izvrsiUpit($veza,$upit);
	}
?>

		


	
	
	