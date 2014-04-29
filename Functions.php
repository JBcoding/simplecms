<?php

	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" );
		if( $new_enough_php ) { 
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { 
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }

		}
		return $value;
	}

	function generate_salt( $length = 256 ) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, strlen($characters) - 1)];
    		}
		return $randomString;
	}
	
	function send_mail( $to, $subject, $message, $from = 'JBID' ) {
		mail($to, $subject, $message, "From: " . $from);
	}

?>