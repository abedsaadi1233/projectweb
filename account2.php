<?php

session_start();
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM signup WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($con, $query);
    

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $hashed_password = $user_data['password'];
            if ($hashed_password === $password) { // Adjust this line if you use password hashing
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['role_id'] = $user_data['role_id'];

                if ($user_data['user_id'] == 1) {
                    header("Location: admin.php");
                } else {
                    header("Location: index.php");
                }
                exit();
              
               
                
            } else {
                $error_msg = "Incorrect password!";
            }
        } else {
            $error_msg = "User not found!";
        }
    } else {
        $error_msg = "Please enter both username and password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/css2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="images/fishlogo.jpeg" alt="Database Image" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post">
                    <div class="form-outline mb-4">
                        <input name="username" type="text" id="form3Example3" class="form-control form-control-lg" placeholder="Enter username" />
                        <label class="form-label" for="form3Example3">Username</label>
                    </div>
                    <div class="form-outline mb-3">
                        <input name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_msg; ?>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">Remember me</label>
                        </div>
                        <a href="#!" class="text-body">Forgot password?</a>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <input type="submit" value="Login" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" />
                    </div>
                </form>
                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="http://localhost/ahmad/signup2.php" class="link-danger">Register</a></p>
            </div>
        </div>
    </div>
</section>
</body>
</html>
