<?php
	session_start();
	include_once("baza.php");
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
		<nav>
			<a class="veza" href="index.php">Početna stranica</a>
			<a class="veza" href="o_autoru.html">O autoru</a>
				<?php if(isset($_SESSION['tip']) && $_SESSION['tip'] == 0){ ?>
			<a class="veza" href="pjesme_korisnika.php">Moje pjesme</a>
			<a class="veza" href="korisnici.php">Korisnici</a>
			<a class="veza" href="dodaj_korisnika.php">Dodaj korisnika</a>
			<a class="veza" href="medijske_kuce.php">Medijske kuće</a>
			<a class="veza" href="dodaj_medijsku_kucu.php">Dodaj medijsku kuću</a>
			<a class="veza" href="kreiraj_pjesmu.php">Kreiraj pjesmu</a>
				<?php } elseif (isset($_SESSION['tip']) && $_SESSION['tip'] == 1){?>
			<a class="veza" href="pjesme_korisnika.php">Moje pjesme</a>
			<a class="veza" href="zatrazene_pjesme.php">Pjesme moje medijske kuće</a>
			<a class="veza" href="kreiraj_pjesmu.php">Kreiraj pjesmu</a>
				<?php } elseif (isset($_SESSION['tip']) && $_SESSION['tip'] == 2){?>
			<a class="veza" href="pjesme_korisnika.php">Moje pjesme</a>
			<a class="veza" href="kreiraj_pjesmu.php">Kreiraj pjesmu</a>
				<?php } ?>
				<?php if(isset($_SESSION['id'])){ ?>
			<a class="veza" style="position:absolute; left:90%"; href="odjava.php">Odjava</a> <br>
				<?php }else{ ?>
			<a class="veza" style="position:absolute; left:90%"; href="prijava.php">Prijava</a> <br>
				<?php } ?>
		</nav>
		<body>
			<?php if (isset($_SESSION['id']) && isset($_SESSION['korime'])) {
				if($_SESSION['tip'] == 0) { ?>
			<p class="korisnik">Administrator: <?php echo $_SESSION['ime'] ?></p>
				<?php } elseif ($_SESSION['tip'] == 1) { ?>
			<p class="korisnik">Moderator: <?php echo $_SESSION['ime'] ?></p>
				<?php } elseif ($_SESSION['tip'] == 2) {?>
			<p class="korisnik">Korisnik: <?php echo $_SESSION['ime'] ?></p>
			<?php } ?> <?php } ?>
	</body>
</html>