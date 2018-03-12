<?php
session_start();
?>

<html>

	<style>
		body {
			background-image: url("../images\\backgrnd.jpg");
			background-size: cover;
			background-repeat: no-repeat;
			color: white;				
		}

		.logout {
			float: right;
		}

		img{
			padding-right: 20px;
			padding-left: 20px;
		}

		.checkout{
			position: absolute;
			left: 50%;
			margin-left: -300px;
		}

		.products{
			position: absolute;
			left: 50%;
			margin-left: -300px;
		}
    </style>
<head>

<?php
	if(isset($_SESSION['name'])){

		echo '<div class="logout"><h3>Welcome to the Store '.$_SESSION['name'].' </h3></br><form action="../index.php" method="post"><input name="btnlogout" type="submit" value="logout"></form></div>';
		
		start();
	}else{
		header('Location: ../index.php');
	}
	//onClick='myFunction(".$row['name'].", ".$row['description'].")'>
	
?>
	
</head>
<body>

<?php

$name = $_SESSION['name'];

function start(){
	if(isset($_POST['music'])){
		checkout();
	}else{
		loadStore();
	}
}

function checkout(){
	$total = 0.00;
	foreach($_POST['music'] as $item){
		$total = $total + $item;
	}
	echo "<h3>Your total is: $".$total."</h3></br><form action='thankyou.php' method='post'><input name='btnpurchase' type='submit' value='Purchase'></form>";
}

function loadStore(){

	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Products';
	$result = $mysqli->query($mysearch);
	$i = 0;

	echo "<div class='products'><form action='store.php' method='post'><table>
		<tr>";
	while($row = $result->fetch_assoc()){
		if($i < 5){
			echo "<td colspan=2><img src=../" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['price'] . "'></td>";
		}if($i == 5){
			$i = 0;
			echo "</tr><tr><td colspan=2><img src=../" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['price'] . "'></td>";
		}
		$i = $i + 1;
	}
	$mysqli->close();

	echo "</tr>
		<tr><td><input name='btncheckout' type='submit' value='Checkout'></td></tr></table>
		</form></div>";
}

function connectdb() {

	include "../config.php";
	$mysqli = new mysqli(HOST, UNAME, PWORD, DB);

	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
		. $mysqli->connect_error);
echo "<h2>error connecting</h2>";
	}

	return $mysqli;
}

?>

</body>



</html>
