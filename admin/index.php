<?php
session_start();
include 'files/functions/functions.php';
include 'files/functions/db_connect.php';

if (isset($_GET['nav']) && file_exists('files/' . $_GET['nav'] . '.php')) {

	$pagina = $_GET['nav'];
} else {
	header("Location: http://projecthanze.com/admin/home");
}
?>
<div id="header">
	<?php include 'files/header.php'; ?>
</div>
<div id="menu">
	<?php include 'files/menu.php'; ?>
</div>

<div id="center">
	<?php

	if (empty($pagina)) {
		include("files/home.php");
		header("Location: http://projecthanze.com/admin/home");
	} else {
		include("files/" . $pagina . ".php");
	}

	?>
</div>




