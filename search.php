<!DOCTYPE HTML>  
<html>
<head>
<script>
function setdepartment(valueToSet)
{

	var selectObj = document.getElementById("department");
	for (var i = 0; i < selectObj.options.length; i++) 
	{
        if (selectObj.options[i].value== valueToSet) 
		{
            selectObj.options[i].selected = true;
            return;
        }
    }
}
function setsubject(valueToSet)
{
	
	var selectObj = document.getElementById("subject");
	
	for (var i = 0; i < selectObj.options.length; i++) {
        if (selectObj.options[i].value== valueToSet) {
            selectObj.options[i].selected = true;
            return;
        }
    }
}

</script
</head>
<body>
<?php
session_start();
    
    $servername=$username=$password=$conn=$db="";
$uname=$_SESSION['login_user'];
    echo $_SESSION['login_user'];
?> 
<?php
	//prompt function
    function alertmsg($alt_msg){
        echo("<script type='text/javascript'> 
			alert('".$alt_msg."'); </script>");
    }
?>
<?php
	$sql=$sql1="";
	$Department=$Subject=$Book="";
	$flag=0;

$servername = "localhost";
$username = "root";
$password = "";
$db="lms";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	Department:
	<select name="department" id="department" oninput="this.form.submit()">
		<option value="Select One">Select one </option>
<?php
	$Department=$_POST['department'];
	//echo "asfakdngklnsd";
	echo $Department;
	if(!isset($_POST["department"])) {
	$sql = "SELECT DISTINCT department FROM book_detail";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<option value=". $row["department"] .">" . 
					$row["department"] ."</option>";
		}
		
	}
	}
	if(isset($_POST["department"])) {
		if(!empty($_POST["department"])) {
		
		$Department=$_POST["department"];
		//echo "aa".$Problem;
		$sql = "SELECT DISTINCT department FROM book_detail";
		$result = mysqli_query($conn, $sql);	
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<option value=". $row["department"] .">" . 
					$row["department"] ."</option>";
			}
		}
		echo("<script type='text/javascript'>
				setdepartment('".$Department."'); </script>");
		
		} 
	
	}
?>  
	</select>
	<br/>
	Subject: <select name="subject" id="subject" onchange="this.form.submit()">
		<option value="Select One">Select one </option>
<?php 
	if(isset($_POST["department"])) {
		//echo "dqwdqwd";
		if(!empty($_POST["department"]) ) {
		$Department=$_POST["department"];
		$Subject=$_POST["subject"];
		
		$sql = "SELECT DISTINCT subject FROM book_detail where department='$Department'";
		$result = mysqli_query($conn, $sql);
		  //echo "<option value=\"Select One\">Select one </option>";
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<option value=". $row["subject"] .">" . 
					$row["subject"] ."</option>";
			}
			
		}
		else {
		//echo "dqwdqwd";	
				echo "<option value=\"No subject\">No subject available...</option>";
				unset($_POST["subject"]);				
				$flag=0;				
			}
		echo("<script type='text/javascript'>setdepartment('".$Department."'); </script>");
		} 
	}
?>	
	</select>
	<br/>
	
	
	Book: 
	<?php
		echo "<select name=\"book\" id=\"book\">";
		
		if(isset($_POST["department"]) and isset($_POST["subject"])) {
		if(!empty($_POST["department"]) and !empty($_POST["subject"])) {
			$Subject=$_POST["subject"];
			$Book=$_POST["book"];
			//echo $state;
			$sql = "SELECT DISTINCT book FROM book_detail where book IN(select book_name from book where book_quantity>0) and subject='$Subject'";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) 
			{
				echo "<option value=". $row["book"] .">" . $row["book"] ."</option>";
				}
			}
			else {
				echo "<option value=\"No book\">No book available...</option>";
				
				
			}
		//echo "<script> $(\"#Country\").val(\"$Country\");</script>";
		echo("<script type='text/javascript'>setdepartment('".$Department."'); </script>");
		echo("<script type='text/javascript'>setsubject('".$Subject."'); </script>");
		}
	else{
		echo "not selected";
	}		
	
	}
	
		echo "</select>";
		
	?>

	<br>
	<input type="submit" value="Issue" name="s">
	&nbsp &nbsp
	<input type="submit" value="Reserve" name="r">
	&nbsp &nbsp
	<input type="submit" value="Delete_reserved_book" name="rd">
	<br>
	<input type="submit" value="Home" name="h">
	
	
