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
    </style>
<head>

<?php
	if(isset($_SESSION['name'])){
		echo '<h3>Welcome to the Store '.$_SESSION['name'].' </h3></br><form action="../index.php" method="post"><input name="btnlogout" type="submit" value="logout"></form>';
		
		start();
	}else{
		echo 'something went wrong';
		//header('Location: ../index.php');
	}
	
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

	echo "<table><form action='store.php' method='post'>
		<tr>";
	while($row = $result->fetch_assoc()){
		if($i < 3){
			echo "<td colspan=2><img src=../" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['price'] . "'></td>";
		}if($i == 3){
			$i = 0;
			echo "</tr><tr><td colspan=2><img src=../" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['price'] . "'></td>";
		}
		$i = $i + 1;
	}
	$mysqli->close();

	echo "<tr>
  <td colspace='3' align='center'><input name='btncheckout' type='submit' value='Checkout'></td></tr></form></table>";
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
