<?php 
class Login{
    protected $localhost = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $db = 'loginform';
    protected $connection;
    public $errors= array();
    function __construct(){
        $this->connection=mysqli_connect($this->localhost,$this->user,$this->pass,$this->db);
    }
    protected function checkInput($var){
        //mthods clear any extra char, space (mistakes) in value (inputed by users)
        $var=htmlspecialchars($var);
        $var=trim($var);
        $var=stripslashes($var);
        return $var;
    }
    protected function hashPwd($pas){
        $pas=md5($pas);
        return $pas;
    }
    public function insertIntoTb($uname,$email,$pwd){
        //insert value in to table function
        $uname=$this->checkInput($uname);
        $email=$this->checkInput($email);
        $pwd=$this->hashPwd($pwd);
        //calling check error method
        //recive return value from checkErrors method and if true
        //by deafult true
        if($this->checkErrors($uname,$email,$pwd)==true){
            //checks for already existed user if true (by else return)
            if($this->checkusername($uname)){
            //insert in to db
            if($this->insertIntoDb($uname,$email,$pwd)){$this->errors=['submitted successfully'];//display msg}
            }
        }

    }
}
    //check errors in input line too long pwd, uname etc
    protected function checkErrors($uname,$email,$pwd){
        if(strlen($uname)>10 || strlen($uname)<5){ //takes multiple character
            array_push($this->errors,'username is too long , write btn 5-10 char');
            //return $this->errors;
            return false;
        }
        if(strlen($email)>20){
            array_push($this->errors,'email is too long');
            // return $this->errors;
            return false;
        }
        if (strlen($pwd)<5){
            array_push($this->errors,'too long password');
            // return $this->errors;
            return false;
        }
        return true;
    }
    //method to insert data in to database
    protected function insertIntoDb($uname,$email,$pwd){
        $query = "INSERT INTO user(username,email,password) VALUES('".$uname."','".$email."','".$pwd."')";
        mysqli_query($this->connection,$query);
        //checks if data is inserted or not
        if(mysqli_affected_rows($this->connection)>0){
            return true;
        }
        else{
            return false;
        }
    }
    protected function checkusername($uname){
        $query = "SELECT username from user where username='".$uname."'";
        mysqli_query($this->connection,$query);
        if(mysqli_affected_rows($this->connection)>0){
            array_push($this->errors,"Username already exist");
            return false;
        }
        else{
            return true;
        }
    }
}

?>