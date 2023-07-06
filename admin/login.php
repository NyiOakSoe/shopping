<?php
session_start();
require '../config/config.php';

if(isset($_POST['BTN'])){
  if(empty($_POST['email']) || empty($_POST['password'])){
    if(empty($_POST['email'])){
      $email_error="! Need to fill Email";
    }
    if(empty($_POST['password'])){
      $password_error="! Need to fill Password";
    }
  }else{
    $email=$_POST['email'];
    $password=$_POST['password'];
    $stmt=$pdo->prepare("SELECT* FROM admin WHERE email=:email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $resutlt=$stmt->fetch(PDO::FETCH_ASSOC);
   
    if(password_verify($password,$resutlt['password'])){
        $_SESSION['id']=$resutlt['id'];
        $_SESSION['name']=$resutlt['name'];
        header('location:index.php');

    }else{
       echo  "<script>alert('Incorrect Email or Password');</script>";
    }
  }
    
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Admin - login form</title>
  <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet"><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<form class="login" method="post">
    <h3>Admin login</h3>
  <input name="email" type="text" placeholder="Email">
  <small style="color:red"><?php echo empty($email_error)?'':$email_error;?></small>
  <input type="password" name="password" placeholder="Password">
  <small style="color:red"><?php echo empty($password_error)?'':$password_error;?></small><br>
  <button name="BTN">Login</button>
</form>
<!-- partial -->
  
</body>
</html>
