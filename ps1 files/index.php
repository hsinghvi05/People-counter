<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="1">						
<title>People Counter</title>
<style>
#index {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#index td, #index th {
    border: 1px solid #ddd;
    padding: 20px;
   
}

#index tr:nth-child(even){background-color: #f2f2f2;}

#index tr:hover {background-color: #ddd;}

#index th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    
   }

   
   .button {
  display: inline-block;
  border-radius: 4px;
  background-color: Green;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
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
}
</style>
</head>
<body>



<form action=add.php>
<button class = "button" style="vertical-align:middle"><span>EDIT BUSES</button>

</form>

<?php



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql="select table_name from information_schema.tables where table_schema='myDB'";
$result=$conn->query($sql);

if ($result->num_rows > 0) {
	echo "<br><br>";
    // output data of each row
	echo "<table id = 'index' width=20%>";
	echo "<tr><th>SNo.</th><th>Bus Name</th><th>Count</th><th>IN</th><th>OUT</th><th>LOCATION</th></tr>";
	$sno=1;
    while($row = $result->fetch_assoc()) {
		$tname=$row["table_name"];
		$sql2="SELECT * FROM $tname order by ID desc LIMIT 0,1"; 	//last row data
		$result2=$conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		$cnt=$result2->fetch_assoc();
		
		
		echo "<tr>";
		echo "<td>".$sno."</td>";
		$sno++;
        echo "<td><form method=\"post\" action='show.php'>".		
		'<input type="submit" value='.$tname.' name="tname">'.
		'<input type="hidden" value="0" name="one">';
		
		echo '<td>'.$row2["count"].'</td><td>'.$row2['ppin']."</td><td>".$row2['ppout']."</td><td>".$row2['loc']. '</td></tr>';
    }
	echo "</table>";
} else {
    echo "0 BUSES PRESENT CLICK ON EDIT TO ADD BUSES NAME";
}

?>

<button><a href="test.php">Fare calculate</a/></button>
</body>
</html>