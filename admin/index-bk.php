<?php
  session_start();
  require '../config/config.php';
  require '../config/common.php';
  if(empty($_SESSION['id'])){
    header('location:login.php');
  };
  
  if(isset($_POST['search'])){
    setcookie('search',$_POST['search'],time()+(3600*24),"/");
    
  }else{
    if(empty($_GET['pageno'])){
      unset($_COOKIE['search']);
      setcookie('search',null,-1,'/');
      
    }
  }

  include ('header.html');

      
        if(!empty($_GET['pageno'])){
          $pageno=$_GET['pageno'];
        }else{
          $pageno=1;
        }
        $numofrecs=2;
        $offset=($pageno -1) * $numofrecs;
  
        if(empty($_POST['search']) && empty($_COOKIE['search'])){
          $stmt=$pdo->prepare("SELECT * FROM posts ");
          $stmt->execute();
          $row_result=$stmt->fetchAll();
          $total_page=ceil(count($row_result) / $numofrecs);
      
          $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numofrecs ");
          $stmt->execute();
          $result=$stmt->fetchAll();
      }else{
        if(isset($_POST['search'])){
          $search=$_POST['search'];
        }else{
          $search=$_COOKIE['search'];
        }
          $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$search%' ");
          $stmt->execute();
          $row_result=$stmt->fetchAll();
          $total_page=ceil(count($row_result) / $numofrecs);
  
          $stmt=$pdo->prepare("SELECT * FROM posts   WHERE title LIKE '%$search%' LIMIT $offset,$numofrecs   ");
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
                <h3 class="card-title">Blog Listings</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add.php" type="button" class="btn btn-success">New Blog</a><br><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">Id</th>
                      <th style="width: 400px">Title</th>
                      <th >Content</th>
                      <th style="width: 160px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($result){
                      $i=1;
                      foreach ($result as $value) {
                        ?>
                    
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo escape($value['title']); ?></td>
                        <td><?php echo substr(escape($value['content']),0,200)."..."; ?>
                        </td>
                        <td>
                          <a href='edit.php?id=<?php echo escape($value['id']); ?>' type='button' class='btn btn-warning'>Edit</a> 
                          <a href='delete.php?id=<?php echo escape($value['id']); ?>' type='button' class='btn btn-danger'>Delete</a> 
  
                        </td>
                      </tr>
                      <?php
                      $i++;
                      }
                    }
                    
                    ?>
                    
                    
                  </tbody>
                </table>
                <br>
                <nav aria-label="Page navigation example">
                  <ul class="pagination" style="float:right">
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                    <a class="page-link" href="?pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                    <a class="page-link" href="?<?php if($pageno<=1){echo "#";}else{echo "pageno=".($pageno-1);} ?>">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="?pageno=<?php echo $pageno;?>"><?php echo $pageno;?></a>
                  </li>
                  <li class="page-item <?php if($pageno>=$total_page){echo 'disabled';} ?>">
                    <a class="page-link" href="?<?php if($pageno>=$total_page){echo "#";}else{echo "pageno=".($pageno+1);} ?>">Next</a>
                  </li>
                  <li class="page-item <?php if($pageno>=$total_page){echo 'disabled';} ?>">
                    <a class="page-link" href="?pageno=<?php echo $total_page?>">Last</a>
                  </li>
                </ul>
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
    include ('footer.html');
  ?>