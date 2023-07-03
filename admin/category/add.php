<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  include ('header.php');

  if(empty($_SESSION['id'] || empty($_SERVER['name']))){
    header('location:../login.php');
  }

  if(isset($_POST['btn'])){
    $name=$_POST['name'];
    $description=$_POST['description'];
    $stmt=$pdo->prepare("INSERT INTO categories(name,description)VALUES(:name,:description)");
    $result=$stmt->execute(
        array(
            ':name'=>$name,
            ':description'=>$description
        )
    );
    if($result){
        echo "<script>alert('Category added');window.location.href='category.php'</script>";
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
                    <div class="form-group">
                        <label for="">Name</label><br>
                        <input class="form-control" type="text" name="name" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" cols="40" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btn" value="Save" class="btn btn-success">
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