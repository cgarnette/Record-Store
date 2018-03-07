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
	session_start();
	if(isset($_SESSION['name'])){
		echo '<h3>Welcome to the Store '.$_SESSION['name'].' </h3></br><form action="login.php" method="post"><input name="btnlogout" type="submit" value="logout"></form>';
		
		start();
	}else{
		header('Location: http://localhost/week7/login.php');
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
			echo "<td colspan=2><img src=" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['price'] . "'></td>";
		}if($i == 3){
			$i = 0;
			echo "</tr><tr><td colspan=2><img src=" . $row['image'] . " width='100' height='100'></br>" . $row['name'] . "</br>$" . $row['price'] . "</br>" ."<input type='checkbox' name='music[]' value='" . $row['price'] . "'></td>";
		}
		$i = $i + 1;
	}
	$mysqli->close();

	echo "<tr>
  <td colspace='3' align='center'><input name='btncheckout' type='submit' value='Checkout'></td></tr></form></table>";
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
