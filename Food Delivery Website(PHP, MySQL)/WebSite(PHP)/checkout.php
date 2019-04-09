<html>
<head>
    <title>
        Check out
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
		left:45%;
		top:30%;
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
		$servername = "localhost";
		$username = "root";
		$password = "mysql";
		$database = "Hungry";
		$conn = new mysqli($servername, $username, $password, $database);
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}

		if ($_POST['uid']=='') {
			die("<a href='signin.html' >Please sign in!</a>");
		}
		$price = 0;
		foreach (split(',', $_POST['price']) as $value) {
			$price = $price + $value;
		}

		if (is_null($_POST['check'])) {
			echo '<form id = "new" name="queryInput" action="checkout.php" method="POST">
	        Card number:<input type="number" name="card" size = 16 required> <br>
	        password:<input type="password" name="password" required> <br>
	        Date:<input type="number" name="date" size = 4 required> <br>
	        Address:<input type="text" name="address" > <br>
	        Review:<input type="text" name="review" > <br>
	        Rating:<input type="number" name="rating" max = 5 min=0 required> <br>
	        Do you want:<br><input type="radio" name="type" value="p" checked>Pick up
			<br>
			<input type="radio" name="type" value="d">Delivery	
			<br>
	        <input type="hidden" name="uid" value= "'.$_POST["uid"].'">
	        <input type="hidden" name="rid" value= "'.$_POST["rid"].'">
	        <input type="hidden" name="price" value= "'.$price.'">
	        <input type="hidden" name="detail" value= "'.$_POST["detail"].'"> <br> 
	        <input type="hidden" name="check" value= "1">
	        <input type="submit" value="submit" style="zoom:150%;">
	        </form>';
		}
		else
		{
			$sql = "insert into orders values(null,{$_POST['uid']},'{$_POST['address']}','{$_POST['type']}','{$_POST['review']}',{$_POST['rating']},{$_POST['rid']},now(),'{$_POST['detail']}',{$_POST['price']})";
			$result = $conn->query($sql);

			if ($result) 
			{
				echo "Successfully order!<br><a href = 'user.php?uid={$_POST['uid']}'> Back to orders</a>";
			}
			else
				echo "Fail to order!<br><a href = 'detail.php?rid={$_POST['rid']}&uid={$_POST['uid']}'>Back to menu</a>";
		}

		


		

		?>
	</div>

</body>
</html>