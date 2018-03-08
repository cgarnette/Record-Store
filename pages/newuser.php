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
</head>

<body>



<?php

checkUser();
//makes sure that actual information was input into the fields.
function checkValues(){
	if(strlen(trim($_POST["firstname"])) == 0){
		return false;
	}
	if(strlen(trim($_POST["lastname"])) == 0){
		return false;
	}
	if(strlen(trim($_POST["email"])) == 0){
		return false;
	}
	if(strlen(trim($_POST["password"])) == 0){
		return false;
	}

	return true;
}

function checkUser(){
unset($_SESSION['name']);
unset($_SESSION['email']);

	if(isset($_POST["firstname"])){

		if(isset($_POST["lastname"])){

			if(isset($_POST["email"])){

				if(isset($_POST["password"])){
					$size = getSize();
					$customer = new CustomerClass($size, $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]);
					if(checkNew($customer) > 0){
						//showRegistration();
						echo "<h2>This email has already been used</h2>";
					}else{
						if(checkValues()===TRUE){
							
							$_SESSION['name'] = $firstname; 
		 					$_SESSION['email'] = $email;
							$_SESSION['ID'] = $size;
							insertCustomer($customer);
							header('location: store.php');
						}
						
					}
				}			
			}		
		}	
	}
	showRegistration();
	echo "<h4>Please fill out all fields</h4>";

}

function showRegistration(){
	echo "<table>
		
		<form name='new' method='post' action='newuser.php'>		
		
		<tr><td>First Name: </td>
		<td><input name='firstname' type='text' size='50'></td>
		</tr>
		
		<tr><td>Last Name: </td>
  		<td><input name='lastname' type='text' size='50'></td>
		</tr>

		<tr><td>Email Address: </td>
		<td><input name='email' type='text' size='50'></td>
		</tr>
		
		<tr><td>Password: </td>
  		<td><input name='password' type='text' size='50'></td>
		</tr>

		
		<td colspace='2' align='center'><input name='createuser' type='submit' value='Submit'></td>

		</form>
	</table>";

}
//Ensures that this is infact a new customer and that the email hasnt already been used
function checkNew($customer){
	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Customers WHERE email = '.'"'. $_POST["email"].'"';
	$result = $mysqli->query($mysearch);
	$size = $result->num_rows;
	$mysqli->close();
	return $size;
}
function getSize(){
	$mysqli = connectdb();
	$mysearch = 'SELECT * FROM Customers';
	$result = $mysqli->query($mysearch);
	$size = $result->num_rows;
	$mysqli->close();
	return $size;
}

function insertCustomer ($customer)
{
echo "<h2>beginning insertion process</h2>";
	// Connect to the database
	$mysqli = connectdb();
	$ID = $customer->getID();
	$firstname = $customer->getFirstname();
	$lastname = $customer->getLastname();
	$password = $customer->getPassword();
	$email = $customer->getEmail();


	$Success=false;
	$stmt = $mysqli->prepare("INSERT INTO Customers (IDnum,firstName,lastName,email,passwd) VALUES(?,?,?,?,?)");

	$stmt->bind_param("issss",$ID,$firstname,$lastname,$email,$password);

	$stmt->execute();
	$stmt->close();

    	echo "New record created successfully";
	header('Location: store.php');

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

class CustomerClass
{
	// property declaration
	private $firstname="";
	private $lastname="";
	private $email="";
	private $password="";
	private $ID=0;
	// Constructor
	public function __construct($ID,$firstname,$lastname,$email,$password)
	{
	$this->ID = $ID;
	$this->firstname = $firstname;
	$this->lastname = $lastname;
	$this->email = $email;
	$this->password = $password;
	}
	// Get methods
	public function getID ()
	{
		return $this->ID;
	}
	public function getFirstname ()
	{
		return $this->firstname;
	}
	public function getLastname ()
	{
		return $this->lastname;
	}
	public function getEmail ()
	{
		return $this->email;
	}
	public function getPassword ()
	{
		return $this->password;
	}
	// Set methods
	public function setID ($value)
	{
		$this->ID = $value;
	}
	public function setFirstname ($value)
	{
		$this->firstname = $value;
	}
	public function setLastname ($value)
	{
		$this->lastname = $value;
	}
	public function setEmail ($value)
	{
		$this->email = $value;
	}
	public function setPassword ($value)
	{
		$this->password = $value;
	}
} // End Customerclass

?>


</body>
</html>
