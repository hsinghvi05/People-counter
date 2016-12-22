<!DOCTYPE html>
<html>
<head>
<title>Conductor's Collection</title>
</head>
<body>

<br>
<h2>Dummy Route</h2>
<img src="Route.jpg" alt="route" style="width:608px;height:228px;">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Enter price per 'x' kilometers: 
<input type="number" name = "x" min="0"> <br> 
<br> 
<hr> 
<br>
<input type="number" name = "Ain" placeholder = "Point A IN" min="0"> <br> 
<input type="number" name = "Bin" placeholder = "Point B IN" min="0">
<input type="number" name = "Bout" placeholder = "Point B OUT" min="0"> <br>
<input type="number" name = "Cin" placeholder = "Point C IN" min="0"> 
<input type="number" name = "Cout" placeholder = "Point C OUT" min="0"> <br> 
<input type="number" name = "Din" placeholder = "Point D IN" min="0">
<input type="number" name = "Dout" placeholder = "Point D OUT" min="0"> <br> 
<br>
<input type="submit" value="Check Conductor's Earnings!">

</form>
<br>
  
<hr>
<?php 
if (count($_POST) > 0 && isset($_POST["x"]) && isset($_POST["Ain"]) && isset($_POST["Bin"]) && isset($_POST["Bout"]) && isset($_POST["Cin"]) && isset($_POST["Cout"]) && isset($_POST["Din"]) && isset($_POST["Dout"]))
{
$x = $_POST["x"];
$ain = $_POST["Ain"];
$bin = $_POST["Bin"];
$bout = $_POST["Bout"];
$cin = $_POST["Cin"];
$cout = $_POST["Cout"];
$din = $_POST["Din"];
$dout = $_POST["Dout"];
$n = $ain;
$sum = $n * 2 * $x; 
$n = $n + $bin - $bout;
$sum = $sum + ($n * 3 * $x); 
$n = $n + $cin - $cout;
$sum = $sum + ($n * $x); 
$n = $n + $din - $dout;
$sum = $sum + ($n * 4 * $x); 

echo "The Conductor earns:" . $sum;

}
?>


</body>
</html>