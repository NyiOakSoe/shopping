<?php
session_start();
require '../config/config.php';
if(isset($_POST['BTN'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $stmt=$pdo->prepare("SELECT* FROM admin WHERE email=:email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $resutlt=$stmt->fetch(PDO::FETCH_ASSOC);
   
    if($resutlt['password']==$password){
        $_SESSION['id']=$resutlt['id'];
        $_SESSION['name']=$resutlt['name'];
        header('location:index.php');

    }else{
       echo  "<script>alert('Incorrect Email or Password');</script>";
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
  <input type="password" name="password" placeholder="Password">
  <button name="BTN">Login</button>
</form>
<!-- partial -->
  
</body>
</html>
