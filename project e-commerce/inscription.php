<!DOCTYPE html>
<?php
require_once("user.php");

// CONNECT TO DATABASE

user::connect_db();


//REGISTER IN DATABASE

    //variable definition
   
    if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_conf = $_POST['password_confirmation'];
    //$reg_mail = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";
    
    $new = new user($name, $email, $password, $password_conf);
    $validate = $new->register($name, $email, $password, $password_conf);
    echo $nametest;
    //var_dump($validate);
    //$nametest=$new->register($name, $email, $password, $password_conf);
    // $emailtest=$new->register($name, $email, $password, $password_conf);
    // $passwordtest=$new->register($name, $email, $password, $password_conf);
    
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
                <a href="index.php" class="brand-logo center">Bienvenue <img src ="image_resources/panda/panda.png" width="8%" alt = "logo"></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="login.php"><i class="material-icons" style="color:white">lock_open</i></a></li>
                <li><a href="products.php"><i class="material-icons" style="color:white">store</i></a></li>
                <li><a href="search.php"><i class="material-icons" style="color:white">search</i></a></li>
            </ul>
                </div>
        </nav>
        </header>

 <!-- HTML FORM  -->
<body>
<form method="post" action="">
        <div class ="red-text center" ><?= $validate ?> </div>
   <p> <label>Name</label> : <input type="text" name="name" value="name" min="3" max="10" /> </p>
        
   <p> <label>E-mail</label> : <input type="text" name="email" value="email" /> </p>
       
   <p> <label>Password</label> : <input type="password" name="password" value="password" min="3" max="10"/> </p>
  
   <p> <label>Password Confirmation</label> : <input type="password" name="password_confirmation" value="password_confirmation" min="3" max="10" /> </p>
    
   <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
<footer>
            
            <h6 class="page-footer white-text center-align"> Tous les produits sont garanties "équitables". Si 
                vous avez des questions, n'hésitez pas à nous contacter.<br/> Email : xxxxxx@panda.com - Tel : xx.xx.xx.xx.xx</h6>
            
        
</footer>
    </body>
