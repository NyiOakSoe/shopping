<?php
  session_start();
  require '../../config/config.php';
  require '../../config/common.php';

  include ('header.php');

  if(empty($_SESSION['id'] || empty($_SESSION['name']))){
    header('location:../login.php');
  }

  if(isset($_POST['btn'])){
    if(empty($_POST['name']) || empty($_POST['description'])|| empty($_POST['price']) || empty($_POST['quantity']) || empty($_FILES['img']) || empty($_POST['category']) ||is_numeric($_POST['price'])!=1 ||is_numeric($_POST['quantity'])!=1 ){
      if(empty($_POST['name'])){
        $name_error="! Need to fill Name";
      }
      if(empty($_POST['description'])){
        $description_error="! Need to fill description";
      }
      if(empty($_POST['price'])){
        $price_error="! Need to fill price";
      }elseif(is_numeric($_POST['price'])!=1){
        $price_error="! Should be number";
      }
      if(empty($_POST['quantity'])){
        $quantity_error="! Need to fill quantity";
      }elseif(is_numeric($_POST['quantity'])!=1){
        $quantity_error="! Should be number";
      }
      if(empty($_FILES['img'])){
        $image_error="! Need to fill image";
      }
      if(empty($_POST['category'])){
        $cat_error="! Need to select Category";
      }
    }else{
      $name=$_POST['name'];
      $description=$_POST['description'];
      $price=$_POST['price'];
      $quantity=$_POST['quantity'];
      $category=$_POST['category'];
  
      $img_name=$_FILES['img']['name'];
      $img_tmp=$_FILES['img']['tmp_name'];
      $file='../product_image/'.$img_name;
      $imgtype=pathinfo($file,PATHINFO_EXTENSION);
      if($imgtype!='png' && $imgtype!='jpg' && $imgtype!='jepg'){
          echo "<script>alert('Need image is pnd or jpg or jepg')</script>";
      }else{
          move_uploaded_file($img_tmp,$file);
        $stmt=$pdo->prepare("INSERT INTO product(name,description,price,quantity,image,categories_id)VALUES(:name,:description,:price,:quantity,:image,:categories_id)");
        $result=$stmt->execute(
          array(
              ':name'=>$name,
              ':description'=>$description,
              ':price'=>$price,
              ':quantity'=>$quantity,
              ':image'=>$img_name,
              ':categories_id'=>$category

          )
      );
      if($result){
          echo "<script>alert('Product added');window.location.href='product.php'</script>";
      }
      }
    }
   
    
  }
  
  
      
     
    
    ?>
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4" style="margin:auto">
            <div class="card" >
              <div class="card-header">
                <h3 class="card-title" >Add Product</h3>
                
                
              </div>
              <!-- /.card-header -->
              <div class="card-body" >
                
              <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Name</label><br>
                        <input class="form-control" type="text" name="name" id="">
                        <small style="color:red"><?php echo empty($name_error)?'':$name_error;?></small>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label><br>
                        <textarea name="description" id="" cols="40" rows="5"></textarea>
                        <small style="color:red"><?php echo empty($description_error)?'':$description_error;?></small>
                    </div>
                    <div class="form-group">
                        <label for="">Category</label><br>
                        <select class="form-control" name="category" id="">
                          <option value="">Select Category</option>
                          <?php
                          $catStmt=$pdo->prepare("SELECT * FROM categories");
                          $catStmt->execute();
                          $catResult=$catStmt->fetchAll();
                          foreach($catResult as $value){
                            ?>
                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                          
                            <?php
                          }
                          ?>
                        </select>
                        <small style="color:red"><?php echo empty($cat_error)?'':$cat_error;?></small>

                    </div>
                    <div class="form-group">
                        <label for="">Price</label><br>
                        <input class="form-control" type="number" name="price" id="">
                        <small style="color:red"><?php echo empty($price_error)?'':$price_error;?></small>

                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label><br>
                        <input class="form-control" type="number" name="quantity" id="">
                        <small style="color:red"><?php echo empty($quantity_error)?'':$quantity_error;?></small>

                    </div>
                    <div class="form-group">
                        <label for="">Image</label><br>
                        <input type="file" name="img" id=""><br>
                        <small style="color:red"><?php echo empty($image_error)?'':$image_error;?></small>

                    </div>
                    <div class="form-group">
                        <input type="submit" name="btn" value="Save" class="btn btn-success">
                        <a href="product.php" type="button" class="btn btn-warning">Back</a>
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