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
	header('Location: http://localhost/week7/admin.php');

	$mysqli->close();
	return $Success;
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

</body></html>
