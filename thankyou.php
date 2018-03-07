<html>

	<style>
		body {
			background-image: url("images\\backgrnd.jpg");
			background-size: cover;
			background-repeat: no-repeat;
			color: white;				
		}
    </style>
<head>

<?php

	echo "<h1>Thank You for your purchase</h1></br>You will be redirected to Login momentarily";

	header('Refresh: 5; url=http://localhost/week7/login.php');

?>

</head>
</html>
