<html>
<head>
<style>
#info {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#info td, #info th {
    border: 1px solid #ddd;
    padding: 20px;
   
}

#info tr:nth-child(even){background-color: #f2f2f2;}

#info tr:hover {background-color: #ddd;}

#info th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    
   }
</style>
</head>

<body>
<a href="index.php"><img src = "BK.png" width = 15%></a>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

$t=$_POST['time'];
$d=$_POST['date'];
$r=$_POST['tname'];

echo "<hr>";
$conn2 = new mysqli($servername, $username, $password, $dbname);


echo "Showing Information on <b>".$d." </b>at<b> ".$t." </b>for bus name: <b>".$r."</b>";
echo "<hr>";


$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM $r order by ID desc";
$result = mysqli_query($conn, $sql);

$sql4=" SELECT * FROM $r where ID=1";
$result4=$conn2->query($sql4);
$row4=$result4->fetch_assoc();
$temp = explode('-',$row4['date']);
$temp2 = array_reverse($temp);
$temp3 = implode('-',$temp2);




$flag=1;
$flag2=1;
$id=0;
$a="";

echo "<table id=info><tr><th>DATE</th><th>TIME</th><th>COUNT</th><th>IN</th><th>OUT</th><th>LOCATION</th>";
while($row = mysqli_fetch_assoc($result)) {				//iteration for date
        
		$temp4 = explode('-',$row['date']);				//reverses date
		$temp5 = array_reverse($temp4);
		$temp6 = implode('-',$temp5);
		$row3=$row;
        
		if ((strcmp($d,$temp3)==0 && strcmp($t,$row['time'])<0) || (strcmp($d,$temp3)<0))		
		{
			
			echo "<tr><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td>";
			echo "Data doesn't exist !";
		break;
		}
		
		
		
		
		if($flag==1 && strcmp($d,$temp6)>=0){			
			if (strcmp($d,$temp6)>0){					// if given date is greater than data present
				echo "Count is: ".$row['count'];
				echo "<tr><td> " . $row["date"]. "</td><td>" . $row["time"]. "</td><td> " . $row["count"]. "</td><td>".$row['ppin']."</td><td>".$row['ppout']."</td><td>".$row['loc']."</td>";
				break;
			}
			
			$id=$row['ID'];
			
			$flag=2;
			$a=$row['date'];
			
			$sql2 = "SELECT * FROM $r where date='$a' order by ID desc";
			$result2=$conn2->query($sql2);
			
			$result2 = mysqli_query($conn, $sql2);
			
			$rows=$result2->num_rows;
			$fl=0;
			while($row2 = $result2->fetch_assoc()){		// iteration for finding time
				$ti=$row2['time'];
				$i=$row2['ID'];
				$fl=$fl+1;
				
						
				if($flag2==1 && strcmp($t,$ti)>=0){
					$flag2=2;
					
					$id2=$row2['ID'];
					echo "Count Is: ".$row2['count'];
					echo "<tr><td> " . $row2["date"]. "</td><td>" . $row2["time"]. "</td><td> " . $row2["count"]. "</td><td>".$row2['ppin']."</td><td>".$row2['ppout']."</td><td>".$row2['loc']."</td>";
					break;
					
				}
				if ($fl==$rows)		//if the row is below given date and time
				{
					$i=$i-1;
					$sql3 = "SELECT * FROM $r where ID=$i";
					$result3=$conn2->query($sql3);
					$row3=$result3->fetch_assoc();
					
					echo "<tr><td> " . $row3["date"]. "</td><td>" . $row3["time"]. "</td><td> " . $row3["count"]."</td><td>".$row3['ppin']."</td><td>".$row3['ppout']."</td><td>".$row3['loc']. "</td>";
					
					echo "count is: ".$row3['count'];
				    break;}
				
				
				
				
				
				
				
				
			}
			
		}
		
		
		
        
    }
echo "</table>";






?>

</body>
</html>