
<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  if(empty($_SESSION['id']) || empty($_SESSION['name'])){
    header('location:../login.php');
  }
  $best_seller=10;
  $stmt=$pdo->prepare("SELECT * FROM sale_order_detail WHERE strlen(quantity)>=:best_seller ORDER BY id DESC");
  $stmt->execute(
    array(
        ':best_seller'=>strlen($best_seller)
    )
    );
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
                <h3 class="card-title">Royal Costumer</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th style="width: 400px">User</th>
                      <th >Total Price</th>
                      <th >Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $i=1;
                    foreach($result as $value){
                        $userStmt=$pdo->prepare("SELECT * FROM costumer WHERE id=".$value['costumer_id']);
                        $userStmt->execute();
                        $userResult=$userStmt->fetchAll();
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $userResult[0]['name']?></td>
                        <td><?php echo $value['total_price'];?></td>
                        <td><?php echo date('Y-m-d',strtotime($value['order_date']));?></td>
                      </tr>
                      <?php
                      $i++;
                    }
                    ?>
                    
                    
                  </tbody>
                </table>
                
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
  <script>
    new DataTable('#d-table');
  </script>
