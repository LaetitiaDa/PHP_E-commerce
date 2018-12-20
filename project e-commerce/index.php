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


?>
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
                <a href="index.php" class="brand-logo center">Bienvenue <img src ="image_resources/panda/panda.png" width="8%" alt = "logo"></a>
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

    <main>
            
            <div class="row no-padding">
                
                    <img src ="image_resources/panda/panda.jpg" width="100%" alt = "logo">                               
            </div>
            <div class="nav-wrapper">
                    <H1> <?= $welcome_session. $welcome_cookie ?> </H1>
            </div>
    </main>


<!-- ___________________________________________________Navigation des pages de ventes -->
    <section>

     <div class="col s12 m7">
     <div class="card horizontal">
      <div class="card-image">
        <img src="image_resources/panda/panda_shop.jpg">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p><H5>We are happy to see you again ! Don't forget to visit our shop, you might find 
          some new interesting products !</H5></p>
        </div>
        <div class="card-action">
          <a href="products.php">Visit our online shop now</a>
        </div>
      </div>
    </div>
  </div>

          
    </section>



<footer>
            
            <h6 class="page-footer white-text center-align"> Tous les produits sont garanties "équitables". Si 
                vous avez des questions, n'hésitez pas à nous contacter.<br/> Email : xxxxxx@panda.com - Tel : xx.xx.xx.xx.xx</h6>
            
        
</footer>
    </body>

</html>