<html>
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms";



// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($_GET)
{

if(isset($_GET["s"]))
{
	header("Location:search.php");
}

if(isset($_GET["l"]))
{
	session_destroy();
	header("Location:user_login.php");
}

}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">

  <button type="submit" name="s">Search Book</button>
  <button type="submit" name="l">Logout</button>
</form>
</html>