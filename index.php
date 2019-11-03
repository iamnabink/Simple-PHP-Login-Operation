<?php
include 'login.php';
?>
<form method='POST' action="">
    <span>username: <span><input type="text" name="username"><br>
    <span>email: <span><input type="text" name="email"><br>
    <span>password: <span><input type="password" name="password"><br>
    <input type="submit" name="send">
</form>
<?php 
if(isset($_POST['send'])){
    $object=new Login();
    $object->insertIntoTb($_POST['username'],$_POST['email'],$_POST['password']);
    foreach($object->errors as $error){
        echo $error;
    }
}
?>