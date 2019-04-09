<html>
<head>
    <title>
        Sign up
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
	input[type="submit"]:hover,
</style>
</head>
<body>

	<div>
<?php

$conn = new mysqli('localhost', 'root', 'mysql', 'Hungry');
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

if ($_POST['Id'] == "" || $_POST['password'] == "")
{
	die("<font color=\"red\">ID, password cannot be empty!</font>");
}


if (ctype_digit($_POST['Id']))
{
	if ($conn->query("select 1 from users where user_id = {$_POST['Id']} limit 1")->fetch_row()[0]) 
	{
		
		if ($_POST['type']=='User') 
		{
			if($conn->query("select password from users where user_id = {$_POST['Id']}")->fetch_row()[0] == $_POST['password'])
			{
				echo "Successful!<br><a href='home.php?uid={$_POST['Id']}' title=''>Back to homepage</a>";
			}
			else
				echo "Your password is wrong!";
		}
		elseif ($_POST['type']=='Manager')
		{
			if($conn->query("select password from managers where manager_id = {$_POST['Id']}")->fetch_row()[0] == $_POST['password'])
			{
				echo "Successful!<br><a href='manage.php?mid={$_POST['Id']}' title=''>Back to homepage</a>";
			}
			else
				echo "Your password is wrong!";
		}
	}
	else 
	{
		echo "<font color=\"red\">Your Id doesn`t exist!";

	}
}
	
else
	echo "<font color=\"red\">Id must be numbers!";



?>
</div>

</body>
</html>