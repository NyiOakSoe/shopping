<?php 
    include('header.php');
    require 'config/config.php';
    require 'config/common.php';
?>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php
                    if(!empty($_SESSION['cart'])){
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total=0;
                            foreach($_SESSION['cart'] as $key=>$qty){
                                $id=str_replace('id','',$key);
                                $stmt=$pdo->prepare("SELECT * FROM product WHERE id=$id");
                                $stmt->execute();
                                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                                $total+=$result['price']*$qty;
                            ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/product_image/<?php echo $result['image'];?>" width="130" height="100" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo $result['name'];?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo $result['price'];?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text"  value="<?php echo $qty;?>" title="Quantity:"
                                            class="input-text qty">
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo $result['price']*$qty." MMK";?></h5>
                                </td>
                                <td>
                                    <a type="button" class="btn btn-outline-danger" href="cart_item_delete.php?id=<?php echo $result['id'];?>">DELETE</a>
                                </td>
                            </tr>
                            
                            <tr class="bottom_button">
                                
                            </tr>
                            
                            <?php
                            }
                            ?>
                            <tr>
                                <td>

                                </td>
                                
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo $total." MMK";?></h5>
                                </td>
                            </tr>
                           
                            <tr class="out_button_area">
                                <td>

                                </td>
                                
                                <td>

                                </td>
                                <td>

                                </td>
                                
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="clearall.php">Clear All</a>
                                        <a class="primary-btn" href="index.php">Continue Shopping</a>
                                        <a class="gray_btn" href="sale_order.php">Proceed to checkout</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    }else{
                        header('location:index.php');
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
   <?php include('footer.php');?>
