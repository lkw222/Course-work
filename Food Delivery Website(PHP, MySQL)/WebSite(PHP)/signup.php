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

if ($_POST['type']==null){
	echo '<form name="queryInput" action="/signup.php" method="POST">
			Account Type:<br><input type="radio" name="type" value="User" checked>User
			<br>
			<input type="radio" name="type" value="Manager">Manager	
			<br>			
			<input type="submit" value="Submit" style="zoom:150%;">
		</form>
		';
}
elseif ($_POST['type']=='User') {
	echo '<form name="queryInput" action="/signup_result.php" method="POST">
			Id:<input type="text" name="Id"> <br>
			Password:<input type="Password" name="password"> <br>
			Name:<input type="text" name="name"> <br>
			Phone Number:<input type="text" name="phone" ><br>
			Address:<input type="text" name="address"><input type="hidden" name="type" value = "User"> <br>			
			<input type="submit" value="submit" style="zoom:150%;">
		</form>';
}
elseif ($_POST['type']=='Manager') {
	echo '<form name="queryInput" action="/signup_result.php" method="POST">
			Id:<input type="text" name="Id" ><br>
			Password:<input type="Password" name="password" ><br>
			Name:<input type="text" name="name" ><br>
			Phone Number:<input type="text" name="phone" ><input type="hidden" name="type" value = "Manager"><br>			
			<input type="submit" value="submit" style="zoom:150%;">
		</form>';
}
?>
</div>

</body>
</html>