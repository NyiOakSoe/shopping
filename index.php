<?php 
		
		include('header.php');
		require 'config/config.php';
		require 'config/common.php';

		if(empty($_SESSION['id']) || empty($_SESSION['name'])){
		header('location:login.php');
		}
		if(isset($_POST['searchBtn'])){
			setcookie('search',$_POST['search'],time()+(3600*24),'/');
		  }else{
			if(empty($_GET['pageno'])){
			  unset($_COOKIE['search']);
			  setcookie('search',null,-1,'/');
			}
		  }
		if(!empty($_GET['cat_id'])){
			setcookie('cat_id',$_GET['cat_id'],time()+(3600*24),'/');
		}else{
			if(empty($_GET['pageno'])){
			  unset($_COOKIE['cat_id']);
			  setcookie('cat_id',null,-1,'/');
			}
		}
		if(empty($_GET['pageno'])){
		$pageno=1;
		}else{
		$pageno=$_GET['pageno'];
		}
		$rec=3;
		$offect=($pageno -1)* $rec;
		
		
		

		if(empty($_POST['search']) && empty($_COOKIE['search'])  ){
			if(empty($_GET['cat_id']) && empty($_COOKIE['cat_id']) ){
				$stmt=$pdo->prepare("SELECT * FROM product WHERE  quantity>0  ORDER BY id DESC");
				$stmt->execute();
				$row_result=$stmt->fetchAll();
				$totalpageno=ceil(count($row_result)/$rec);
				$stmt=$pdo->prepare("SELECT * FROM product WHERE quantity>0 ORDER BY id DESC LIMIT $offect,$rec   ");
				$stmt->execute();
				$result=$stmt->fetchAll();
				
				
			}else{
				
				if(empty($_GET['cat_id'])){
					$catId=$_COOKIE['cat_id'];
				   }else{
					$catId=$_GET['cat_id'];
				   }
				
				$stmt=$pdo->prepare("SELECT * FROM product WHERE categories_id=$catId AND quantity>0");
				$stmt->execute();
				$row_result=$stmt->fetchAll();
				$totalpageno=ceil(count($row_result)/$rec);
				$stmt=$pdo->prepare("SELECT * FROM product WHERE categories_id=$catId AND quantity>0 ORDER BY id DESC LIMIT $offect,$rec   ");
				$stmt->execute();
				$result=$stmt->fetchAll();
			}
			
			
		
		}else{
			if(!empty($_POST['search'])){
				$search=$_POST['search'];
			   }else{
				$search=$_COOKIE['search'];
			   }
		$stmt=$pdo->prepare("SELECT * FROM product  WHERE  name LIKE '%$search%' AND quantity>0 ORDER BY id DESC");
		$stmt->execute();
		$row_result=$stmt->fetchAll();
		
		$totalpageno=ceil(count($row_result)/$rec);

		$stmt=$pdo->prepare("SELECT * FROM product WHERE name LIKE '%$search%' AND quantity>0 ORDER BY id DESC LIMIT $offect,$rec    ");
		$stmt->execute();
		$result=$stmt->fetchAll();
			
			}
		
?>


<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<?php
						$catStmt=$pdo->prepare("SELECT * FROM categories");
						$catStmt->execute();
						$catResult=$catStmt->fetchAll();
					?>
					<ul class="main-categories">
						<?php
						foreach($catResult as $key=>$value){
						?>
							<li class="main-nav-list">
							
							<a   href="?cat_id=<?php echo $value['id']?>"><?php echo $value['name']?></a>
										
							</li>
						<?php
						}
						?>

						
					</ul>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				
				<!-- Start Best Seller -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">
					<li class="page-item ">
                    <a class="page-link" href="?pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';}?>">
                    <a class="page-link" href="?<?php if($pageno<=1){echo '#';}else{echo "pageno=".($pageno-1);}?>">
					<i class="fa fa-long-arrow-left " aria-hidden="true"></i>
					</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="<?php echo '#'?>"><?php echo $pageno?></a>
                  </li>
                  <li class="page-item <?php if($pageno>=$totalpageno){echo 'disabled';}?> ">
                    <a class="page-link" href="?<?php if($pageno>=$totalpageno){echo '#';}else{echo "pageno=".($pageno+1);}?>">
					<i class="fa fa-long-arrow-right <?php if($pageno>=$totalpageno){echo 'disabled';}?>" aria-hidden="true"></i>
					</a>
                  </li>
                  <li class="page-item ">
                    <a class="page-link" href="?pageno=<?php echo $totalpageno ?>">Last</a>
                  </li>
					</div>
				</div>
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						
							<?php
							if($result){
								
								foreach($result as $key=>$value){
							?>
							
							<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<a href="product_detail.php?id=<?php echo $value['id'];?>"><img class="img-fluid" src="admin/product_image/<?php echo $value['image'];?>" alt="" style="height: 200;"></a>
								<div class="product-details">
									<h6><?php echo $value['name'];?></h6>
									<div class="price">
										<h6><?php echo $value['price'];?></h6>
									</div>
									<div class="prd-bottom">
										<form action="addtocart.php" method="post">
										<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
										<input type="hidden" name="qty" value="1">
										<div  class="social-info" >
											<button name="addtocart"style="display: contents;" >
											<span class="lnr lnr-move" ></span>
											<p class="hover-text" style="left: 20px;">add to bag</p>
											</button>
										</div>
										
										<a href="product_detail.php?id=<?php echo $value['id'];?>" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view more</p>
										</a>
										</form>
										
									</div>
								</div>
							</div>
						</div>
							<?php
							}
						}
							?>
						
						<!-- single product -->
						
						<!-- single product -->
						
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
