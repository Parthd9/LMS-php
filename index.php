<html>
<?php
if($_GET){

if(isset($_GET["l"])){l();}
if(isset($_GET["u"])){u();}


}

function l()
{
header("Location:Librarian_login.php");
die();
}

function u()
{
header("Location:user_login.php");
die();
}



?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">

  <button type="submit" name="l">Librarian</button>
  <button type="submit" name="u">User</button>
</form>

</html>
