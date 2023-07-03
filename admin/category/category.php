<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  include ('header.php');

  if(empty($_SESSION['id'] || empty($_SERVER['name']))){
    header('location:../login.php');
  }
  if(empty($_GET['pageno'])){
    $pageno=1;
  }else{
    $pageno=$_GET['pageno'];
  }
  $rec=1;
  $offect=($pageno -1)* $rec;
  
  if(isset($_POST['searchBTN'])){
   $search=$_POST['search'];
   $stmt=$pdo->prepare("SELECT * FROM categories  WHERE name LIKE '%$search%' ORDER BY id DESC");
    $stmt->execute();
    $row_result=$stmt->fetchAll();
    $totalpageno=ceil(count($row_result)/$rec);
    $stmt=$pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $offect,$rec    ");
    $stmt->execute();
    $result=$stmt->fetchAll();
    
  }else{
      


    $stmt=$pdo->prepare("SELECT * FROM categories  ORDER BY id DESC");
    $stmt->execute();
    $row_result=$stmt->fetchAll();
    $totalpageno=ceil(count($row_result)/$rec);
    $stmt=$pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offect,$rec   ");
    $stmt->execute();
    $result=$stmt->fetchAll();
    
  }
      
     
    
    ?>
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Catogories</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add.php" type="button" class="btn btn-success">New Category</a><br><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th style="width: 400px">Name</th>
                      <th >Description</th>
                      <th style="width: 160px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                    foreach($result as $value){
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['name']?></td>
                        <td><?php echo $value['description']?></td>
                        <td>
                          <a href="edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                          <a href="delete.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                      <?php
                      $i++;
                    }
                    ?>
                    
                    
                  </tbody>
                </table>
                <br>
                <nav aria-label="Page navigation example">
                <ul class="pagination" style="float:right">
                  <li class="page-item ">
                    <a class="page-link" href="?pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';}?>">
                    <a class="page-link" href="?<?php if($pageno<=1){echo '#';}else{echo "pageno=".($pageno-1);}?>">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="<?php echo '#'?>"><?php echo $pageno?></a>
                  </li>
                  <li class="page-item <?php if($pageno>=$totalpageno){echo 'disabled';}?> ">
                    <a class="page-link" href="?<?php if($pageno>=$totalpageno){echo '#';}else{echo "pageno=".($pageno+1);}?>">Next</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="?pageno=<?php echo $totalpageno ?>">Last</a>
                  </li>
                </ul>
              </nav>
              </nav>
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