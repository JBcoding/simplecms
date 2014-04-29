<?php require_once('Connection.php'); ?>
<?php require_once("Functions.php"); ?>

<?php require_once("Header.php"); ?>

<?php

$mail = trim(mysql_prep($_GET["mail"]));
$key = trim(mysql_prep($_GET["key"]));

$mysql_query = "UPDATE `user` SET `ConfirmLink`='Confirmed' WHERE `ConfirmLink`='" . $key . "' AND `mail`='" . $mail . "'";
$result = mysql_query($mysql_query, $connection);

if($result) {
	//Succes
	echo '<h1>Confirmed</h1>
	<h3>Your email has been verified</h3>
	<form>
		<p><a href="index.html">Click here to go back to login</a></p>
	</form>
	';
} else {
	//Fail
	echo "<h1>Unknown error</h1>";
}

?>

<?php include("Footer.php"); ?>