<?php

if(isset($_POST['s']))
{
	
	global $Department,$Subject,$Book,$uname,$conn,$sql,$sql1;
	date_default_timezone_set('Asia/Kolkata');
	$time=date('d-m-Y H:i');
$sql = "SELECT book_name FROM issue where uname='$uname' and book_name='$Book'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		echo "You have already issued this book";
	}
	else
	{
$sql = "SELECT book_name FROM issue where uname='$uname'";
$result = $conn->query($sql);
if ($result->num_rows < 3) 
{
	$sql = "SELECT book_quantity FROM book where book_name='$Book'";
	$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
        $quantity=$row["book_quantity"];
		if($quantity==0)
		{
			echo "No books available";
		}
		else
		{
			$quantity=$quantity-1;
			$sql = "UPDATE book SET book_quantity='$quantity' WHERE book_name='$Book'";

	if ($conn->query($sql) === TRUE) 
	{
			echo "Record updated successfully";
	} 
	else 
	{
		echo "Error updating record: " . $conn->error;
	}
		
	global $time;
	$sql = "INSERT INTO issue (uname,book_name,subject,department,time) VALUES ('$uname','$Book','$Subject','$Department','$time')";
	//echo "sdf";
	if ($conn->query($sql) === TRUE) 
	{
		echo "New records created successfully";
	} 
	else
	{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	
	} 


	}
}
	
	

}
else
{
	echo "You have issued already 3 books";
}


	}	
}


if(isset($_POST['r']))
{
	
	global $Department,$Subject,$Book,$uname,$conn,$sql,$sql1;
	date_default_timezone_set('Asia/Kolkata');
	$time=date('d-m-Y H:i');

	$sql = "SELECT book_name FROM reserve where uname='$uname' and book_name='$Book'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		echo "You have already reserved this book";
	}
	else
	{
		global $time;
		
		
		function ra()
		{
			global $sql,$uname,$Book,$time,$conn;
			$r_id=rand(1000,9999);
			$sql = "SELECT r_id FROM reserve where r_id=$r_id";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) 
			{
				ra();
			}
			else
			{
				$sql = "SELECT uname FROM reserve where uname='$uname'";
				$result = $conn->query($sql);
				if ($result->num_rows < 3) 
				{
					echo "Your reserved book id is";
					echo "<br>";
					echo $r_id;
					$sql = "INSERT INTO reserve(r_id,uname,book_name,r_date) VALUES ($r_id,'$uname','$Book','$time')";
					if ($conn->query($sql) === TRUE) 
					{
						echo "New records created successfully";
					}	 
					else
					{
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
			
					
				}
				else
				{
					echo "You have already reserved 3 books";
					
				}
			}
			
		}
		ra();	
		
		
	}
	
}

if(isset($_POST['rd']))
{
	global $Department,$Subject,$Book,$uname,$conn,$sql,$sql1;
	 $sql = "SELECT uname,book_name FROM reserve where uname='$uname' and book_name='$Book'";
	 $result = $conn->query($sql);
	 if ($result->num_rows > 0)
	 {
		 $sql = "DELETE FROM reserve WHERE uname='$uname' and book_name='$Book'";
		 if ($conn->query($sql) === TRUE) 
		 {
			echo "Record deleted successfully";
		 } 
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		
	 }
	 else
	 {
		 echo "There is no record available";
	 }
				
	 
	
	
	
}

if(isset($_POST['h']))
{
	header("Location:ldash.php");
}


?>
</form>


<br>







</body>
