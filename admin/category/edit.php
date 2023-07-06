<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  include ('header.php');

  if(empty($_SESSION['id'] || empty($_SERVER['name']))){
    header('location:../login.php');
  }

  $id=$_GET['id'];
  $stmt=$pdo->prepare("SELECT * FROM categories WHERE id=$id");
  $stmt->execute();
  $result=$stmt->fetchAll();

  if(isset($_POST['btn'])){
    $name=$_POST['name'];
    $description=$_POST['description'];
    $stmt=$pdo->prepare("UPDATE categories SET name='$name',description='$description' WHERE id=$id");
    $result=$stmt->execute();
    if($result){
        echo "<script>alert('Successfully Updated');window.location.href='category.php';</script>";
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
                <h3 class="card-title" >Add Catogories</h3>
                
                
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="margin:auto" >
                
              <form action="" method="post">
                <input type="hidden" name="token" value="<?php echo $_SESSION['_token']?>">
                    <div class="form-group">
                        <label for="">Name</label><br>
                        <input class="form-control" type="text" name="name" id="" value="<?php echo $result[0]['name']?>">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label><br>
                        <textarea name="description" id="" cols="40" rows="10"><?php echo $result[0]['description']?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btn" value="Update" class="btn btn-success">
                        <a href="category.php" type="button" class="btn btn-warning">Back</a>
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