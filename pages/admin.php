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
	session_start();
	if(isset($_SESSION['name'])){
		echo '<h3>Admin Page</h3>';
		//showProducts();
	}else{
		header('Location: ../index.php');
	}
	
?>

</head>
<body>



<?php

$delete = false;
showProducts();

//After performing a delete there may be an inconsistency with the IDs. this method fixes that
function updateID(){
	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Products';
	$result = $mysqli->query($mysearch);
	$i = 0;

	while($row = $result->fetch_assoc()){
		$update = 'UPDATE Products SET ProdId= '.$i.' WHERE ProdId= '.$row['ProdId'];
		$fix = $mysqli->query($update);
	}
	$mysqli->close();
}

function showProducts(){

	updateID();
	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Products';
	$result = $mysqli->query($mysearch);
	$i = 0;

	echo "<table>
		<tr>";
	while($row = $result->fetch_assoc()){
		if($i < 3){
			echo "<td colspan=2><img src=../" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['ProdId'] . "'></td>";
		}if($i == 3){
			$i = 0;
			echo "</tr><tr><td colspan=2><img src=../" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['ProdId'] . "'></td>";
		}
		$i = $i + 1;
	}
	$mysqli->close();

	echo "<tr>
  <form action='update.php' method='post'><td ><input name='btnupdate' type='submit' value='Update'></td></form>
<form action='delete.php' method='post'><td ><input name='btndelete' type='submit' value='Delete' ></td></form>
<form action='add.php' method='post'><td ><input name='btnAdd' type='submit' value='Add'></td></form></tr></table>";

	//echo "</tr></form></table>";
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
