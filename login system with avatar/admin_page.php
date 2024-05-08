<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}


if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart';
    } else {

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style2.css">

</head>

<body>
    <header>
        <h2 class="logo">MILKY</h2>
        <nav>
            <ul class="nav_list">
                <li><a href="admin_page.php">Home</a></li>
                <li><a href="index.php">clients</a></li>
                <li><a href="statistics.php">Statistics</a></li>

                <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
                ?>

                <li><a href="product.php"><i
                            class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a></li>
                <li><a href="prof.php">profile</a></li>
                <li><a href="logout.php">logout</a></li>


            </ul>
        </nav>
    </header>
    </section>
    <section class="intro">
        <h1>MILKY</h1>
        <p>Indulge in the creamy goodness of MILKY, where each sip embodies a burst of flavor and nourishment. Our milk,
            available in tantalizing flavors like Blueberry, Strawberry, and Banana, offers a delightful twist to your
            daily routine. Experience the refreshing taste of ripe blueberries, the sweet allure of fresh strawberries,
            or the tropical richness of ripe bananas, all expertly blended with creamy milk to create a truly satisfying
            beverage. With MILKY, every sip is a moment of pure pleasure, providing you with the essential nutrients you
            need to fuel your day while satisfying your cravings. Treat yourself to the taste of MILKY and elevate your
            beverage experience today!</p>
    </section>
    <section class="products">

        <h1 class="title">Our products</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                    <form action="" method="POST" class="box">
                        <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                        <img src="milk/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <input type="number" name="product_quantity" value="1" min="0" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
                    <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>





</body>

</html>