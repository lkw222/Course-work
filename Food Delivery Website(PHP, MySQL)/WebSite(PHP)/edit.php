<html>
<head>
    <title>
        edit
    </title>
    <style>
	body{
		font-family: arial;
		font-size:20px;
		background-color: #FAAC58;
		background-size: cover;
		padding-left:20%;
		line-height:35px;
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

if ($_GET['type']=='delete') {
	$sql = "delete from restaurants where restaurant_id = {$_GET['rid']}";
	$result = $conn->query($sql);
	if ($result) {
		echo "Successfully delete!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
	}
	else
		echo "Fail to delete!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
}
elseif ($_GET['type']=='switch') {
	$sql = "update restaurants set is_open = CASE when is_open = 1 THEN 0 when is_open = 0 THEN 1 END WHERE restaurant_id = {$_GET['rid']} ";
	$result = $conn->query($sql);
	if ($result) {
		echo "Successfully seitch!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
	}
	else
		echo "Fail to switch!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
}
elseif ($_GET['type']=='edit') {
	if (is_null($_GET['form'])) {
		$result = $conn->query("SELECT name,phone_number,address,state,city,zip FROM Restaurants WHERE restaurant_id = {$_GET['rid']}")->fetch_assoc();
		echo '<form name="queryInput" action="/edit.php" method="GET">
			Name:<input type="text" name="name" value = "'.$result[name].'"> <br>
			Phone Number:<input type="text" name="phone" value = "'.$result[phone_number].'"><br>
			Address:<input type="text" name="address"value = "'.$result[address].'"><br>
			State:<input type="text" name="state"value = "'.$result[state].'"><br>
			City:<input type="text" name="city"value = "'.$result[city].'"><br>
			Zip:<input type="text" name="zip"value = "'.$result[zip].'"><br>
			<br>Business Time:<br>';
			echo '
	        Monday:<input type="time" name="1b"required>-<input type="time" name="1e"required><br>
	        Tuesday:<input type="time" name="2b"required>-<input type="time" name="2e"required><br>
	        Wednesday:<input type="time" name="3b"required>-<input type="time" name="3e"required><br>
	        Thursday:<input type="time" name="4b"required>-<input type="time" name="4e"required><br>
	        Friday:<input type="time" name="5b"required>-<input type="time" name="5e"required><br>
	        Saturday:<input type="time" name="6b"required>-<input type="time" name="6e"required><br>
	        Sunday:<input type="time" name="7b"required>-<input type="time" name="7e"required><br>
	        <br>Category:<br>';

	        $result = $conn->query("SELECT DISTINCT Category FROM Category")->fetch_all();
	        foreach ($result as $value) {
	          echo '<input type="checkbox" name="category[]" value="'.$value[0].'" >'.$value[0];
	        }

	        echo '
			<input type="hidden" name="form"value = "1">
			<input type="hidden" name="type"value = "edit">
			<input type="hidden" name="rid"value = "'.$_GET['rid'].'">
			<input type="hidden" name="mid"value = "'.$_GET['mid'].'"><br>			
			<input type="submit" value="submit" style="zoom:150%;">
			</form>';
	}
	else{
			$sql = "update restaurants set name='{$_GET['name']}',phone_number='{$_GET['phone']}',address='{$_GET['address']}',state='{$_GET['state']}',city='{$_GET['city']}',zip='{$_GET['zip']}' WHERE restaurant_id = {$_GET['rid']};
				delete from hours WHERE restaurant_id = {$_GET['rid']};
				delete from category WHERE restaurant_id = {$_GET['rid']};
				insert into hours values(null,{$_GET['rid']},'Monday|{$_GET['1b']}-{$_GET['1e']}');
				insert into hours values(null,{$_GET['rid']},'Tuesday|{$_GET['2b']}-{$_GET['2e']}');
				insert into hours values(null,{$_GET['rid']},'Wednesday|{$_GET['3b']}-{$_GET['3e']}');
				insert into hours values(null,{$_GET['rid']},'Thursday|{$_GET['4b']}-{$_GET['4e']}');
				insert into hours values(null,{$_GET['rid']},'Friday|{$_GET['5b']}-{$_GET['5e']}');
				insert into hours values(null,{$_GET['rid']},'Saturday|{$_GET['6b']}-{$_GET['6e']}');
				insert into hours values(null,{$_GET['rid']},'Sunday|{$_GET['7b']}-{$_GET['7e']}');
				";
			foreach ($_GET['category'] as $key => $value) {
				$sql = $sql."insert into category values(null,{$_GET['rid']},'$value');";
			}
			$result = $conn->multi_query($sql);
			if ($result) {
				echo "Successfully edit!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
			}
			else
				echo "Fail to edit!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
	}
}

elseif ($_GET['type']=='menu') 
{
	if (is_null($_GET['menu'])) //show the menu
	{
		$sql = "SELECT menu_id,name,price FROM Menus JOIN Meals ON Menus.meal_id=Meals.meal_id WHERE restaurant_id={$_GET['rid']}";
		$result = $conn->query($sql);
		if ($result) 
		{
			echo "<table border=1px>";
		    while($row = $result->fetch_assoc())
		    {
		        echo "<tr>";
				foreach(array_slice($row, 1) as $key=>$value)
		        {
		        	echo '<td>'.stripslashes($value).'</td>';
		        }
		        echo "<td><a href='edit.php?type=deletemenu&mid=".$_GET['mid']."&rid=".$_GET['rid']."&meal=".$row[menu_id]."' >Delete</a></td>";

		        echo "</tr>";
		    }
		    echo "</table>";
		    echo '
		    <form name="queryInput" action="/edit.php" method="GET">
			Add meal:<input type="text" name="meal"><br>
			Price:<input type="text" name="price">
			<input type="hidden" name="type" value = "menu"><input type="hidden" name="menu" value = "1">
			<input type="hidden" name="rid"value = "'.$_GET['rid'].'">
			<input type="hidden" name="mid"value = "'.$_GET['mid'].'"><br>
			<input type="submit" value="submit" style="zoom:150%;">
			</form><br><br>'."<a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
		}
	}
	else//try to add a meal to menu
	{
		$result = $conn->query("select meal_id from Meals where name = '{$_GET['meal']}' limit 1")->fetch_row()[0];
		if ($result) //meal exist
		{
			$sql = "insert into menus values(null,{$_GET['rid']},$result,{$_GET['price']})";
			$result = $conn->query($sql);
			if ($result) 
			{
				echo "Successfully add menu!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to menu</a>";
			}
			else
				echo "Fail to add menu!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to menu</a>";
		}
		else//meal not exist
			echo 'The Meal Not Exist<br>Please Add The Information <form name="queryInput" action="/edit.php" method="GET">
			Name:<input type="text" name="name"><br>
			Description:<input type="text" name="description"><br>
			Calory:<input type="text" name="calory"><br>
			Picture:<input type="url" name="picture"><br>
			Price:<input type="text" name="price">
			<input type="hidden" name="type" value = "meal">
			<input type="hidden" name="rid"value = "'.$_GET['rid'].'">
			<input type="hidden" name="mid"value = "'.$_GET['mid'].'"><br>
			<input type="submit" value="submit" style="zoom:150%;">
			</form>';
	}
}
elseif ($_GET['type']=='deletemenu') 
{
	$sql = "delete from menus where menu_id = {$_GET['meal']}";

	$result = $conn->query($sql);

	if ($result) 
	{
		echo "Successfully delete!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to manage</a>";
	}
	else
		echo "Fail to  delete!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to manage</a>";
}
elseif ($_GET['type']=='meal') 
{
	$sql = "insert into Meals values(null,'{$_GET['name']}','{$_GET['description']}',{$_GET['calory']},'{$_GET['picture']}')";
	$result = $conn->query($sql);

	if ($result) 
	{
		$result = $conn->query("select meal_id from Meals where name = '{$_GET['name']}' limit 1")->fetch_row()[0];
		if ($result) //meal exist
		{
			$sql = "insert into menus values(null,{$_GET['rid']},$result,{$_GET['price']})";
			$result = $conn->query($sql);
			if ($result) 
			{
				echo "Successfully add menu!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to menu</a>";
			}
			else
				echo "Fail to add menu!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to menu</a>";
		}
	}
	else
		echo "Fail to  delete!<br><a href='edit.php?type=menu&mid=".$_GET['mid']."&rid=".$_GET['rid']."' >Back to manage</a>";
}
elseif ($_GET['type']=='update') 
{
	$sql1 = "UPDATE Restaurants SET rating = (SELECT format(AVG(rating),2) FROM Orders WHERE restaurant_id={$_GET['rid']}) WHERE restaurant_id={$_GET['rid']}";
	$sql2 = "UPDATE Restaurants SET review_count = (SELECT COUNT(1) FROM Orders WHERE restaurant_id={$_GET['rid']}) WHERE restaurant_id={$_GET['rid']}";
	$result1 = $conn->query($sql1);
	$result2 = $conn->query($sql2);

	if ($result1 && $result2) {
		echo "Successfully update!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
	}
	else
		echo "Update failed!<br><a href='manage.php?mid={$_GET['mid']}' title=''>Back to manage</a>";
	
}



?>
</body>
</html>