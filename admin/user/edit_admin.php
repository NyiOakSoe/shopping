<?php

use LDAP\Result;

  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  include ('header.php');

  if(empty($_SESSION['id'] || empty($_SERVER['name']))){
    header('location:../login.php');
  }
  $id=$_GET['id'];
  $stmt=$pdo->prepare("SELECT * FROM admin WHERE id=$id");
  $stmt->execute();
  $result=$stmt->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['btn'])){
    if(empty($_POST['name']) || empty($_POST['email'])|| empty($_POST['phone']) || empty($_POST['address'])){
      if(empty($_POST['name'])){
        $name_error="! Need to fill Name";
      }
      if(empty($_POST['email'])){
        $email_error="! Need to fill Email";
      }
      if(empty($_POST['phone'])){
        $phone_error="1 Need to fill Phone";
      }
      if(empty($_POST['address'])){
        $address_error="1 Need to fill Address";
      }
      
    }elseif(strlen($_POST['password'])<=4 && !empty($_POST['password'])){
      if(strlen($_POST['password'])<=4){
        $need_password_error="! Need your password is greater than 4";
      }
    }else{
      
      
      
      $name=$_POST['name'];
      $email=$_POST['email'];
      $phone=$_POST['phone'];
      $address=$_POST['address'];
      $password=$_POST['password'];
      
      $stmt=$pdo->prepare("SELECT * FROM admin WHERE email=:email AND id!=:id");
      $stmt->execute(
        array(
          ':email'=>$email,
          ':id'=>$id
        )
        );
      $admin_result=$stmt->fetch(PDO::FETCH_ASSOC);
      //var_dump($admin_result);
      
      if(!$admin_result){
        if(empty($password)){
          $stmt=$pdo->prepare("UPDATE admin SET name='$name',email='$email',phone='$phone',address='$address' WHERE id=$id ");
       
        }else{
        $stmt=$pdo->prepare("UPDATE admin SET name='$name',email='$email',phone='$phone',address='$address',password='$password' WHERE id=$id ");
        }
      $result=$stmt->execute();
      if($result){
         echo "<script>alert('Admin Updated');window.location.href='user.php'</script>";
        }
      }else{
        echo "<script>alert('Your Email is Already');</script>";
        
      }
      
          
      
    }
    
  }
  
  
      
     
    
    ?>
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6" style="margin:auto">
            <div class="card" >
              <div class="card-header">
                <h3 class="card-title" >New Admin</h3>
                
                
              </div>
              <!-- /.card-header -->
              <div class="card-body"  >
                
              <form action="" method="post">
                  
                    <div class="form-group">
                        <label for="">Name</label><br>
                        <input class="form-control" type="text" name="name" id="" value="<?php echo $result['name']?>">
                        <small style="color:red"><?php echo empty($name_error)?'':$name_error;?></small>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label><br>
                        <input class="form-control" type="email" name="email" id="" value="<?php echo $result['email']?>">
                        <small style="color:red"><?php echo empty($email_error)?'':$email_error;?></small>

                    </div>
                    <div class="form-group">
                        <label for="">Phone</label><br>
                        <input class="form-control" type="text" name="phone" id="" value="<?php echo $result['phone']?>">
                        <small style="color:red"><?php echo empty($phone_error)?'':$phone_error;?></small>

                    </div>
                    <div class="form-group">
                        <label for="">Address</label><br>
                        <input class="form-control" type="text" name="address" id="" value="<?php echo $result['address']?>">
                        <small style="color:red"><?php echo empty($address_error)?'':$address_error;?></small>

                    </div>
                    <div class="form-group">
                        <label for="">Password</label><br>
                        <input class="form-control" type="password" name="password" id="">
                        <small style="color:red"><?php echo empty($need_password_error)?'':$need_password_error;?></small>
                        

                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="btn" value="Update" class="btn btn-success">
                        <a href="user.php" type="button" class="btn btn-warning">Back</a>
                    </div>
                   
                </form>
                
              </div>
              
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php
    include ('footer.php');
  ?>