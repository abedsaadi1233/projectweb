<?php
session_start();
require_once('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: index.php");
    exit();
}


if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $query = "DELETE FROM products WHERE id = '$delete_id'";
    if (mysqli_query($con, $query)) {
        $success_msg = "Product deleted successfully!";
    } else {
        $error_msg = "Error deleting product!";
    }
}


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $product_id = isset($_POST['product_id']) ? mysqli_real_escape_string($con, $_POST['product_id']) : null;
    $image_path = '';

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $upload_dir = 'images/';
        $image_path = $upload_dir . basename($_FILES['product_image']['name']);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);
    }

    if (!empty($name) && !empty($price)) {
        if ($product_id) {
            
            if (!empty($image_path)) {
                $query = "UPDATE products SET name='$name', description='$description', price='$price', image_path='$image_path' WHERE id='$product_id'";
            } else {
                $query = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id='$product_id'";
            }
            if (mysqli_query($con, $query)) {
                $success_msg = "Product updated successfully!";
            } else {
                $error_msg = "Error updating product!";
            }
        } else {
            
            $query = "INSERT INTO products (name, description, price, image_path) VALUES ('$name', '$description', '$price', '$image_path')";
            if (mysqli_query($con, $query)) {
                $success_msg = "Product added successfully!";
            } else {
                $error_msg = "Error adding product!";
            }
        }
    } else {
        $error_msg = "Please fill in all required fields!";
    }
}

$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

$products = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-lg {
            padding-left: 2.5rem;
            padding-right: 2.5rem;
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
        .product-actions {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<section class="vh-100">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <h2 class="mb-4">Manage Products</h2>
                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_msg; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_msg; ?>
                    </div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data" class="mb-4">
                    <input type="hidden" name="product_id" id="product_id" value="" />
                    <div class="form-outline">
                        <input name="name" type="text" id="productName" class="form-control form-control-lg" placeholder="Enter product name" />
                        <label class="form-label" for="productName">Product Name</label>
                    </div>
                    <div class="form-outline">
                        <textarea name="description" id="productDescription" class="form-control form-control-lg" placeholder="Enter product description"></textarea>
                        <label class="form-label" for="productDescription">Product Description</label>
                    </div>
                    <div class="form-outline">
                        <input name="price" type="text" id="productPrice" class="form-control form-control-lg" placeholder="Enter product price" />
                        <label class="form-label" for="productPrice">Product Price</label>
                    </div>
                    <div class="form-outline">
                        <input name="product_image" type="file" id="productImage" class="form-control form-control-lg" />
                        <label class="form-label" for="productImage">Product Image</label>
                    </div>
                    <div class="text-center mt-4 pt-2">
                        <input type="submit" value="Save Product" class="btn btn-primary btn-lg" />
                    </div>
                </form>
                <h3 class="product-list-title">Product List</h3>
                <?php if (count($products) > 0): ?>
                    <div class="product-list">
                        <?php foreach ($products as $product): ?>
                            <div class="product-item">
                                <?php if (!empty($product['image_path'])): ?>
                                    <img src="<?php echo $product['image_path']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid mb-2" style="max-height: 200px;">
                                <?php endif; ?>
                                <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                                <div class="product-actions">
                                    <a href="admin.php?delete_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    <button class="btn btn-secondary btn-sm" onclick="editProduct(<?php echo htmlspecialchars(json_encode($product)); ?>)">Edit</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No products available.</p>
                <?php endif; ?>
                <p class="small fw-bold mt-2 pt-1 mb-0"><a href="login.php" class="link-danger">Go to User Page</a></p>
            </div>
        </div>
    </div>
</section>
<script>
function editProduct(product) {
    document.getElementById('product_id').value = product.id;
    document.getElementById('productName').value = product.name;
    document.getElementById('productDescription').value = product.description;
    document.getElementById('productPrice').value = product.price;
    document.getElementById('productImage').value = '';
}
</script>
</body>
</html>
