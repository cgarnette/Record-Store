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
			  <td><input name='password' type='password' size='50'></td>
			</tr>
			
			</table>

	<table style='padding-left: 175px; padding-top: 20px'>
		<tr>
	
			
			<td colspace='2'><input name='btnsubmit' type='submit' value='Login'></td>
		</form>
			
			<form name='new' action='pages/newuser.php'>
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
					header('Location: pages/admin.php');
					//include "bin/flip.php";
				}else{
					$page = "store";
					header('Location: pages/store.php');

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

function connectdb() {

	include "config.php";
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
