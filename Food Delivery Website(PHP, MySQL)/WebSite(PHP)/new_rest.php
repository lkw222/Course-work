<html>
<head>
    <title>
        Kewei Li Assignment 1
    </title>
    <style>
	body{
		font-family: arial;
		font-size:20px;
		background-color: #FAAC58;
		background-size: cover;
	}
	div{
		width:300px;
		height:300px;
		position:absolute;
		left:48%;
		top:45%;
		margin-top:-50px;
		margin-left:-100px;
		line-height: 200%;
	}
	</style>
</head>
<body>

<?php



$conn = new mysqli('localhost', 'root', 'mysql', 'Hungry');
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql = "insert into restaurants values (null,'{$_POST['name']}','{$_POST['phone']}','{$_POST['address']}',0,'{$_POST['state']}','{$_POST['city']}','{$_POST['zip']}',0,0,{$_POST['id']});";


if($conn->query($sql))
	echo "<div>Successful!<br><a href='manage.php?mid={$_POST['id']}' title=''>Back to manage</a></div>";
else
	echo "<div>Failed!<br><a href='manage.php?mid={$_POST['id']}' title=''>Back to manage</a></div>";


?>
</body>
</html>