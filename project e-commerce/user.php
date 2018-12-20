<?php

class user{

//________Attribute for connect_db
    // public $host = "localhost";
    // public $db = "pool_php_rush";
    // public $username = "root";
    // public $passwd = "root";

//__________Attribute to login
    public $name;
    public $email;
    public $password;
    public $checkbox;
    public $reg_mail = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";


//____________Construct

    public function __construct($name, $email, $password, $checkbox=NULL){
       
        $this->name= $name;
        $this->email = $email;
        $this->password = $password;
        
    }

//___________connexion to db


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

    public function login($email=NULL, $password=NULL,$checkbox=NULL){
            $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");
            $this->email = $email;
            $this->password = $password;
            $this->checkbox = $checkbox;
            
            if($this->email!=null)
            {
                $sqlquery = "SELECT id, username, password, admin FROM users WHERE email = '$this->email'";
                $response= $bdd->query($sqlquery);
                $resultquery = $response->fetch();
            }
    
// CONDITION IF PASSWORD AND EMAIL NOK DISPLAYS ERROR AND CREATES SESSION IF OK
            if(($this->email!=null && $this->password!=null)
                && ($resultquery['password']==null 
                || password_verify($this->password, $resultquery['password'])==false))
                {
                    return $incorrect = "Incorrect email/password\n";
                   
                }
            else if($this->email == null && $this->password == null){echo "retour";}
                
            else
                {
                if($this->checkbox == 1)
                    {
                        setcookie("newcookie", $resultquery['username'], time()+3600);
                        $_COOKIE["newcookie"]=$resultquery['username'];
                        header("Location:index.php");
                    }
                        else
                        {
                            session_start();
                            $_SESSION["newsession"]=$resultquery['username'];
                            header("Location:index.php");
                        }
                }
// cookie saving admin
setcookie("cookieadmin", $resultquery['admin'], time()+3600);
$_COOKIE["cookieadmin"] = $resultquery['admin'];
    }

        public function register($name, $email, $password, $password_conf){
            $reg_mail = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";
            $bdd = $this->connect_db("localhost", "pool_php_rush", "root", "root");

            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->password_conf = $password_conf;
            $this->reg_mail = $reg_mail;
            
            


    //First, in the confition condition to fill in database 
    if(strlen($this->name)>=3 && strlen($this->name)<=10
    && $this->password==$this->password_conf && strlen($this->password)>=3 && strlen($this->password)<=10
    && preg_match($this->reg_mail, $this->email)==true)
    {   
        $passwordhash = password_hash($this->password, PASSWORD_DEFAULT);
        $sql= "INSERT INTO users (username, password, email, admin) VALUES ('$this->name', '$passwordhash', '$this->email', 0)";
        $result = $bdd->exec($sql);   
        echo "User Created";
        header("Location:login.php");
    }
    else //error conditions display
    {
        
        if($this->name!=null && (strlen($this->name)<3 || strlen($this->name)>10))
        {   
             return "Name must be between 3 and 10 characters";
        }
        if($this->password!=null && ($this->password!=$this->password_conf || strlen($this->password)<3 || strlen($this->password)>10))
        {
             return "Password must be between 3 and 10 characters and same as confirmation";
        }
        if($this->email!=null && preg_match($this->reg_mail, $this->email)==false)
        {
             return "Wrong email format";
        }
      
        
    }
}

}
?>