<!DOCTYPE html>
<html>
<?php
require_once("ClassProducts.php");
require_once("user.php");

session_start();

//GREETING

if($_SESSION["newsession"]!=null)
{
   $welcome_session = "Hello ".$_SESSION["newsession"];
}
else if($_COOKIE['newcookie']!=null)
{
    $welcome_cookie = "Hello ".$_COOKIE["newcookie"];
}
else
{
    header("Location:login.php");
}


$bdd = new PDO("mysql:host=localhost;dbname=pool_php_rush", "root", "root");
/////////////// DISPLAY ALL PRODUCT ///////////
if (empty($_POST['query']) && empty($_POST['min_price']) 
    && empty($_POST['max_price']) && empty($_POST['category'])){
  
    $sql_query="SELECT id, name, price FROM products";
    $result = $bdd->query($sql_query);
}


//////// DISPLAY IF QUERY by NAME

 if (!empty($_POST['query'])){
    $query = $_POST['query'];

    $sql_query="SELECT id, name, price FROM products where name like '%".$query."%'";
    $result = $bdd->query($sql_query);
}

/////////////// DISPLAY IF QUERY BY MIN PRICE

 if (!empty($_POST['min_price'])){
    $min_price = $_POST['min_price'];
        
    $sql_query="SELECT id, name, price FROM products where price >= '$min_price'";
    $result = $bdd->query($sql_query);
}

/////////////// DISPLAY IF QUERY BY MAX PRICE

 if($_POST['min_price']==NULL && ($_POST['query'])==NULL && !empty($_POST['max_price'])){
    $max_price = $_POST['max_price'];
        
    $sql_query="SELECT id, name, price FROM products where price <= '$max_price'";
    $result = $bdd->query($sql_query);
}

/////////////// DISPLAY IF QUERY BY IN BETWEEN PRICE

if (!empty($_POST['min_price'] && $_POST['max_price'])){
    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];

    $sql_query="SELECT id, name, price FROM products where price BETWEEN '$min_price' AND '$max_price'";
    $result = $bdd->query($sql_query);
}

////////////////////////////////DISPLAY CATEGORIES///////////////////////

    $categoryname=$_POST['category'];
 
    // REQUEST to FILL CAT LIST
    $sql_query_display_1="SELECT id, name, parent_id FROM categories ";
    $response_display_1 = $bdd->query($sql_query_display_1);
   // find CAT ID
        if($_POST['category']!= NULL){
                $sqlquery_display_CATID ="SELECT id FROM categories WHERE name = '$categoryname'";
                $response_display_2 = $bdd->query($sqlquery_display_CATID);
                $result_cat = $response_display_2->fetch();
                
                $idcat = $result_cat['id'];
                
                $sql_query="SELECT products.id, products.name, products.price FROM products 
                JOIN categories ON products.category_id = categories.id  WHERE products.category_id = '$idcat'";
                $result = $bdd->query($sql_query);
               
                
        }


?>

<html>
<!-- ____________________________________________________START OF THE WEBSITE PAGE -->
     <head>
        <meta charset="UTF-8">
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="CSS/materialize.css" />
        <link rel="stylesheet" href="CSS/style.css" /> 
        <title> La folie des Pandas ! </title>

    </head> 
    <body class="container">
        <header> 
        <nav>
                <div class="nav-wrapper">
                <a href="index.php" class="brand-logo center">Bienvenue  <img src ="image_resources/panda/panda.png" width="8%" alt = "logo"></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
           
<!-- ____________________Admin token -->
            <?php
                if ($_COOKIE["cookieadmin"]==1)
                {?>
                    <li><a href="admin.php"><i class="material-icons" style="color:white">build</i></a></li>
                <?php } ?>
<!-- ____________________Admin token -->        
                <li><a href="products.php"><i class="material-icons" style="color:white">store</i></a></li>
                <li><a href="search.php"><i class="material-icons" style="color:white">search</i></a></li>
                <li><a href="logout.php"><i class="material-icons" style="color:white" >lock_open</i></a></li>
            </ul>
                </div> 
        </nav>
        </header><br/><br/>



 <section>
 <div class ="row" >


<!-- _______________________HTML SEARCH by NAME QUERY -->

        <div class ="row col s4">
            <form action="search.php" method="POST">
                <input type="text" name="query" placeholder="what are you looking for ?" />
                <input type="submit" value="Search" />
            </form>
        </div>
        <!-- <div class ="row col s3">
        </div> -->

        <!-- ___________________________HTML by category -->
<div class = "row col s4">

<form method="post" action="">
    <select class="browser-default" name="category" value="category">
        <?php while($result_display_1 = $response_display_1->fetch())
        {
            $name=$result_display_1['name'];
            $id=$result_display_1['id'];?>
            <OPTION> <?php echo $name;?> </OPTION>

        <?php } ?>
    </select>
    <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
</div>




<!-- ___________________HTML SEARCH by PRICE -->

        <div class = "row col s4">
            <form action="search.php" method="POST">
                <label> Min Price : </label> <input type="text" name="min_price" placeholder="€" />
                <label> Max Price : </label> <input type="text" name="max_price" placeholder="€€€" />
                <input type="submit" value="Search" />
            </form>
        </div>

</div>
</section>
<!-- _____________________ PRODUCT DISPLAY -->
<body>
<section>
<div class="row">
<?php
    // echo $display_result['name'];
    while($display_result = $result->fetch())
    {
    $namedisplay = $display_result['name'];
    $pricedisplay = $display_result['price'];
    
?>

                <div class="col s12 m4 13">
                    <div class="card">
                        <div class="card-image">
                            <img src="image_resources/panda/products/<?= $namedisplay?>.jpg" >
                        </div>
                        <div class="card-content">
                          <p> <?php echo $namedisplay ?>  <br/> <?php echo $pricedisplay ?> €</p>
                        </div>
                        <!-- <div class="card-action">
                          <a href="#">Commander</a>
                        </div> -->
                    </div>
                </div> 
  
    <?php    } ?>
</div> 
</section>


</body>
<footer>
            
            <h6 class="page-footer white-text center-align"> Tous les produits sont garanties "équitables". Si 
                vous avez des questions, n'hésitez pas à nous contacter.<br/> Email : xxxxxx@panda.com - Tel : xx.xx.xx.xx.xx</h6>
            
        
</footer>
    </body>

</html>