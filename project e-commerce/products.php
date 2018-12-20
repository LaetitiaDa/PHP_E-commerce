<!DOCTYPE html>

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

    if(empty($_POST['category']))
        {
            $sql_query_display="SELECT id, name, price FROM products";
            $response_display = $bdd->query($sql_query_display);
        } 
    if($_POST['category']=="Price Asc"){

        $sql_query_display="SELECT id, name, price FROM products ORDER BY price ASC";
        $response_display = $bdd->query($sql_query_display);
    }
    
    if($_POST['category']=="Price Desc"){

        $sql_query_display="SELECT id, name, price FROM products ORDER BY price DESC";
        $response_display = $bdd->query($sql_query_display);
    }
   
    if($_POST['category']=="Product A->Z"){

        $sql_query_display="SELECT id, name, price FROM products ORDER BY name ASC";
        $response_display = $bdd->query($sql_query_display);
    }
   
    if($_POST['category']=="Product Z->A"){

        $sql_query_display="SELECT id, name, price FROM products ORDER BY name DESC";
        $response_display = $bdd->query($sql_query_display);
    }

?>


<HTML>
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
                <a href="index.php" class="brand-logo center">Bienvenue<img src ="image_resources/panda/panda.png" width="8%" alt = "logo"></a>
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
        </header>

<!-- ___________________________TRIE Croissant / DESCROISSANT -->

<section>
    <div class="row">
    <div class = "row col s4">

<form method="post" action="">
    <select class="browser-default" name="category" value="category">
                <Option>Price Asc</option>
                <option>Price Desc</option>
                <option>Product A->Z</option>
                <option> Product Z->A</option>
    </select>
    <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
</div>
</div>  



            <!-- _____________________________TEST PRODUCT LIST -->
    
    <section>

     <div class="row">
<?php
    while($result_display = $response_display->fetch())
    {
    $namedisplay = $result_display['name'];
    $pricedisplay = $result_display['price'];
?>
        



<!-- _____________________ MISE EN PAGE DES PRODUITS -->


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
<footer>
            
            <h6 class="page-footer white-text center-align"> Tous les produits sont garanties "équitables". Si 
                vous avez des questions, n'hésitez pas à nous contacter.<br/> Email : xxxxxx@panda.com - Tel : xx.xx.xx.xx.xx</h6>
            
        
</footer>
    </body>

</html>