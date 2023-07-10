<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  if(empty($_SESSION['id']) || empty($_SESSION['name'])){
    header('location:../login.php');
  }
  if(isset($_POST['searchBTN'])){
    setcookie('search',$_POST['search'],time()+(3600*24),'/');
  }else{
    if(empty($_GET['admin_pageno']) && empty($_GET['cos_pageno']) ){
      unset($_COOKIE['search']);
      setcookie('search',null,-1,'/');
    }
  }
  
  //admin pagination//
  if(empty($_GET['admin_pageno'])){
    $admin_pageno=1;
  }else{
    $admin_pageno=$_GET['admin_pageno'];
  }
  $rec_admin=1;
  $offset_admin=($admin_pageno-1)*$rec_admin;
  //admin paginatiion
  //costumer pagination
  if(empty($_GET['cos_pageno'])){
    $cos_pageno=1;
  }else{
    $cos_pageno=$_GET['cos_pageno'];
  }
  $rec_cos=1;
  $offset_cos=($cos_pageno-1)*$rec_cos;
  //costumer pagination
if(empty($_POST['search']) && empty($_COOKIE['search'])){
  //admin
  $admin_stmt=$pdo->prepare("SELECT * FROM admin ORDER BY id DESC");
  $admin_stmt->execute();
  $row_admin_result=$admin_stmt->fetchAll();
  $totalpage_admin=ceil(count($row_admin_result)/$rec_admin);
  $admin_stmt=$pdo->prepare("SELECT * FROM admin ORDER BY id DESC LIMIT $offset_admin,$rec_admin  ");
  $admin_stmt->execute();
  $admin_result=$admin_stmt->fetchAll();
  //admin
  //costumer
  $cos_stmt=$pdo->prepare("SELECT * FROM costumer ORDER BY id DESC");
  $cos_stmt->execute();
  $row_cos_result=$cos_stmt->fetchAll();
  $totalpage_cos=ceil(count($row_cos_result)/$rec_cos);
  $cos_stmt=$pdo->prepare("SELECT * FROM costumer ORDER BY id DESC LIMIT $offset_cos,$rec_cos  ");
  $cos_stmt->execute();
  $cos_result=$cos_stmt->fetchAll();
  //costumer
}else{
  
  if(isset($_POST['searchBTN'])){
    $search=$_POST['search'];
   }else{
    $search=$_COOKIE['search'];
   }
  $admin_stmt=$pdo->prepare("SELECT * FROM admin WHERE name LIKE '%$search%' ") ;
  $admin_stmt->execute();
  $row_admin_result=$admin_stmt->fetchAll();
  $totalpage_admin=ceil(count($row_admin_result)/$rec_admin);
  $admin_stmt=$pdo->prepare("SELECT * FROM admin WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $offset_admin,$rec_admin  ");
  $admin_stmt->execute();
  $admin_result=$admin_stmt->fetchAll();

  $cos_stmt=$pdo->prepare("SELECT * FROM costumer WHERE name LIKE '%$search%' ORDER BY id DESC") ;
  $cos_stmt->execute();
  $row_cos_result=$cos_stmt->fetchAll();
  $totalpage_cos=ceil(count($row_cos_result)/$rec_cos);
  $cos_stmt=$pdo->prepare("SELECT * FROM costumer WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $offset_cos,$rec_cos ");
  $cos_stmt->execute();
  $cos_result=$cos_stmt->fetchAll();
}


  
  
      
  include ('header.php');
    
    ?>
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        
            
            <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admins</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add_admin.php" type="button" class="btn btn-success">New admin</a><br><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                    <th style="width: 10px">No</th>
                      <th style="width: 250px">Name</th>
                      <th >Email</th>
                      <th style="width: 160px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
                   $i=1;
                   foreach($admin_result as $value){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['name']?></td>
                        <td><?php echo $value['email']?></td>
                        <td>
                            <a href="edit_admin.php?id=<?php echo $value['id']?>" class="btn btn-warning btn-sm" type="button">Edit</a>
                            <a href="delete_admin.php?id=<?php echo $value['id']?>" class="btn btn-danger btn-sm" type="button">DELETE</a>
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
                    <a class="page-link" href="?admin_pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($admin_pageno<=1){echo 'disabled';} ?> ">
                    <a class="page-link " href="?<?php if($admin_pageno<=1){echo '#';}else{echo "admin_pageno=".($admin_pageno-1);}?>">Previous</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="#"><?php echo $admin_pageno;?></a>
                  </li>
                  <li class="page-item  <?php if($totalpage_admin<=$admin_pageno){echo 'disabled';}?> ">
                    <a class="page-link" href="?<?php if($totalpage_admin<=$admin_pageno){echo '#';}else{echo "admin_pageno=".($admin_pageno+1);}?>">Next</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="?admin_pageno=<?php echo $totalpage_admin;?>">Last</a>
                  </li>
                  
                </ul>
              
              </nav>
              </div>
              
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>

            
          <!-- /.col-md-6 -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Costumers</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add_costumer.php" type="button" class="btn btn-success">New Costumer</a><br><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th style="width: 250px">Name</th>
                      <th >Email</th>
                      <th style="width: 160px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   $i=1;
                   foreach($cos_result as $value){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['name']?></td>
                        <td><?php echo $value['email']?></td>
                        <td>
                            <a href="edit_costumer.php?id=<?php echo $value['id']?>" class="btn btn-warning btn-sm" type="button">Edit</a>
                            <a href="delete_cos.php?id=<?php echo $value['id']?>" class="btn btn-danger btn-sm" type="button">DELETE</a>
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
                    <a class="page-link" href="?cos_pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($cos_pageno<=1){echo 'disabled';} ?> ">
                    <a class="page-link " href="?<?php if($cos_pageno<=1){echo '#';}else{echo "cos_pageno=".($cos_pageno-1);}?>">Previous</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="#"><?php echo $cos_pageno;?></a>
                  </li>
                  <li class="page-item  <?php if($totalpage_cos<=$cos_pageno){echo 'disabled';}?> ">
                    <a class="page-link" href="?<?php if($totalpage_cos<=$cos_pageno){echo '#';}else{echo "cos_pageno=".($cos_pageno+1);}?>">Next</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="?cos_pageno=<?php echo $totalpage_cos;?>">Last</a>
                  </li>
                  
                </ul>
              
              </nav>
              </div>
              
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          
          
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