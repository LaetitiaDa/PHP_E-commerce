<?php

class Admin{


//__________Attribute to login
public $user_name;
public $user_email;
public $user_password;
public $user_passwordc;
public $name;
public $email;
public $password;
public $reg_mail = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";
public $id_delete;

//____________Construct

public function __construct($name=null, $email=null, $password=null){
   
    $this->name= $name;
    $this->email = $email;
    $this->password = $password;
    
}

/////////////////////////CONNEXION TO DB///////////////////////

    public function connect_db($host, $db, $username, $passwd){

        try{
            $bdd = new PDO("mysql:host=$host;dbname=$db", $username, $passwd);
            //echo "Conection to DB successful\n";
            return $bdd;    
        }
        
        catch(PDOException $error){
            $message = $error->getMessage();
            echo "Error connexion to DB\n";
            return;
        }
    }


/////////////////////////CREATE A USER////////////////////////////

    public function create_user($user_name, $user_email, $user_password, $user_passwordc)
    {
        $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
        
        $this->user_email = $user_email;
        $this->user_password = $user_password;
        $this->user_name = $user_name;
        $this->user_passwordc = $user_passwordc;
        $reg_exp= " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";

        if(strlen($this->user_name)>=3 && strlen($this->user_name)<=10
            && $this->user_password==$this->user_passwordc && strlen($this->user_password)>=3 && strlen($this->user_password)<=10
            && preg_match($reg_exp, $this->user_email)==true)
            {
                $passwordhash = password_hash($this->user_password, PASSWORD_DEFAULT);
                $sql= "INSERT INTO users (username, password, email, admin) VALUES ('$this->user_name', '$passwordhash', '$this->user_email', 0)";
                $result = $bdd->exec($sql);   
                return "A panda joined the team.";
            } 
        else
            {
                if($this->user_name!=null && (strlen($this->user_name)<3 || strlen($this->user_name)>10))
                {
                    return "Name must be between 3 and 10 characters";
                }
                if($this->user_password!=null && ($this->user_password!=$this->user_passwordc || strlen($this->user_password)<3 || strlen($this->user_password)>10))
                {
                    return "Password must be between 3 and 10 characters and same as confirmation";
                }
                if($this->user_email!=null && preg_match($reg_mail, $this->user_email)==false)
                {
                    return "Wrong email format";
                }
            }          
    }



/////////////////////////////////////DELETE USER////////////////////////////////


public function delete_user($id)
    {
        $this->id_delete= $id;

            $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
            $sql_delete = "DELETE FROM users WHERE id='$this->id_delete'";
            $bdd->exec($sql_delete);
            header("Location:admin.php?admin=2");
            return "Panda left the team.";           
    }  



////////////////////////////////////MODIFY USERS //////////////////////////////////////

public function modify_user($user_name, $user_email, $user_password, $user_passwordc, $getid)
    {   $reg_exp= " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";
        $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
        
        $this->user_email = $user_email;
        $this->user_password = $user_password;
        $this->user_name = $user_name;
        $this->user_passwordc = $user_passwordc;
        $this->getid = $getid;
        $this->reg_exp = $reg_exp;
        
        if($this->user_name!=null && (strlen($this->user_name)<3 || strlen($this->user_name)>10))
            {
                return 'Name must be between 3 and 10 characters';
            }

        if($this->user_password!=null && ($this->user_password!=$this->user_passwordc || (strlen($this->user_password)<3 || strlen($this->user_password)>10)))
            {
                return "Password must be between 3 and 10 characters and same as confirmation";
            }

        if($this->user_email!=null && preg_match($this->reg_exp, $this->user_email)==false)
            {
                return "Wrong email format";
            }    
        if($this->user_name!=null && strlen($this->user_name)>=3 && strlen($this->user_name)<=10)
            {
                $sql= "UPDATE users SET username='$this->user_name' WHERE id ='$this->getid'";
                $bdd->exec($sql);
                header("Location: admin.php?admin=3&id=$this->getid");
            } 
        if($this->user_password!=null && $this->user_password==$this->user_passwordc && strlen($this->user_password)>=3 && strlen($this->user_password)<=10)
            {
                $passwordhash = password_hash($this->user_password, PASSWORD_DEFAULT);
                $sql= "UPDATE users SET password='$passwordhash' WHERE id ='$this->getid'";
                $bdd->exec($sql);
                header("Location: admin.php?admin=3&id=$this->getid");
            } 
        if($this->user_email!=null && preg_match($reg_exp, $this->user_email)==true)
            {
                $sql= "UPDATE users SET email='$this->user_email' WHERE id ='$this->getid'";
                $bdd->exec($sql);
                header("Location: admin.php?admin=3&id=$this->getid");
            } 
    
    }
  /////////////////////////CREATE A PRODUCT////////////////////////////

  public function create_product($product_name=null, $product_price=null, $product_cat=null)
  {
      $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
      
      $this->product_name = $product_name;
      $this->product_price = $product_price;
      $this->product_cat = $product_cat;

      if($this->product_name!=null && $this->product_price!=null && $this->product_cat!=null)
          {
              $sql_find="SELECT id FROM categories WHERE name='$this->product_cat'";
              $response_find=$bdd->query($sql_find);
              $result_find=$response_find->fetch();
              $this->product_category = $result_find['id'];
              $sql= "INSERT INTO products (name, price, category_id) VALUES ('$this->product_name', '$this->product_price', '$this->product_category')";
              $bdd->exec($sql);   
          } 
      else
      {
          return "all fields must be filled in";
      }
  }

/////////////////////////////////////DELETE PRODUCT////////////////////////////////


public function delete_product($id)
  {
      $this->id_delete= $id;

          $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
          $sql_delete = "DELETE FROM products WHERE id='$this->id_delete'";
          $bdd->exec($sql_delete);
          header("Location: admin.php?admin=6");          
  }  



////////////////////////////////////MODIFY PRODUCT //////////////////////////////////////

public function modify_product($name, $price, $category, $getid)
  {
      $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
      
      $this->price = $price;
      $this->name = $name;
      $this->category = $category;
      $this->getid = $getid;
      
      if($this->price!=null)
          {
              $sql= "UPDATE products SET price='$this->price' WHERE id ='$this->getid'";
              $bdd->exec($sql);
              header("Location: admin.php?admin=8&id=$this->getid");
          } 
          
      if($this->name!=null)
          {
              $sql= "UPDATE products SET name='$this->name' WHERE id ='$this->getid'";
              $bdd->exec($sql);
              header("Location: admin.php?admin=8&id=$this->getid");
          } 
      
      if($this->category!=null)
          {
              $sql_find="SELECT id FROM categories WHERE name='$this->category'";
              $response_find=$bdd->query($sql_find);
              $result_find=$response_find->fetch();
              $this->category = $result_find['id'];
              $sql= "UPDATE products SET category_id='$this->category' WHERE id ='$this->getid'";
              $bdd->exec($sql);
              header("Location: admin.php?admin=8&id=$this->getid");
          } 
      
         
            
  }

    /////////////////////////////////////CREATE CATEGORY////////////////////////////////

    public function create_category($category, $parent)
    {
        $this->category = $category;
        $this->parent = $parent;

        if($this->category!=null)
        {
            $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
            $sql_find="SELECT id FROM categories WHERE name='$this->parent'";
            $response_find=$bdd->query($sql_find);
            $result_find=$response_find->fetch();
            $this->parent_cat = $result_find['id'];  
            $sql= "INSERT INTO categories (name, parent_id) VALUES ('$this->category', '$this->parent_cat')";
            $bdd->exec($sql); 
        }      
    }

}

?>