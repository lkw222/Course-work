<html>
  <head>
    <title>
      The menu
    </title>
  </head>

  <style>
  body{
    font-family: arial;
    font-size:10spx;
    background-color: #FAAC58;
    background-size: cover;
    text-align: center;   
  }
  h1 {
        text-align:center;
      }
    table {
        margin:0 auto;
        width:98%;
        border:2px solid #aaa;
        border-collapse:collapse;
      }
    table th, table td {
        border:2px solid #aaa;
        padding:5px;
      }
    th {
        background-color:#eee;
      }
  div{
    width:auto;
    height: auto;
  }
  #pic{
    width: 100%;
    height: 100%;
  }
  #p{
    width:25%;
    height:150px;
  }
  #total{
    font-size:30px;
    text-align:right;
  }
  </style>

  <script type="text/javascript">
    var tbody;
        function addCart(b){
        var tr = b.parentNode.parentNode;//返回当前行
        var tds = tr.getElementsByTagName("td");//返回td那行所有内容
        var name = tds[1].innerText;//第二个是名字
        var price = tds[4].innerText;//第五个是价格
        
        tbody = document.getElementById("cart");//empty at the beginning
        var amount = 1;
        if(!hasMeal(name)){    //不为空     
          var newtr = document.createElement("tr");  //新的一行      
          newtr.innerHTML = 
          '<td>'+name+'</td>'+
          '<td>'+price+'</td>'+
          '<td align="center">'+
            '<input type="button" value="-" onclick="reduce(this);"> '+
            '<input type="text" size="5" readonly value='+amount+'> '+
            '<input type="button" value="+" onclick="add(this);"/>'+
          '</td>'+
          '<td>'+price+'</td>'+
          '<td align="center"><input type="button" value="delete" onclick="del(this);" style="zoom:180%;"/></td>';
          //在tbody下插入一行
          tbody.appendChild(newtr);
        } else {
        var trs = tbody.getElementsByTagName("tr");
          for(var i=0;i<trs.length;i++){
            if(trs[i].getElementsByTagName("td")[0].innerText==name){
              amount = trs[i].getElementsByTagName("td")[2].getElementsByTagName("input")[1].value++;              
              trs[i].getElementsByTagName("td")[3].innerText = (++amount)*price;
            }
          }
        }
      }
      
      function hasMeal(name){
        tbody = document.getElementById("cart");
        var trs = tbody.getElementsByTagName("tr");
        for(var i=0;i<trs.length;i++){
          if(trs[i].getElementsByTagName("td")[0].innerText == name){
            return true;            
          }
        }
        return false;
      }//empty or not
      
      function add(b){
          var input = b.parentNode.getElementsByTagName("input")[1];
          var amount = ++input.value;
          var price = b.parentNode.parentNode.getElementsByTagName("td")[1].innerText
          b.parentNode.parentNode.getElementsByTagName("td")[3].innerText = amount*price;
      }
      
      function reduce(b){
          var input = b.parentNode.getElementsByTagName("input")[1];        
          var amount = --input.value;
          if(amount<1){
              amount = ++input.value;
          }
          var price = b.parentNode.parentNode.getElementsByTagName("td")[1].innerText
          b.parentNode.parentNode.getElementsByTagName("td")[3].innerText = amount*price;
      }
      
      function del(b){
          var tr = b.parentNode.parentNode;
          b.parentNode.parentNode.parentNode.removeChild(tr);
      }

      var zongyuxiewanle = new Array();
      var price = new Array();
      function checkout(){
        tbody = document.getElementById("cart");//订单行
        var trs = tbody.getElementsByTagName("tr");//每一行订单
        var name = new Array();
        var count = new Array();
        for(var i=0;i<trs.length;i++){
          name[i] =  trs[i].getElementsByTagName("td")[0].innerText;
          count[i] =  trs[i].getElementsByTagName("td")[2].getElementsByTagName("input")[1].value;
          zongyuxiewanle[i] = name[i]+'*'+count[i];
          price[i] =  trs[i].getElementsByTagName("td")[3].innerText;
          //终于写完了喜极而泣。什么天杀的javascript.本美少女为什么要受这种苦
        }
        document.getElementById("xixi").value = zongyuxiewanle;
        document.getElementById("didi").value = price;
      }
    </script>
  </script>

  <body>
    <?php
      $servername = "localhost";
      $username = "root";
      $password = "mysql";
      $dbname = "Hungry";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      } 
      echo "<br><h1><a href='home.php?uid={$_GET['uid']}' title=''>Back to homepage</a></h1>";
            
      $sql = "SELECT Meals.picture,meals.name, Meals.description,Meals.calories,Menus.price FROM Meals,Menus where Meals.meal_id=Menus.meal_id and Menus.restaurant_id={$_GET['rid']}";
      $result = $conn->query($sql);       
      
      echo"<h1>The menus: </h1>";
      
      if ($result){
        echo "<table border=1px>";
        echo"<table>
          <tr>
          <th>picture</th>
              <th>name</th>
              <th>discription</th>
              <th>calories</th>
              <th>price</th>
              <th>order</th>
              </tr>";
        while($row = $result->fetch_assoc()){
          echo "<tr>
          <td id = 'p'>
          <img id ='pic' src = \"{$row[picture]}\" onerror=\"this.src='error.png'\"></td>
          <td>{$row[name]}</td>
          <div id='dis'><td>{$row[description]}</div></td>
          <td>{$row[calories]}</td>
          <td><div id = 'price'>{$row[price]}</div></td>
          <td align='center'>
                  <input type='button' value='order' onclick='addCart(this);' style='zoom:180%;'/>
              </td> 
          </tr>";
        }
        echo "</table>";
      }
    
      $conn->close();
    ?>

    <h1>Shopping Cart: </h1>
    <table>

    <thead>
      <tr>
      <th>Meal</th>
      <th>Unit Price</th>
      <th>Amount</th>
      <th>Price</th>
      <th>Delete</th>
      </tr>
      </thead>

      <tbody id="cart">
      </tbody>

      <tfoot>
      <tr>
      <td colspan="5" align='center'>
      <form name="queryInput" action="checkout.php" method="POST">
      <input type = 'hidden' id = 'xixi' name = 'detail'>
      <input type = 'hidden' id = 'didi' name = 'price'>
      <input type = 'hidden' name = 'uid' value="<?php echo $_GET['uid'] ?>">
      <input type = 'hidden' name = 'rid' value="<?php echo $_GET['rid'] ?>">
      <input type = 'submit' value='Check Out' onclick='checkout();' style='zoom:200%;' align='center'>
      </form>
      </td>
      </tr>
      </tfoot>

    </table>
  </body>
</html>