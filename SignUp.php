<?php require_once('Connection.php'); ?>
<?php require_once("Functions.php"); ?>

<?php include("Header.php"); ?>

<?php

$message = "";
$Login = false;

if (isset($_POST['submit'])) { // Form has been submitted.

	// form data
	$password = trim(mysql_prep($_POST['password']));
	$passwordConfirm = trim(mysql_prep($_POST['passwordConfirm']));
	$mail = trim(mysql_prep($_POST['mail']));
	$salt = generate_salt();
	$hashed_password = hash('sha512', $password . $salt);
	
	if(!empty($mail)) {
		if ($password == $passwordConfirm) {
			
			$confirm_link = generate_salt(64);
			
			$mysql_query = "INSERT INTO user 
							(mail, password, salt, ConfirmLink) 
							VALUES ('" . $mail . "', 
							'" . $hashed_password . "', '" . $salt . "', '" . $confirm_link . "')";
			$result = mysql_query($mysql_query, $connection);

			if($result) {
				// Bruger lavet
				send_mail($mail, "Confirm JBID account", "Confirm at link below \n http://www.319.dk/JBID/Confirm.php?mail=" . $mail . "&key=" . $confirm_link);
				$Login = true;
				echo "<h1>Account successfully created check your mail for at confirmation mail</h1>";
			} else {
				// Fejl med databasen detaljer kan ses ved brug af "mysql_error()"
				$message = "E-mail already exists";
			}
		} else {
			//Koder ikke ens
			$message = "The passwords do not match";
		}
	} else {
		// mail ikke god nok
		$message = "E-mail to short";
	}
	
} 
if (!$Login) {
	echo '<h1>Create JBiD</h1>
            <h3>User creation - Got here by accident? Go to <a href="index.php">login</a></h3>
            <form id="createUser" method="post">
            	<p id="error">' . $message . '</p>
                <p>Email</p>
                <input id="mail" type="email" required autofocus name="mail">
                <p>Password</p>
                <input id="password1" type="password" required name="password">
                <p>Confirm password</p>
                <input id="password2" type="password" required name="passwordConfirm">
                <p id="matches"> </p>
                <input id="createButton" type="submit" value="Create account" name="submit">
            </form>';
}
?>

<?php include("Footer.php"); ?>
