<?php
    session_start();
    require 'config/config.php';
    if(isset($_POST['addtocart'])){
        $id=$_POST['id'];
        $qty=$_POST['qty'];
        $stmt=$pdo->prepare("SELECT * FROM product WHERE id=$id");
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        if($qty>$result['quantity']){
            echo "<script>alert('No enought stock');window.location.href='product_detail.php?id=$id'</script>";
        }else{
            if(isset($_SESSION['cart']['id'.$id])){
                $_SESSION['cart']['id'.$id]+=$qty;
            }else{
                $_SESSION['cart']['id'.$id]=$qty;
            }
            header('location:cart.php');
        }
        
    }
    
?>