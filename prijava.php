<?php
	session_start();
	require_once("baza.php");
	$veza = spojiSeNaBazu();
	
	$greska="";
	if (isset($_POST['korime']) && isset($_POST['lozinka'])){
		$korime=$_POST['korime'];
		$lozinka=$_POST['lozinka'];
		
		$upit="SELECT * FROM korisnik WHERE korime = '$korime' AND lozinka = '$lozinka'";
		
		$rezultat=mysqli_query($veza,$upit);
		$broj_redova=mysqli_num_rows($rezultat);
		
		if($broj_redova === 1){
			$red = mysqli_fetch_assoc($rezultat);
			if($red['korime'] === $korime && $red['lozinka'] === $lozinka) {
				$_SESSION['korime'] = $red['korime'];
				$_SESSION['ime'] = $red['ime']. " " .$red['prezime'];
				$_SESSION['id'] = $red['korisnik_id'];
				$_SESSION['tip'] = $red['tip_korisnika_id'];
				header("Location: index.php");
			}
			}else {
				$greska="Korisničko ime ili lozinka nisu ispravni!";
		}
	}
?>

<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Monika Žunec">
		<meta name="date" content="12.06.2022.">
		<title>Glazbeni katalog</title>
		<link href="dizajn.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<h1 id="naslov">Prijava<h1>
		<form class="obrazac" name="prijava" id="prijava" method="POST" action="prijava.php">
		<?php
            if ($greska != ""){
                echo $greska;
            }
        ?><br>
			<label for="korime">Korisničko ime:</label><br>
			<input name="korime" id="korime" type="text" placeholder="Ovdje unesite korisničko ime."><br>
			<label for="lozinka">Lozinka:</label><br>
			<input name="lozinka" id="lozinka" type="password" placeholder="Ovdje unesite lozinku." required=""><br>
			<input class="gumb" type="submit" name="submit" id="submit" value="Prijava" required=""><br>
		</form>
	</body>
</html>

