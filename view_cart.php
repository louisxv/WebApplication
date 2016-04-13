<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shopping Cart</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1 align="center">shopping basket </h1>

<?php
session_start();
require 'connect.php';
require 'cart_update.php';
if(isset($_GET['id'])){
	$result = mysqli_query($con, 'SELECT * FROM products where id='.$_GET['id']);
	$products = mysqli_fetch_object($result);
	$cart_update = new Item();
	$cart_update->id = $products->id;
	$cart_update->product_name = $products->product_name;
	$cart_update->price = $products->price;
	$cart_update->quantity = 1;
	// Check product is existing in cart_view
	$index = -1;
	$view_cart = unserialize(serialize($_SESSION['view_cart']));
	for($i=0; $i<count($view_cart); $i++)
		if($view_cart[$i]->id==$_GET['id'])
			{
				$index = $i;
				break;
			}
		if($index==-1)
			$_SESSION['view_cart'][] = $cart_update;
		else{
			$view_cart[$index]->quantity++;
			$_SESSION['view_cart'] = $view_cart;
		}
}
//DElete product in the cart
if(isset($_GET['index'])){
	$view_cart = unserialize(serialize($_SESSION['view_cart']));
	unset($view_cart[$_GET['index']]);
	$view_cart = array_values($view_cart);
	$_SESSION['view_cart'] = $view_cart;
}
?>
<table cellpadding="2" cellspacing="2" border="1">
    <tr>
   	  <th>Option</th>
      <th>Id</th>
      <th>Name</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Sub Total</th>
    </tr>
      <?php
	  $view_cart = unserialize(serialize($_SESSION['view_cart']));
	  $s = 0;
	  $index = 0;
	  for($i=0; $i<count($view_cart); $i++) {
		  $s += $view_cart[$i]->price * $view_cart[$i]->quantity;
	  ?>
    <tr>
      <td><a href="view_cart.php?index=<?php echo $index; ?>" onClick="return confirm('Are you sure ?')">Delete</a></td>
      <td><?php echo $view_cart[$i]->id; ?></td>
      <td><?php echo $view_cart[$i]->product_name; ?></td>
      <td><?php echo $view_cart[$i]->price; ?></td>
      <td><?php echo $view_cart[$i]->quantity; ?></td>
      <td><?php echo $view_cart[$i]->price * $view_cart[$i]->quantity; ?></td>
     
    </tr>
      <?php
	  		$index++;
	  	   }
	  ?>
      <tr>
      	<td colspan="5" align="right">Sum</td>
        <td align="left"><?php echo $s; ?></td>
      </tr>
</table>
<br>
<a href="index.php">Continue shopping</a>

</body>
</html>
