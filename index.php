<?php
// start session
session_start();

// connect to database
require 'connect.php';
$result = mysqli_query($con, 'SELECT * FROM products');

// set page title
$page_title = "Product";

// include page header html
include 'header.php';
?>
     <table class="items">
     <tr>
        <th></th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Buy</th>
    </tr>
    <?php while($products = mysqli_fetch_object($result)) { ?>
    <tr>
    	<td><img src="<?php echo $products->product_img_name; ?>"></td>
        <td><?php echo $products->product_name; ?></th>
        <td><?php echo $products->product_desc; ?></th>
        <td><?php echo $products->price; ?></th>
        <td><a href="view_cart.php?id=<?php echo $products->id;?>">
        <button class="add_to_cart" type="button" >Buy Now</button></a></td>
    </tr>
    
    <?php } ?>
</table>

<?php
require 'footer.php';
?>


