<!DOCTYPE html>

<?php
require_once("ClassAdmin.php");
session_start();

    if ($_COOKIE["cookieadmin"]==1){}

    else{
        header("Location:login.php");
    }



// CONNECT TO DATABASE
ADMIN::connect_db();
$admin = new ADMIN("", "", "");

///////////////////////////////CREATE USER//////////////////////////

if (!empty($_POST)) 
{
    if($_GET['admin']==1)
    {
        $retour = $admin->create_user($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation']);
        
    }
}

/////////////////////////DELETE A USER///////////////////////////////  

if($_GET['admin']==2) 
{ 
    $bdd = $admin->connect_db(); 
    $sql_query_delete="SELECT id, username, email FROM users";
    $response_delete = $bdd->query($sql_query_delete);

    $idget=$_GET['id'];
    if($idget!=null)
    {
        $retour = $admin->delete_user($idget);
    }
} 

/////////////////////////DISPLAY A USER///////////////////////////////  

if($_GET['admin']==4) 
{ 
    $bdd = $admin->connect_db(); 
    $sql_query_display="SELECT id, username, email FROM users";
    $response_display = $bdd->query($sql_query_display);

    $idget=$_GET['id'];
    if($idget!=null)
    {
        $bdd = $admin->connect_db(); 
        $sql_query_display_info="SELECT id, username, email FROM users WHERE id='$idget'";
        $response_display_info = $bdd->query($sql_query_display_info);
        $result_display_info = $response_display_info->fetch();
    }
} 


/////////////////////////MODIFY A USER///////////////////////////////  

if($_GET['admin']==3) 
{ 
    $bdd = $admin->connect_db(); 
    $sql_query_modify="SELECT id, username, email FROM users";
    $response_modify = $bdd->query($sql_query_modify);

    $idget=$_GET['id'];
    if($idget!=null)
    {
        $bdd = $admin->connect_db(); 
        $sql_query_modify_info="SELECT id, username, email FROM users WHERE id='$idget'";
        $response_modify_info = $bdd->query($sql_query_modify_info);
        $result_modify_info = $response_modify_info->fetch();

       $retour = $admin->modify_user($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation'], $idget);
    }
} 

///////////////////////////////CREATE PRODUCT//////////////////////////


        if($_GET['admin']==5)
        {
            $bdd = $admin->connect_db(); 
            $sql_query_create_cat="SELECT id, name FROM categories";
            $response_create_cat = $bdd->query($sql_query_create_cat);

            $retour = $admin->create_product($_POST['name'], $_POST['price'], $_POST['category']);

        }
    
/////////////////////////DELETE A PRODUCT///////////////////////////////  

if($_GET['admin']==6) 
{ 
$bdd = $admin->connect_db(); 
$sql_query_delete="SELECT id, name, price FROM products";
$response_delete = $bdd->query($sql_query_delete);

$idget=$_GET['id'];
if($idget!=null)
{
    $admin->delete_product($idget);
}
} 

/////////////////////////DISPLAY A PRODUCT///////////////////////////////  

if($_GET['admin']==7) 
{ 
$bdd = $admin->connect_db(); 
$sql_query_display="SELECT id, name, price FROM products ";
$response_display = $bdd->query($sql_query_display);

$idget=$_GET['id'];
if($idget!=null)
{
    $bdd = $admin->connect_db(); 
    $sql_query_display_info="SELECT products.id, products.name, products.price, categories.name AS category FROM products JOIN categories ON products.category_id=categories.id WHERE products.id='$idget'";
    $response_display_info = $bdd->query($sql_query_display_info);
    $result_display_info = $response_display_info->fetch();
    $result_display_info['price'];
}
}

/////////////////////////MODIFY A PRODUCT///////////////////////////////  

if($_GET['admin']==8) 
{ 
    $bdd = $admin->connect_db(); 
    $sql_query_modify="SELECT id, name, price FROM products";
    $response_modify = $bdd->query($sql_query_modify);

    $idget=$_GET['id'];
    if($idget!=null)
    {
        $bdd = $admin->connect_db(); 
        $sql_query_modify_info="SELECT products.id, products.name, products.price, categories.name AS category FROM products JOIN categories ON products.category_id=categories.id WHERE products.id='$idget'";
        $response_modify_info = $bdd->query($sql_query_modify_info);
        $result_modify_info = $response_modify_info->fetch();

        $sql_query_modify_cat="SELECT id, name FROM categories";
        $response_modify_cat = $bdd->query($sql_query_modify_cat);

        echo ($admin->modify_product($_POST['name'], $_POST['price'], $_POST['category'], $idget));
    }
} 

/////////////////////////CREATE A CATEGORY///////////////////////////////

if($_GET['admin']==9) 
{ 
    $bdd = $admin->connect_db("localhost", "pool_php_rush", "root", "root");
    $sql_create="SELECT id, name FROM categories";
    $response_create = $bdd->query($sql_create);

    $admin->create_category($_POST['category'], $_POST['parent']);
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

<!-- ///////////////////////////// HTML //////////////////////////////// -->


<!----HTML Navigation ---->
       <section>
    
    <nav margin top = 50px>
    <div class="nav-wrapper">
      <!-- <a href="#!" class="brand-logo center">Logo</a> -->
      <ul class="left hide-on-med-and-down">
      <li><a href ="admin.php?admin=1">Create new user</a></li>
        <li><a href ="admin.php?admin=2">Delete user</a></li>
        <li><a href ="admin.php?admin=3">Edit user</a></li>
        <li><a href ="admin.php?admin=4">Display user</a></li>
        <li><a href ="admin.php?admin=5">Create new product</a></li>
        <li><a href ="admin.php?admin=6">Delete product</a></li>
        <li><a href ="admin.php?admin=7">Display product</a></li>
        <li><a href ="admin.php?admin=8">Modify product</a></li>
        <li><a href ="admin.php?admin=9">Create category</a></li>
      </ul>
    </div>
  </nav>
  
        </section>


<!----HTML form to create users---->
<section>
    <?php if($_GET['admin']==1){ ?>
        <form method="post" action="">
        <div class ="red-text center" ><H6> <?=$retour ?> </H6></div>
        
            <p> <label>Name</label> : <input type="text" name="name" value="name" min="3" max="10" /> </p>
            <p> <label>E-mail</label> : <input type="text" name="email" value="email" /> </p>
            <p> <label>Password</label> : <input type="password" name="password" value="password" min="3" max="10"/> </p>
            <p> <label>Password Confirmation</label> : <input type="password" name="password_confirmation" value="password_confirmation" min="3" max="10" /> </p>
            <p> <input type="submit" name="submit" value="Submit" /> <?= $admin ?></p>
     </form>
</section>
<?php } ?>

<!---- HTML list to delete user ---->
<section>
    <?php if($_GET['admin']==2) { ?>

        <table>
            <tr>
                <th>User ID </th>
                <th>User Name </th>
                <th>User Email </th>
                <th>Delete </th>
            </tr>
        
    <?php while($result_delete = $response_delete->fetch())
{
        $emaildelete = $result_delete['email'];
        $namedelete = $result_delete['username'];
        $iddelete = $result_delete['id'];?>
            <tr> <td><?php echo $iddelete;?></td>
            <td><?php echo $namedelete;?></td> 
            <td><?php echo $emaildelete;?></td> 
            <td><a href="admin.php?admin=2&id=<?php echo $iddelete;?>">Delete</a></td></tr>    
    <?php }} ?>
        </table>
</section>


<!---- HTML list to display user ---->
<section>
    <?php if($_GET['admin']==4 && $_GET['id']==null) { ?>
        <table>
        <tr>
            <th>User ID </th>
            <th>User Name </th>
            <th>User Email </th>
            <th>Display </th>
        </tr>

    <?php while($result_display = $response_display->fetch())
    {
        $emaildisplay = $result_display['email'];
        $namedisplay = $result_display['username'];
        $iddisplay = $result_display['id'];?>
            <tr>
                <td><?= $iddisplay;?></td>
                <td><?= $namedisplay;?></td>
                <td><?= $emaildisplay;?></td>
                <td><a href="admin.php?admin=4&id=<?php echo $iddisplay;?>">Display</a><td>
            </tr>    
    <?php }} ?>
        </table>
</section>
<section>

    <?php if($_GET['admin']==4 && $_GET['id']!=null) { 

        $emaildisplay_info = $result_display_info['email'];
        $namedisplay_info = $result_display_info['username'];
        $iddisplay_info = $result_display_info['id'];?>

  <ul class="collection">
    <li class="collection-item avatar">
      <img src="image_resources/panda/profile.png" alt="" class="circle">
      <span class="title">Name : <?php echo $namedisplay_info;?></span>
      <p>Email : <?php echo $emaildisplay_info;?> <br>
            ID : <?php echo $iddisplay_info;?>
      </p>
    </li>

    <?php } ?>
</section>

<!---- HTML list to modify user ---->

<?php if($_GET['admin']==3 && $_GET['id']==null) { ?>

<table>
    <tr>
        <th>User ID </th>
        <th>User Name </th>
        <th>User Email </th>
        <th>Modify </th>
    </tr> 
<?php while($result_modify = $response_modify->fetch())
{
    $emailmodify = $result_modify['email'];
    $namemodify = $result_modify['username'];
    $idmodify = $result_modify['id'];?>
        <tr>
            <td><?php echo $idmodify;?></td>
            <td><?php echo $namemodify;?></td> 
            <td><?php echo $emailmodify;?></td>
            <td><a href="admin.php?admin=3&id=<?php echo $idmodify;?>">Modify</a></td>
        </tr>    
<?php }} ?>
</table>

<?php if($_GET['admin']==3 && $_GET['id']!=null){ 
    $emailmodify_info = $result_modify_info['email'];
    $namedmodify_info = $result_modify_info['username'];
    //$idmodify_info = $result_modify_info['id'];?>

<form method="post" action="">
<div class ="red-text center" ><H6> <?=$retour ?> </H6></div>
   <p> <label>Name</label> : <input type="text" name="name" value=<?php echo $namedmodify_info;?> min="3" max="10" /> </p>
   <p> <label>E-mail</label> : <input type="text" name="email" value=<?php echo $emailmodify_info;?> /> </p>
   <p> <label>Password</label> : <input type="password" name="password" value="" min="3" max="10"/> </p>
   <p> <label>Password Confirmation</label> : <input type="password" name="password_confirmation" value="" min="3" max="10" /> </p>
   <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
<?php } ?>

<!----HTML form to create products---->
<?php if($_GET['admin']==5 )  {  ?>


<form method="post" action="">
<div class ="red-text center" ><H6> <?=$retour ?> </H6></div>
   <p> <label>Product name</label> : <input type="text" name="name" value="name"/> </p>
   <p> <label>Price</label> : <input type="text" name="price" value="price" /> </p>
   <p> <label>Category</label> :    
   
   <select class="browser-default" name="category">
        <?php while($result_create_cat = $response_create_cat->fetch())
        {
            $category = $result_create_cat['name'];?>     
            <option value="<?=$category?>"><?=$category?></option>
          
        <?php } ?>
    </select>
   </p>
   <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
<?php } ?>




<!---- HTML list to delete product ---->

<?php if($_GET['admin']==6) { ?>
<table>
    <tr>
        <th>Product ID </th>
        <th>Product Name </th>
        <th>Product Price </th>
        <th>Delete </th>
    </tr>

<?php while($result_delete = $response_delete->fetch())
{
    $pricedelete = $result_delete['price'];
    $namedelete = $result_delete['name'];
    $iddelete = $result_delete['id'];?>
        <tr> <td><?php echo $iddelete;?></td>
        <td><?php echo $namedelete;?></td> 
        <td><?php echo $pricedelete;?></td> 
        <td><a href="admin.php?admin=6&id=<?php echo $iddelete;?>">Delete</a></td></tr>    
<?php }} ?>
</table>


<!---- HTML list to display Products ---->

<?php if($_GET['admin']==7 && $_GET['id']==null) { ?>
<table>
<tr>
    <th>Product ID </th>
    <th>Product Name </th>
    <th>Product price </th>
    <th>Display </th>
</tr>

<?php while($result_display = $response_display->fetch())
{
    $pricedisplay = $result_display['price'];
    $namedisplay = $result_display['name'];
    $iddisplay = $result_display['id'];?>
        <tr>
            <td><?php echo $iddisplay;?></td>
            <td><?php echo $namedisplay;?></td>
            <td><?php echo $pricedisplay;?></td>
            <td><a href="admin.php?admin=7&id=<?php echo $iddisplay;?>">Display</a><td>
        </tr>    
<?php }} ?>
</table>

<?php if($_GET['admin']==7 && $_GET['id']!=null) { 

$pricedisplay_info = $result_display_info['price'];
$namedisplay_info = $result_display_info['name'];
$iddisplay_info = $result_display_info['id'];
$categorydisplay_info = $result_display_info['category'];?>
      
  <ul class="collection">
    <li class="collection-item avatar">
      <img src="image_resources/panda/products/<?=$namedisplay_info?>.jpg" alt="" class="circle">
      <span class="title">Name : <?= $namedisplay_info;?></span>
      <p>Price : <?= $pricedisplay_info?> € <br>
        Category : <?= $categorydisplay_info?>
      </p>
    </li>
    </ul>
    <?php } ?> 



<!---- HTML list to modify product ---->

<?php if($_GET['admin']==8 && $_GET['id']==null) { ?>

<table>
    <tr>
        <th>Product ID </th>
        <th>Product Name </th>
        <th>Product Price </th>
        <th>Modify </th>
    </tr> 
<?php while($result_modify = $response_modify->fetch())
{
    $pricemodify = $result_modify['price'];
    $namemodify = $result_modify['name'];
    $idmodify = $result_modify['id'];?>
        <tr>
            <td><?php echo $idmodify;?></td>
            <td><?php echo $namemodify;?></td> 
            <td><?php echo $pricemodify;?></td>
            <td><a href="admin.php?admin=8&id=<?php echo $idmodify;?>">Modify</a></td>
        </tr>    
<?php }} ?>
</table>

<?php if($_GET['admin']==8 && $_GET['id']!=null){ 
    $pricemodify_info = $result_modify_info['price'];
    $namedmodify_info = $result_modify_info['name'];
    $categorymodify_info = $result_modify_info['category'];?>

<form method="post" action="">
   <p> <label>Name</label> : <input type="text" name="name" value=<?php echo $namedmodify_info;?> min="3" max="10" /> </p>
   <p> <label>E-mail</label> : <input type="text" name="price" value=<?php echo $pricemodify_info;?> /> </p>
   <p> <label>Category</label> : 

     <select class="browser-default" name="category">
        <?php while($result_modify_info = $response_modify_cat->fetch())
             {
                    $category = $result_modify_info['name'];?>     
                    <option value="<?=$category?>"><?=$category?></option>
          
        <?php } ?>
    </select>

   <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
<?php } ?>

<!---- HTML list to create category ---->

<?php if($_GET['admin']==9){ ?>

<form method="post" action="">
   <p> <label>Category</label> : <input type="text" name="category" value=""/> </p>
   <p> <label>Parent category</label> : 
   <select class="browser-default" name="parent">
   <?php while($result_create = $response_create->fetch())
        {
            $category = $result_create['name'];?>   
            <OPTION value="<?=$category?>"> <?= $category?> </OPTION> 
    <?php } ?>
   </p>
   </select>

   <p> <input type="submit" name="submit" value="Submit" /> </p>
</form>
<?php } ?>


</body>

<!-- _______________________FOOTER -->
<footer>

            
            <h6 class="page-footer white-text center-align"> Tous les produits sont garanties "équitables". Si 
                vous avez des questions, n'hésitez pas à nous contacter.<br/> Email : xxxxxx@panda.com - Tel : xx.xx.xx.xx.xx</h6>
      
        
</footer>


</html>
