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

if ($_POST['Id'] == "" || $_POST['name'] == "" || $_POST['password'] == "" || $_POST['phone'] == "")
{
	die("<font color=\"red\">ID, name, password and phone cannot be empty!</font>");
}


if (ctype_digit($_POST['Id'])){
	if ($conn->query("select 1 from users where user_id = {$_POST['Id']} limit 1")->fetch_row()[0]) {
		echo "<font color=\"red\">Your Id already existed";
	}
	else {
		if ($_POST['type']=='User') 
		{
			if($conn->query("insert into users values ({$_POST['Id']},'{$_POST['name']}','{$_POST['phone']}','{$_POST['password']}','{$_POST['address']}')"))
			{
				echo "Successful!<br><a href='home.php?uid={$_POST['Id']}' title=''>Back to homepage</a>";
			}
			else
				echo "Sign up failed";
		}
		elseif ($_POST['type']=='Manager'){
			if($conn->query("insert into managers values ({$_POST['Id']},'{$_POST['name']}','{$_POST['phone']}','{$_POST['password']}')"))
			{
				echo "Successful!<br><a href='manage.php?mid={$_POST['Id']}' title=''>Go to manage</a>";
			}
			else
				echo "Sign up failed";
		}

	}
}
else
	echo "<font color=\"red\">Id cannot contain any letter!";



// if (!ctype_digit($_POST['Id']) && )
// {
// 	echo "111";
// }
// elseif ($_POST['type']=='User') {
// 	echo '<form name="queryInput" action="/rest.php" method="POST">
// 			Id:<input type="text" name="Id"> <br>
// 			Password:<input type="Password" name="password"> <br>
// 			Name:<input type="text" name="Name"> <br>
// 			Phone Number:<input type="text" name="phone" ><br>
// 			Address:<input type="text" name="Address"> <br>			
// 			<input type="submit" value="submit" style="zoom:150%;">
// 		</form>';
// }
// elseif ($_POST['type']=='Manager') {
// 	echo '<form name="queryInput" action="/manage.php" method="POST">
// 			Id:<input type="text" name="Id" ><br>
// 			Password:<input type="Password" name="password" ><br>
// 			Name:<input type="text" name="Name" ><br>
// 			Phone Number:<input type="text" name="phone" ><br>			
// 			<input type="submit" value="submit" style="zoom:150%;">
// 		</form>';
// }
?>
</div>

</body>
</html>