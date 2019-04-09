<html>
<head>
    <title>
        Hungry
    </title>
    <link rel = "stylesheet" type = "text/css" href = "960_12_col_rtl.css" />
    <style>
    body{
		font-family: arial;
		font-size:25px;
		background-color: #FAAC58;
		background-size: cover;
		text-align: center;		
	}
	.line1,.line2{
		display: inline-block;
		height: auto;
	}
	#name{
		color:darkcyan;
    	text-decoration: none;
	}
	.rest{
		padding-bottom: 40px;
		border:1px solid #dcdcdc;
		border-radius: 10px;
		padding:40px;
		color:black;
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

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// else{
// echo "<p><font color=\"red\">Connected successfully</font></p>";
// }

echo "<br><a href='home.php?uid={$_POST['uid']}' title=''>Back to homepage</a>";

if ($_POST['zip'] != '') {
	$sql1 = "select restaurant_id from restaurants where name like '%{$_POST['content']}%' and zip={$_POST['zip']} and is_open = 1";
	$sql2 = "select r.restaurant_id from category c join restaurants r on r.restaurant_id=c.restaurant_id where category like '%{$_POST['content']}%' and zip={$_POST['zip']} and is_open = 1";
	$sql3 = "select r.restaurant_id from orders o join restaurants r on r.restaurant_id=o.restaurant_id where review like '%{$_POST['content']}%' and zip={$_POST['zip']} and is_open = 1";
}
else{
	$sql1 = "select restaurant_id from restaurants where name like '%{$_POST['content']}%' and is_open = 1";
	$sql2 = "select r.restaurant_id from category c join restaurants r on r.restaurant_id=c.restaurant_id where category like '%{$_POST['content']}%' and is_open = 1";
	$sql3 = "select r.restaurant_id from orders o join restaurants r on r.restaurant_id=o.restaurant_id where review like '%{$_POST['content']}%' and is_open = 1";
}

$result1 = array_column($conn->query($sql1)->fetch_all(),0); 
$result2 = array_column($conn->query($sql2)->fetch_all(),0);
$result3 = array_column($conn->query($sql3)->fetch_all(),0);
$temp = array_unique(array_merge($result1,$result2,$result3));


$sql = '';
foreach($temp as $value)
	{
		$sql = $sql."SELECT * FROM Restaurants r join hours h on h.restaurant_id = r.restaurant_id WHERE r.restaurant_id = {$value} and time like '%".date('l')."%' union ";
	}

$sql = rtrim($sql,'union ');
$result = $conn->query($sql);



if ($result)
{
	echo '<div class = "container_12 clearfix">
	<h1> The result: </h1>';
    while($row = $result->fetch_assoc())
    {
    	

    	$time = split('\|', $row[time])[1];

		echo '<div class = "rest grid_12">

	<div class = "line1 grid_5">
		<a id = "name" href = "detail.php?rid='.$row[restaurant_id].'&uid='.$_POST['uid'].'">'.$row[name].'</a>
	</div>
	<div class = "line1 grid_3">
		<p>Zip: '.$row[zip].'</p >
	</div>
	<div class = "line1 grid_3">
		<p>Hour: '.$time.'</p >
	</div>

	<div class = "line2 grid_5">
		<p>Addr: '.$row[address].", ".$row[city].", ".$row[state].'</p >
	</div>
	<div class = "line2 grid_3">
		<p>Tel: '.$row[phone_number].'</p >
	</div>
	<div class = "line2 grid_3">
		<p>Rating: '.$row[rating].'</p >
	</div>

	</div>';
    }
    echo '</div>';
    $result->free();

}

mysqli_close($conn);
?>
</body>
</html>