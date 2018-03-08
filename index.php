<?php
	session_start();
?>
<html>

	<style>
		body {
			background-image: url("images\\backgrnd.jpg");
			background-size: cover;
			background-repeat: no-repeat;
			color: white;				
		}

		.center{
			width: 600px;
			height: 600px;
			position: absolute;
			left: 50%;
			top: 50%; 
			margin-left: -300px;
			margin-top: -300px;
		}
    </style>
<body>
<?php

function showLogin(){

	echo "<div class = 'center'>
	<table>

			<form name='main' method='post' action='index.php'>
			<tr><td>Email Address: </td>
			<td><input name='email' type='text' size='50'></td>
			</tr>
			
			<tr><td>Password: </td>
			  <td><input name='password' type='text' size='50'></td>
			</tr>
			
			</table>

	<table style='padding-left: 175px; padding-top: 20px'>
		<tr>
	
			
			<td colspace='2'><input name='btnsubmit' type='submit' value='Login'></td>
		</form>
			
			<form name='new' action='bin/newuser.php'>
			<td colspace='2'><input name='newuser' type='submit'
	 value='Create Account'></td>
			</tr>
	</table>
	</form>
</div>             ";

}
	

checkUser();

function checkUser(){

unset($_SESSION['name']);
unset($_SESSION['email']);

	if(isset($_POST["email"])){
		if(isset($_POST["password"])){
			$results = checkdb();
			if($results == 1){ 
		 		$_SESSION['email'] = $email;
				if(checkAdmin() == TRUE){
					$page = "admin";
					header('Location: bin/admin.php');
					include "bin/flip.php";
				}else{
					$page = "store";
					include "bin/flip.php";
					//header('Location: http://localhost/week7/store.php');

				}
		
			
			}else{
				echo "<h2>No User Found</h2>";			
			}
		}
	}
	showLogin();

}
//Checks to see if the input belongs to a user in the database
function checkdb(){

	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Customers WHERE email = '.'"'. $_POST["email"].'" AND passwd = '.'"' . $_POST["password"].'"';

	$result = $mysqli->query($mysearch);
	$size = $result->num_rows;
	
	if($size > 0){
		$row = $result->fetch_assoc();
	
		$_SESSION['name'] = $row['firstName'];
	}
	$mysqli->close();
	return $size;

}
//Admin should always be ID 0 in the database.
//This method checks to see if the user details that were input are admin login details.
function checkAdmin(){
	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Customers WHERE IDnum=0';

	$result = $mysqli->query($mysearch);
	$size = $result->num_rows;
	
	$row = $result->fetch_assoc();

	if($row['email'] === $_POST['email']){

		if($row['passwd'] === $_POST['password']){
			$mysqli->close();
			return TRUE;
		}
	}

	$mysqli->close();
	return FALSE;

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
	//$mydbparms = getDbparms();

	// Try to connect
	//$mysqli = new mysqli($mydbparms->getHost(), $mydbparms->getUsername(),
	//$mydbparms->getPassword(),$mydbparms->getDb());

	include "config.php";
	$mysqli = new mysqli(HOST, UNAME, PWORD, DB);

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
