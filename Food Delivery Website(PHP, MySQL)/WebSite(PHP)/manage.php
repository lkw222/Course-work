<head>
  <meta charset="utf-8">
<title>
  Manage your restaurants and menus
</title>
<style>
body{
    background-color: #FAAC58;
    background-size: cover;
  }
#global{
    display:block;
    width:90%;
    padding:10px;    
    font-size: 30px;
    line-height: 200%;
}
#new{
  padding-left: 10%;
  padding-top: 30px;
  line-height: 140%;
  width: 70%;
}
li{
  list-style:none;
}
#result{
  margin-top:20px;
  margin-left:10%;
  font-size:20px;
}
#rest{
  font-size:25px;
  font-weight:bold; 
}

</style>

<script type="text/javascript" >
function iTree(t) {
    var tree=document.getElementById(t);
    tree.style.display="none";
    var lis=tree.getElementsByTagName("li");
    for(var i=0;i<lis.length;i++) {
        lis[i].id="li"+i;
        var uls=lis[i].getElementsByTagName("ul"); 
        if(uls.length!=0) {
            uls[0].id="ul"+i;
            uls[0].style.display="none";
            var as=lis[i].getElementsByTagName("a");
            as[0].id="a"+i;
            as[0].className="folder";
            as[0].href="#this";
            as[0].tget=uls[0];
            as[0].onclick=function() {
                open(this,this.tget);
            }
        }
    }
    tree.style.display="block";
}
function open(a,t) {
    if(t.style.display=="block") {
        t.style.display="none";
        a.className="folder";
    } else {
        t.style.display="block";
        a.className="";
    }
}
window.onload=function() {
    iTree("main");
}
</script>

</head>
<body id="global">

<ul id="main">

  <li class="part"><a href="#">Open a new restaurants </a>
    <ul>
      <li>
        <form id = "new" name="queryInput" action="new_rest.php" method="POST">
        Name:<input type="text" name="name" required> <br>
        Phone number:<input type="text" name="phone" required> <br>
        Address:<input type="text" name="address"required> <br>
        State:<input type="text" name="state" required><br>
        City:<input type="text" name="city"required> <br> 
        Zip:<input type="text" name="zip"required> 
        <input type="hidden" name="id" value=<?php echo $_GET['mid']; ?>> <br> 
        <input type="submit" value="submit" style="zoom:150%;">
        </form>
      </li>
    </ul>
  </li>

  <li id = "rest" class="part"><a href="#">Manage your restaurants</a>
    <ul>
      <li>
        <?php
          $servername = "localhost";
          $username = "root";
          $password = "mysql";
          $database = "Hungry";
          $conn = new mysqli($servername, $username, $password, $database);
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

          $id = $_GET['mid'];

          $sql = "SELECT restaurant_id,name,address,rating,review_count,is_open  FROM `Restaurants` WHERE manager_id = {$id}";
          $sql2 = "SELECT sum(price) FROM Orders WHERE Restaurant_id = {$row[restaurant_id]}";
          $result=$conn->query($sql);
          if ($result)
          {
            echo '<table id="result" border=1px>';
            echo "<td>Restaurant name</td><td>Address</td><td>rating</td><td>order_count</td><td>Open or close</td><td>Delete</td><td>Close</td><td>Edit</td><td>Menu</td><td>Update</td><td>Turnover</td>";
                while($row = $result->fetch_assoc())
                {
                    echo "<tr>";
                    foreach(array_slice($row, 1) as $key=>$value)
                    {
                    echo '<td>'.stripslashes($value).'</td>';
                    }
                    echo "<td><a href='edit.php?type=delete&rid={$row[restaurant_id]}&mid={$id}' >Delete</a></td>";
                    echo "<td><a href='edit.php?type=switch&rid={$row[restaurant_id]}&mid={$id}' >Switch</a></td>";
                    echo "<td><a href='edit.php?type=edit&rid={$row[restaurant_id]}&mid={$id}' >Edit</a></td>";
                    echo "<td><a href='edit.php?type=menu&rid={$row[restaurant_id]}&mid={$id}' >Menu</a></td>";
                    echo "<td><a href='edit.php?type=update&rid={$row[restaurant_id]}&mid={$id}' >Update</a></td>";
                    echo "<td>{$conn->query("SELECT sum(price) FROM Orders WHERE Restaurant_id = {$row[restaurant_id]}")->fetch_row()[0]}</td>";
                    echo "</tr>";
                }
                echo "</table>";
          }
        ?>

      </li>
    </ul>
  </li>

  <li class="part"><a href="home.php"  target="_parent">log out</a></li>
</ul>
</body>
</html>