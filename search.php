<?php
session_start();
require_once('connection.php');

if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($con, $_POST['query']);
    $query = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $result = mysqli_query($con, $query);

    $output = '';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '
            <div class="product-item">
                '.(!empty($row['image_path']) ? '<img src="'.$row['image_path'].'" alt="'.htmlspecialchars($row['name']).'" class="img-fluid mb-2" style="max-height: 200px;">' : '').'
                <h5>'.htmlspecialchars($row['name']).'</h5>
                <p>'.htmlspecialchars($row['description']).'</p>
                <p><strong>Price:</strong> $'.htmlspecialchars($row['price']).'</p>
                <form method="post" action="">
                    <input type="hidden" name="product_id" value="'.$row['id'].'">
                    <button type="submit" class="btn btn-primary">Buy</button>
                </form>
            </div>
            ';
        }
    } else {
        $output .= '<p>No products found</p>';
    }
    echo $output;
}
?>
