<html>
<body>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
input[type=date], input[type=time] {
    width: 20%;
    height: 5%;
    padding: 12px 10px;
    text-align: center;
    margin: 8px 0;
    box-sizing: border-box;
    border: 3px solid green;
    border-radius: 2px;
    font-size : 25px;
    
}
input[type=submit] {
    padding:5px 15px; 
    background:#ccc; 
    border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
}

.button {
  display: inline-block;
  border-radius: 4px;
  background-color: green;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 20px;
  padding: 10px;
  width: 500px;
  
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

#show {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#show td, #show th {
    border: 1px solid #ddd;
    padding: 20px;
   
}

#show tr:nth-child(even){background-color: #f2f2f2;}

#show tr:hover {background-color: #ddd;}

#show th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    
   }
   
#stats {
	font-size : 40px;
	text-align : center;
	color : green;
} 
   


</style>
<a href="index.php"><img src = "BK.png" width = 15%></a><hr>
<div id = "stats" >Statistics: <?php echo $_POST['tname'];?></div>
<hr>
<?php

$r=$_POST['tname'];






echo '<form method = "post" action = info.php>'.
'<fieldset style = "border : 5px solid green">'.
'<legend><h2>Search For The Number of people at a particular date and time</h2></legend>'.
'<h2><label for  = "date">Select Date : </label>'.
'<input type = "date" id = "date" name = "date" required>'. 
'<br>'.
'<br>'.
'<label for  = "time"> Select Time : </label>'.
'<input type = "time" id = "time" name = "time" required></h2>'. 
'<input type="hidden" value='.$r.' name="tname">'.
'<br>'.
'<button class = "button"><span>Click Here To Submit Date and Time</span></button>'.
'</fieldset>'.
'</form>'

?>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";
$r=$_POST['tname'];
$x=$_POST['one'];



// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$z=$x+1;
echo "From row ".$z;
$sql = "SELECT * FROM $r order by ID desc LIMIT $x,25";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	echo "<table id = 'show'><tr><th>DATE</th><th>TIME</th><th>COUNT</th><th>IN</th><th>OUT</th><th>LOCATION</th>";
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td> " . $row["date"]. "</td><td>" . $row["time"]. "</td><td> ". $row["count"]."</td><td>".$row['ppin']."</td><td>".$row['ppout']."</td><td>".$row['loc']. "</td>";
    }
	echo "<table>";
	$x=$x+25;
	
	echo "<br><form method=\"post\" action=show.php>".
		'<input type="submit" value="NEXT">'.
		'<input type="hidden" value='.$r.' name="tname">'.
		'<input type="hidden" value='.$x.' name="one">';
		
} else {
    echo "<br><h2>0 results</h2>";
}

mysqli_close($conn);
?>

</body>
</html>
