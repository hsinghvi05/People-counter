<html>
<head>
<title>DeletePage</title>
<style>
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: green;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 20px;
  padding: 10px;
  width: 200px;
  
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '»';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}

</style>
</head>
<body>

<?php
$r=$_POST['deleteitem'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}

$sql = "DROP TABLE $r";
mysqli_select_db( $conn, "mydb" );
$retval = mysqli_query($conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysqli_error($conn));
}
echo "<h2>Table deleted successfully!!!!</h2> \n ";
mysqli_close($conn);
?>
<hr>
<form action=add.php>
<button class = "button" style="vertical-align:middle"><span>Continue Editing</span></button>

</form>

<a href="index.php"><img src = "BK.png" width = 15%></a>
<hr>
</body>
</html>