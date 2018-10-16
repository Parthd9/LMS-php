<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";


$n1=$_GET["n1"];
$n2=$_GET["n2"];
$n3=$_GET["n3"];
$n4=$_GET["n4"];
$n5=$_GET["n5"];
$n6=$_GET["n6"];
$n7=$_GET["n7"];

if($_GET)
{
	if(isset($_GET['i']))
	{
        inserts();
    }
	elseif(isset($_GET['d']))
	{
        deletes();
    }
	elseif(isset($_GET['u']))
	{
        updates();
    }    
	elseif(isset($_GET['s']))
	{
        selects();
    }
	elseif(isset($_GET['l']))
	{
		session_destroy();
		header("Location:Librarian_login.php");
	}
}

function inserts()
{
	global $n1,$n2,$n3,$n4,$n5,$n6,$n7,$conn;
	
	
	
	
	$sql = "INSERT INTO book VALUES ($n1,'$n2','$n3',$n4,$n5)";
	if ($conn->query($sql) === TRUE) 
	{
		echo "New record inserted successfully in book table";
	}
	else 
	{
		echo "All entries must be filled in book table";
		echo "<br>";
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$sql = "INSERT INTO book_detail VALUES ($n1,'$n6','$n7','$n2')";
	if ($conn->query($sql) === TRUE) 
	{
		echo "New record inserted successfully";
	}
	else 
	{
		echo "All entries must be filled in book_detail table";
		echo "<br>";
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
}
function deletes()
{
	global $n1,$conn;
	$sql = "DELETE FROM book WHERE id=$n1";

if ($conn->query($sql) === TRUE) 
{
    echo "Record deleted successfully book table";
}
 else
{
	echo "<br>";
	echo "id must be entered";
    echo "Error deleting record: " . $conn->error;
}

$sql = "DELETE FROM book_detail WHERE id=$n1";

if ($conn->query($sql) === TRUE) 
{
	
    echo "Record deleted successfully book_detail table";
}
 else
{
	echo "<br>";
	echo "id must be entered";
    echo "Error deleting record: " . $conn->error;
}
}



function updates()
{
	global $n1,$n2,$n3,$n4,$n5,$n6,$n7,$conn;
	if(empty($n1))
	{
		echo "Atleast  id entry is needed";
	}
	else
	{
	$sql = "SELECT * FROM book where id=$n1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
    
    
    while($row = $result->fetch_assoc()) 
	{
      $a1=$row["book_name"];
	  $a2=$row["book_author"];
	  $a3=$row["book_quantity"];
	  $a4=$row["book_price"];
    }
    
		if(!empty($n2))
		{
			$a11=$n2;
		}
		else
		{
			$a11=$a1;
		}
		
		if(!empty($n3))
		{
			$a12=$n3;
		}
		else
		{
			$a12=$a2;
		}
		
		if(!empty($n4))
		{
			$a13=$n4;
		}
		else
		{
			$a13=$a3;
		}
		
		if(!empty($n5))
		{
			$a14=$n5;
		}
		else
		{
			$a14=$a4;
		}
		
		$sql = "UPDATE book SET book_name='$a11',book_author='$a12',book_quantity=$a13,book_price=$a14 WHERE id=$n1";

if (mysqli_query($conn, $sql)) 
{
    echo "Record updated successfully";
}
 else 
{

    echo "Error updating record: " . mysqli_error($conn);
}

//mysqli_close($conn);
	}
	
	
 else 
 {
    echo "0 results";
}

global $n1;
$sql = "SELECT * FROM book_detail where id=$n1";
$result = $conn->query($sql);	
if ($result->num_rows > 0) 
{
	while($row = $result->fetch_assoc()) 
	{
	  $a1=$row["department"];
	  $a2=$row["subject"];
	  $a3=$row["book"];
	}
	
		if(!empty($n6))
		{
			$a11=$n6;
		}
		else
		{
			$a11=$a1;
		}
		
		if(!empty($n7))
		{
			$a12=$n7;
		}
		else
		{
			$a12=$a2;
		}
		
		if(!empty($n2))
		{
			$a13=$n2;
		}
		else
		{
			$a13=$a3;
		}
		
	$sql = "UPDATE book_detail SET department='$a11',subject='$a12',book='$a13' WHERE id=$n1";

if (mysqli_query($conn, $sql)) 
{
    echo "Record updated successfully";
}
 else 
{
    echo "Error updating record: " . mysqli_error($conn);
}
	
	
}
else
{
	
	echo "0 rows selected";
}

	}	
}
function selects()
{
	global $n1,$n2,$n3,$n4,$n5,$conn;
	$sql = "SELECT * FROM book";
	$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    echo "<table border=1><tr><th>ID</th><th>Book_Name</th><th>Book_Author</th><th>Book_Quantity</th><th>Book_Price</th></tr>";
    
    while($row = $result->fetch_assoc()) 
	{
		
		
			echo "<tr><td>".$row["id"]."</td><td>".$row["book_name"]."</td><td>".$row["book_author"]."</td><td>".$row["book_quantity"]."</td><td>".$row["book_price"]."</td></tr>";
			
		
			
        
    }
    echo "</table>";
}
else 
{
    echo "0 results";
}


$sql = "SELECT * FROM book_detail";
	$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    echo "<table border=1><tr><th>ID</th><th>Department</th><th>Subject</th><th>Book</th></tr>";
    
    while($row = $result->fetch_assoc()) 
	{
		
		
			echo "<tr><td>".$row["id"]."</td><td>".$row["department"]."</td><td>".$row["subject"]."</td><td>".$row["book"]."</td></tr>";
			
		
			
        
    }
    echo "</table>";
}
else 
{
    echo "0 results";
}
}


		
	

?>
</body>
</html>