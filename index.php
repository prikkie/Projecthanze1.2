<?php
session_start();
require 'files/functions/db_connect.php';
include "files/winkelmandInit.php";
include "functions/winkelmandVerschil.php";

$cart_products = initCart($conn);

//Kijkt welke pagina opgevraagd is, kijkt of het bestaat, veranderd $pagina. Bestaat deze niet? Gaat de gebruiker naar de home pagina
if (isset($_GET['nav']) && file_exists('files/' . $_GET['nav'] . '.php')) {
	$pagina = $_GET['nav'];
} else {
	header("Location: http://projecthanze.com/home");
}

echo "<div id='header'>";
include 'files/header.php';
echo "</div>";

echo "<div id='menu'>";
include 'files/menu.php';
echo "</div>";

?>
	<div id="body">
		<?php

		// Als $pagina niet geinitialiseerd is, gaat hij terug naar home. Anders geeft hij de $pagina weer.
		if (empty($pagina)) {
			header("Location: http://projecthanze.com/home");
		} else {
			include("files/" . $pagina . ".php");
		}
		?>
	</div>
<?php


?>
    <div class="footer"><?php include 'files/footer.php'; ?></div>
<?php
?>