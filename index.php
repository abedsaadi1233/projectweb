<?php
require_once('connection.php');


session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: account2.php");
    exit();
}

$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

$products = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];


    $query = "INSERT INTO sales (user_id, product_id) VALUES ('$user_id', '$product_id')";
    if (mysqli_query($con, $query)) {
        echo "Product purchased successfully!";
    } else {
        echo "Error purchasing product: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - View Products</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .a{
            display: flex;
            margin-bottom: 20px;
            
        }
        .a a{
            margin-left: 750px;
        }

        .container {
            margin-top: 50px;
        }

        .product-list {
            margin-top: 30px;
        }

        .product-item {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #ffffff;
        }

        .product-item h5 {
            margin-bottom: 10px;
        }

        .product-item p {
            margin-bottom: 5px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').keyup(function() {
                let query = $(this).val();
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#productList').html(data);
                    }
                });
            });
        });
    </script>
</head>

<body>
    <section class="vh-100">
        <div class="container">
           <div class="a">
           
           <h2 class="mb-4">Available Products</h2>
           <a href="logout.php" class="btn btn-primary">logout</a>

           </div>
            <input type="text" id="search" class="form-control" placeholder="Search for products by name..." />
            <div id="productList" class="product-list">
                <?php if (count($products) > 0) : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="product-item">
                            <?php if (!empty($product['image_path'])) : ?>
                                <img src="<?php echo $product['image_path']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid mb-2" style="max-height: 200px;">
                            <?php endif; ?>
                            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-primary">Buy</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No products available.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>