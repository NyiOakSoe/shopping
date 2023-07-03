<?php
  

  include ('header.html');

      
     
    
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
                    
                    
                    
                  </tbody>
                </table>
                <br>
                <nav aria-label="Page navigation example">
                  
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