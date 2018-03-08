<html>

	<style>
		body {
			background-image: url("../images\\backgrnd.jpg");
			background-size: cover;
			background-repeat: no-repeat;
			color: white;				
		}
    </style>
<head><h1>Select Items to Remove from Inventory</h1></head>
<body>


<?php

function showOptions(){

	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Products';
	$result = $mysqli->query($mysearch);
	$i = 0;

	echo "<table><form action='delete.php' method='post'>
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
		<td ><input name='btndelete' type='submit' value='Delete' ></td></form></tr></table>";
}


remove();

//This method checks first to see if Data from the form on this page has been posted.
//If no data has been posted then it calls up the form to give the user options for input.
//If Data has been posted then each ID in the dataset is sent to sql as a query.
//Once all operations have been concluded the user is sent back to the admins page.
function remove(){
	
	if(isset($_POST['music'])){
		$mysqli = connectdb();
		$i = 0;
		foreach($_POST['music'] as $item ){
			$mysearch = 'DELETE FROM Products WHERE ProdId = ' . $item;
			$result = $mysqli->query($mysearch);
			$i = $i + 1;
		}

		if($i > 0){
			$i = 0;
			$mysqli->close();
			header('Location: admin.php');
		}
		$mysqli->close();
	}
showOptions();
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

</body></html>
