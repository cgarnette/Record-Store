<html>

	<style>
		body {
			background-image: url("images\\backgrnd.jpg");
			background-size: cover;
			background-repeat: no-repeat;
			color: white;				
		}
    </style>
<body>
<h2>Update</h2>

<?php

if(isset($_POST['music'])){
	performUpdate();
}
else if(isset($_POST['0'])){
	update();
}

else{
	showOptions();
}



function showOptions(){

	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Products';
	$result = $mysqli->query($mysearch);
	$i = 0;

	echo "<table><form action='update.php' method='post'>
		<tr>";
	while($row = $result->fetch_assoc()){
		if($i < 3){
			echo "<td colspan=2><img src=" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['ProdId'] . "'></td>";
		}if($i == 3){
			$i = 0;
			echo "</tr><tr><td colspan=2><img src=" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['ProdId'] . "'></td>";
		}
		$i = $i + 1;
	}
	$mysqli->close();

	echo "<tr>
		<td ><input name='btnupdate' type='submit' value='Update' ></td></form></tr></table>";
}

//The title of this method is misleading. What it does is this:
//this method first checks to see if data has been posted by the form.
//It then displays the data for the selected items and allows it to be changed.
//
//Specifically: the loop starting on line 55 iterates over an array that was retrieved via POST from showOptions. 
//The array is of Product IDs. These Ids are then added to a string that will be used to query the sql database.
//The result of the query will be the items that have their data displayed.
function performUpdate(){

	if(isset($_POST['music'])){
		$mysqli = connectdb();
		$i = 0;
		$request = 'SELECT * FROM Products WHERE ProdId= ';
		foreach($_POST['music'] as $item ){
			if($i > 0){
				$request .= ' OR ProdId= ';
			}
			$request .= $item ;
			$i = $i + 1;
		}

		$result = $mysqli->query($request);
		$q = 0;
		echo "<form action='update.php' method='post'>";
		while($row = $result->fetch_assoc()){
			echo"<table><tr><td><img src= ". $row['image'] ." width='100' height='100'></td></tr>
<tr><td>Product Name: <input name=" . $q . "[] type='text' size='50' value='".$row['name']."'></td></tr>
<tr><td>Product Description: <input name=" . $q . "[] type='text' size='100' value='".$row['description']."'></td></tr>
<tr><td>Price: <input name=" . $q . "[] type='text' size='50' value='".$row['price']."'></td></tr>
<tr><td>Image Source: <input name=" . $q . "[] type='text' size='50' value='".$row['image']."'></td></tr>
<tr><td>Product ID: <input name=" . $q . "[] type='text' size='50' value='".$row['ProdId']."' readonly></td></tr>";
		$q = $q + 1;
		}
		echo "<tr><td ><input name='btnupdate' type='submit' value='Update' ></td></form></tr></table>";
		$mysqli->close();
	}

}

//Performs the actual update operation.
function update(){
	$mysqli = connectdb();
	$i = 0;

	while(isset($_POST[$i])){
		$name = '';
		$image='';
		$desc='';
		$price=0.0;
		$image='';
		$ID=0;
		
		$counter = 0;
		foreach($_POST[$i] as $item){
			
			if($counter == 0){
				$name = $item;			
			}else if($counter==1){$desc=$item;}else if($counter==2){$price = $item;}else if($counter==3){$image = $item;}
			else if($counter==4){$ID = $item;}
			$counter = $counter + 1;	
		}

		$request = "UPDATE Products SET name='".$name."', description='".$desc."', price=".$price.", image='".$image."' WHERE ProdId=".$ID;
		echo $request;
		$result = $mysqli->query($request);
		$i = $i + 1;
	}
	header('Location: http://localhost/week7/admin.php');
}

function getDbparms()
{
	$trimmed = file('parms/dbparms.txt', FILE_IGNORE_NEW_LINES |
	FILE_SKIP_EMPTY_LINES);
	$key = array();

	$vals = array();
	foreach($trimmed as $line){
		$pairs = explode("=",$line);
		$key[] = $pairs[0];
		$vals[] = $pairs[1];
	}

	// Combine Key and values into an array
	$mypairs = array_combine($key,$vals);
	// Assign values to ParametersClass
	$myDbparms = new DbparmsClass($mypairs['username'],$mypairs['password'],
	$mypairs['host'],$mypairs['db']);

	// Display the Paramters values
	return $myDbparms;
}

function connectdb() {
	// Get the DBParameters
	$mydbparms = getDbparms();

	// Try to connect
	$mysqli = new mysqli($mydbparms->getHost(), $mydbparms->getUsername(),
	$mydbparms->getPassword(),$mydbparms->getDb());

	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
		. $mysqli->connect_error);
echo "<h2>error connecting</h2>";
	}

	return $mysqli;
}



class DBparmsClass
{
	// property declaration
	private $username="";
	private $password="";
	private $host="";
	private $db="";
	// Constructor
	public function __construct($myusername,$mypassword,$myhost,$mydb)
	{
		$this->username = $myusername;
		$this->password = $mypassword;
		$this->host = $myhost;
		$this->db = $mydb;
	}
	// Get methods
	public function getUsername ()
	{
		return $this->username;
	}
	public function getPassword ()
	{
		return $this->password;
	}
	public function getHost ()
	{
		return $this->host;
	}
	public function getDb ()
	{
		return $this->db;
	}
	// Set methods
	public function setUsername ($myusername)
	{
		$this->username = $myusername;
	}
	public function setPassword ($mypassword)
	{
		$this->password = $mypassword;
	}
	public function setHost ($myhost)
	{
		$this->host = $myhost;
	}
	public function setDb ($mydb)
	{
		$this->db = $mydb;
	}
} // End DBparms class



?>




</body>
</html>
