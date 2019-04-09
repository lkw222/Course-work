<html>
<head>
    <title>
        User's order detail
    </title>
    <style>
	body{
		font-family: arial;
		font-size:20px;
		background-color: #FAAC58;
		background-size: cover;
	}
	#result{
		margin:auto;
		margin-top:2%;
		line-height: 200%;
		width:92%;
	}
	h1 {
		padding-top:2px;
        text-align:center;
      }
      .x{
      	padding-left:4%;
      	font-size:25px;
      }
</style>

</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "Hungry";
$conn = new mysqli($servername, $username, $password, $database);
$user_id = $_GET['uid'];
$max = $_GET['max'];

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// else{
// echo "<p><font color=\"red\">Connected successfully</font></p>";
// }

echo "<br><h1><a href='home.php?uid={$_GET['uid']}' title=''>Back to homepage</a></h1>";

$sql = "select count(1) from orders where user_id = {$_GET['uid']}";

$limit = 25;
$offset = $_GET['offset'];
if (is_null($content)) {
	$user_id = $_GET['uid'];

}
if (is_null($offset)) {
	$offset=0;
}
if (is_null($max)) {
	$result = $conn->query($sql);
	$max =  $result->fetch_row()[0];
}

$prve=$offset-$limit; 
$next=$offset+$limit; 

if ($prve>=0) { 
echo "<div class = 'x'><a href=user.php?offset=".$prve."&uid=".$user_id."&max=".$max.">prve</a><br></div>"; 
} 


if ($next<$max) { 
echo "<div class = 'x'><a href=user.php?offset=".$next."&uid=".$user_id."&max=".$max.">next</a></div>"; 
} 


$sql = "SELECT date,r.name,details,price FROM orders o JOIN Restaurants r on o.restaurant_id=r.restaurant_id WHERE user_id = {$user_id} limit ".$offset.",".$limit;
$result=$conn->query($sql);

if ($result)
{
	echo '<table id="result" border=1px>';
	echo "<td>Time</td><td>Restaurant name</td><td>Order detail</td><td>Price</td>";
	    while($row = $result->fetch_assoc())
	    {
	        echo "<tr>";
	        foreach($row as $key=>$value)
	        {
	        echo '<td>'.stripslashes($value).'</td>';
	        }
	        echo "</tr>";
	    }
	    echo "</table>";
}



if ($prve>=0) { 
echo "<div class = 'x'><a href=user.php?offset=".$prve."&uid=".$user_id."&max=".$max.">prve</a><br></div>"; 
} 


if ($next<$max) { 
echo "<div class = 'x'><a href=user.php?offset=".$next."&uid=".$user_id."&max=".$max.">next</a></div>"; 
} 
 


// $result->free();


mysqli_close($conn);
?>
</body>
</html>