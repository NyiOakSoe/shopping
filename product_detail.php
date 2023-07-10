<?php 
  include('header.php');
 
		require 'config/config.php';
		require 'config/common.php';

		if(empty($_SESSION['id']) || empty($_SESSION['name'])){
		header('location:login.php');
		}
   
    $id=$_GET['id'];
    $stmt=$pdo->prepare("SELECT * FROM product WHERE id=$id");
    $stmt->execute();
    $result=$stmt->fetchAll();
      
    $catStmt=$pdo->prepare("SELECT * FROM categories WHERE id=".$result[0]['categories_id']);
    $catStmt->execute();
    $catResult=$catStmt->fetchAll();
    
 ?>
<!--================Single Product Area =================-->
<div class="" >
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">       
            <img class="img-fluid" src="admin/product_image/<?php echo $result[0]['image'];?>" alt="">
      </div>
      
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo $result[0]['name'];?></h3>
          <h2><?php echo $result[0]['price'];?> MMK</h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?php echo $catResult[0]['name'];?></a></li>
            <li><a href="#"><span>Availibility</span> : In Stock(<?php echo $result[0]['quantity'];?>)</a></li>
          </ul>
          <p><?php echo $result[0]['description'];?></p>
          <form action="addtocart.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="product_count">
              <label for="qty">Quantity:</label>
              <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
              class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
              class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
            </div>
            <div class="card_area d-flex align-items-center">
              <input type="submit" class="primary-btn" name="addtocart" value="ADD TO CART">
            </div>
          </form>
          <br>
          <div class="card_area d-flex align-items-center">
            <a class="btn btn-outline-primary " href="index.php" style="width: 165px;" >Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
