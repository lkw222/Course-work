<title>Hungry</title>
<head>
<style>
#container {
    background: url(background.jpg);
    opacity: 0.5;
    position: absolute;
    height:100%;
    width:100%;
    background-size: cover;
}
#login {
    position: absolute;
    width:150px;
    top:50px;
    right:20px;
    text-align:center;
    z-index:40;
    font-family: Adele;
    font-size: 40;
}
#logup {
    position: absolute;
    width:150px;
    top:50px;
    right:170px;
    text-align:center;
    z-index:40;
    font-family: Adele;
    font-size: 40;
}
#email{
    position: absolute;
    height: 100px;
    width: 300px;
    right:20px;
    top:85%;
    z-index:40;
    text-align:center;
    font-size:30;
}
#search{
    position: absolute;
    height: 100px;
    top:55%;
    left:5%;
    text-align:center;
    z-index:30;
}
#title{
    position: absolute;
    height: 200px;
    width: 400px;
    left:33%;
    top:30%;
    z-index:30;
    font-family: Adele;
    text-align:center;
    font-size:120;
    color:red;
    text-shadow: 2px 2px 7px #111111;
}
a:link{
    color:darkcyan;
    text-decoration: none;
}
a:visited{
    color:black;
}
td{
    display: inline-block;
    margin:20px;
    font-size:25px;
    color:darkcyan;
    font-weight: bold;
    float:left;
}
#userName{
	position: absolute;
    width:350px;
    top:50px;
    right:20px;
    text-align:center;
    z-index:40;
    font-family: Adele;
    font-size: 40;
}
#logout{
    position: absolute;
    width:350px;
    top:130px;
    right:20px;
    text-align:center;
    z-index:40;
    font-family: Adele;
    font-size: 40;
}
</style>
</head>
<body >
<div id="container"></div>
<?php
if ($_GET['uid']==null)
    echo '<div id="login"><a href = "signin.html">Sign in</a></div>
<div id="logup"><a href = "signup.php">Sign up</a></div>';
else{
    echo '<div id = "userName"> User: <a href = "user.php?uid='.$_GET['uid'].'">'.$_GET['uid'].'</a></div>';
    echo '<br><div id = "logout"><a href = "home.php">Log out</a></div>';
}



?>

<div id="email">
    <a href = "mailto:kel137@pitt.edu">Contact Us</a>
</div>
<div id = "title">Hungry</div>
<div id ="search" ">
    <table>
    <tr>
    <form name="queryInput" action="restaurants.php" method="POST">
        <td><p>Restaurants:<input type="text" style="width:350px; height:50px;" name="content" required="required"></p></td>
        <td></p>Zip:<input type = "text" style="width:350px; height:50px;"name = "zip"></p></td>
        <input type = "hidden" name = "uid" value="<?php echo $_GET['uid']; ?>">
        <td><p><input type="submit" value="search" style="zoom:200%;"></p></td>
    </tr>
    </table>
    </form>
</div>


</body>
</html> 