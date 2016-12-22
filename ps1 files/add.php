<html>
<body>
<style>
#add {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#add td, #add th {
    border: 1px solid #ddd;
    padding: 8px;
}

#add tr:nth-child(even){background-color: #f2f2f2;}

#add tr:hover {background-color: #ddd;}

#add th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

input[type=text] {
    width: 30%;
    height: 2%;
    padding: 12px 10px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 3px solid green;
    border-radius: 2px;
}

.button {
  display: inline-block;
  border-radius: 4px;
  background-color: green;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 10px;
  width: 150px;
  
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
<a href="index.php"><img src = "BK.png" width = 15%></a>

<hr>
<form method="post" action=add.php>
<input type = "text" name='rid' placeholder = "TYPE BUS NAME HERE..." required>
<button class = "button"><span>Add</span></button>
</form>




<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

$dte=date("d-m-Y");
$l='NA';		//location variable
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$rname=$_POST['rid'];
	// sql to create table
	$sql = "CREATE TABLE $rname 
	(ID int NOT NULL AUTO_INCREMENT,date TEXT, time TEXT,count INTEGER, ppin INTEGER, ppout INTEGER, loc TEXT, PRIMARY KEY (ID))";
    $sql2="INSERT INTO $rname (date,time,count,ppin,ppout,loc) values ('$dte','00:00',0,0,0,'$l')";

	if($conn->query($sql) === TRUE) {
		echo "<h3>BUS: $rname added successfully</h3>";
		$conn->query($sql2);
	} else {
		echo "<h3>Error adding BUS</h3>" ;//. $conn->error ."</h3>";
	}
}
?>
<hr>
<h2> <br><u><i> CLICK ON A BUS TO DELETE IT! </i></u></h2>
<?php

$sql="select table_name from information_schema.tables where table_schema='myDB'";
$result=$conn->query($sql);

if ($result->num_rows > 0) {
	
    // output data of each row
	echo "<table id = 'add' width=20%>";
	echo "<tr><th>SNo.</th><th>Bus Name</th></tr>";
	$sno=1;
    while($row = $result->fetch_assoc()) {
		$tname=$row["table_name"];
		echo "<tr>";
		echo "<td>".$sno."</td>";
		$sno++;
        echo "<td><form method=\"post\" action=delete.php>".
		'<input type="submit" value='.$row["table_name"].' name="deleteitem"> </form>';
	}
	echo "</table>";
} else {
    echo "<h3>0 BUSES PRESENT CLICK ON EDIT TO ADD BUSES</h3>";
}

$conn->close();
?>