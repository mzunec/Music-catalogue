<?php
	include("zaglavlje.php");	
?>

<!DOCTYPE html>
<html lang="hr">
	<head>
		<title>Glazbeni katalog</title>
		<link rel="stylesheet" type="text/css" href="dizajn.css">
	</head>
	<body>
		<p class="dobrodosli">Dobrodošli na stranice<br>glazbenog kataloga!</p>
			<?php if(!isset($_SESSION['id'])){ ?>
		<form method="POST" action="kupljene_pjesme.php">
			<input class="gumb" style="margin-left: 25px" type="submit" name="kupljene_pjesme" id="kupljene_pjesme" value="Prikaži sve kupljene pjesme" />
		</form>	
			<?php } else {?>
		<form method="POST" action="sve_pjesme.php">
			<input class="gumb" style="margin-left: 25px" type="submit" name="popis_pjesama" id="popis_pjesama" value="Prikaži sve pjesme" />
		</form>	
			<?php } ?>
	</body>
</html>


	
