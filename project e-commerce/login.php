<!DOCTYPE html>
<html>
<?php
require_once("user.php");

// CONNECT TO DATABASE
user::connect_db("localhost", "pool_php_rush", "root", "root");


//SET VARIABLE
if (!empty($_POST)) {
$email = $_POST["Email"];
$password = $_POST["Password"];
$remember = $_POST["remember_me"];
//echo $remember;
$login = new user("", $email, $password);
$retour=$login->login($email, $password, $remember);
}

//SQL QUERY



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

      </head>
    <body class="container">
        <header> 
        <nav>
                <div class="nav-wrapper">
                <a href="index.php" class="brand-logo center">Bienvenue <img src ="image_resources/panda/panda.png" width="8%" alt = "logo"></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="inscription.php"><i class="material-icons" style="color:white">create</i></a></li>
                <li><a href="products.php"><i class="material-icons" style="color:white">store</i></a></li>
                <li><a href="search.php"><i class="material-icons" style="color:white">search</i></a></li>
            </ul>
                </div>
        </nav>
        </header>

 <!-- HTML FORM  -->
<body>

<form method="post" action="">
   <p> <label>Email</label> : <input type="text" name="Email"/> </p>
        <div class="red-text"> <?= $retour ?> </div>
   <p> <label>Password</label> : <input type="password" name="Password"/> </p>
         <div class="red-text"><?= $retour ?> </div>
   <!-- <p> <label>Remember me :<input type="checkbox" class="filled-in" name="remember_me" value="1" /></label><span></span></p> -->
   <p>   <label><input type="checkbox" class="filled-in" name="remember_me" value="1" /> <span>Remember me</span></label> </p>
   <p>   <input type="submit" name="Submit" value="Submit"></p>
       

   <!-- <p> <input button class="btn waves-effect green-light" type="submit" name="submit" value="Submit" /> <i class="material-icons right">
 Submit<i class="material-icons right">send</i> </button> </p> -->
</form>
<p>If you don't have an account yet, please register by filling-up the <a href="inscription.php">the form here </a></p>
<footer>
            
            <h6 class="page-footer white-text center-align"> Tous les produits sont garanties "équitables". Si 
                vous avez des questions, n'hésitez pas à nous contacter.<br/> Email : xxxxxx@panda.com - Tel : xx.xx.xx.xx.xx</h6>
            
        
</footer>
    </body>

</html>
