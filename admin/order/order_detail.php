<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  if(empty($_SESSION['id']) || empty($_SESSION['name'])){
    header('location:../login.php');
  }
  if(!empty($_GET['pageno'])){
    $pageno=$_GET['pageno'];
  }else{
    $pageno=1;
  }
  $rec=1;
  $offect=($pageno -1)* $rec;
  
    $id=$_GET['id'];
    $stmt=$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=$id");
    $stmt->execute();
    $row_result=$stmt->fetchAll();
    $totalpageno=ceil(count($row_result)/$rec);
    $stmt=$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=$id LIMIT $offect,$rec   ");
    $stmt->execute();
    $result=$stmt->fetchAll();
    
  
      
  include ('header.php');
    
    ?>
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Detail</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th style="width: 400px">Product</th>
                      <th >Quantity</th>
                      <th >Order Date</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                    foreach($result as $value){
                        $pStmt=$pdo->prepare("SELECT * FROM product WHERE id=".$value['product_id']);
                        $pStmt->execute();
                        $pResult=$pStmt->fetchAll();
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $pResult[0]['name']?></td>
                        <td><?php echo $value['quantity']?></td>
                        <td><?php echo date('d-m-Y',strtotime($value['order_date']))?></td>
                       
                      </tr>
                      <?php
                      $i++;
                    }
                    ?>
                    
                    
                  </tbody>
                </table>
                <br>
                <a href="order.php" class="btn btn-warning" type="button">Back</a>
                <nav aria-label="Page navigation example">
                <ul class="pagination" style="float:right">
                  <li class="page-item ">
                    <a class="page-link" href="?id=<?php echo $id?>&pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';}?>">
                    <a class="page-link" href="?id=<?php echo $id?>&<?php if($pageno<=1){echo '#';}else{echo "pageno=".($pageno-1);}?>">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="<?php echo '#'?>"><?php echo $pageno?></a>
                  </li>
                  <li class="page-item <?php if($pageno>=$totalpageno){echo 'disabled';}?> ">
                    <a class="page-link" href="?id=<?php echo $id?>&<?php if($pageno>=$totalpageno){echo '#';}else{echo "pageno=".($pageno+1);}?>">Next</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="?id=<?php echo $id?>&pageno=<?php echo $totalpageno ?>">Last</a>
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
    include ('footer.php');
  ?>