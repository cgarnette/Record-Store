<html>

	<style>
                body {
                    background-image: url("../images\\backgrnd.jpg");
                    background-size: cover;
                    background-repeat: no-repeat;
                    color: white;				
                }
    </style>
<body>



<?php

if(isset($_POST['name'])){
	insertproduct();
}

showform();

function showform(){

	echo "<table>
		
		<form name='new' method='post' action='add.php'>		
		
		<tr><td>Product Name: </td>
		<td><input name='name' type='text' size='50'></td>
		</tr>
		
		<tr><td>Item Description: </td>
  		<td colspan='2'><input name='description' type='text' size='50'></td>
		</tr>

		<tr><td>Price: </td>
		<td><input name='price' type='text' size='50'></td>
		</tr>
		
		<tr><td>Image Location: </td>
  		<td><input name='image' type='text' size='50'></td>
		</tr>

		
		<td colspace='2' align='center'><input name='createproduct' type='submit' value='Add'></td>

		</form>
	</table>";

}

//Returns the number of rows in the table
function getSize(){
	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Products';
	$result = $mysqli->query($mysearch);
	$size = $result->num_rows;
	$mysqli->close();
	return $size;
}

function insertProduct ()
{

	// Connect to the database
	$mysqli = connectdb();
	$ID = getSize() - 1;
	$name = $_POST['name'];
	$desc = $_POST['description'];
	$price = $_POST['price'];
	$image = $_POST['image'];
echo "<h2>beginning insertion process</h2>";

	$Success=false;
	$stmt = $mysqli->prepare("INSERT INTO Products (ProdId,name,description,price,image) VALUES(?,?,?,?,?)");

	$stmt->bind_param("issds",$ID,$name,$desc,$price,$image);

	$stmt->execute();
	$stmt->close();

    	echo "New record created successfully";
	header('Location: admin.php');

	$mysqli->close();
	return $Success;
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
