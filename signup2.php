<?php 
    include("connection.php");

    $query = ''; 

    if($_SERVER['REQUEST_METHOD'] == "POST") {
      
        $username = $_POST['fullname'];
        $user_mobile = $_POST['user_mobile'];
        $user_email = $_POST['user_email'];
        $user_address = $_POST['user_address'];
        $password = $_POST['password'];
        $rpass = $_POST['rpass'];

        if(!empty($username) && !empty($user_mobile) && !empty($user_email) && !empty($user_address) && !empty($password) && !empty($rpass) && $password == $rpass) {
           
            $username = mysqli_real_escape_string($con, $username);
            $user_mobile = mysqli_real_escape_string($con, $user_mobile);
            $user_email = mysqli_real_escape_string($con, $user_email);
            $user_address = mysqli_real_escape_string($con, $user_address);
            $password = mysqli_real_escape_string($con, $password);

           
            $query = "INSERT INTO signup (username, user_mobile, user_email, user_address, password,rpass) VALUES ('$username', '$user_mobile', '$user_email', '$user_address','$password','$rpass' )";

           
            $result = mysqli_query($con, $query);

            
            if ($result) {
                header("Location: account2.php");
                die;
            } else {
                echo '<span style="color: red;">Error: Unable to insert data into the database.</span>';
            }
        } else {
            echo '<span style="color: red;">Please enter valid information!</span>';
        }
    }
?>

<html>

<head>
    <link href="css/css2.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-6">
                    <img src="images/fishlogo.jpeg"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-6">
                    <form action="" method="POST">
                        
                        <div class="form-outline mb-4">
                            <input name="user_email" type="text" id="form3Example3"
                                class="form-control form-control-lg" placeholder="Enter a valid email address" />
                            <label class="form-label" for="form3Example3">user_email</label>
                        </div>

                        
                        <div class="form-outline mb-3">
                            <input name="password" type="password" id="form3Example4"
                                class="form-control form-control-lg" placeholder="Enter password" />
                            <label class="form-label" for="form3Example4">Password</label>
                        </div>
						 <div class="form-outline mb-3">
                            <input name="rpass" type="password" id="form3Example9"
                                class="form-control form-control-lg" placeholder="Enter password" />
                            <label class="form-label" for="form3Example4">repeat the password</label>
                        </div>

                        
                        <div class="form-outline mb-3">
                            <input name="fullname" type="text" id="form3Example5"
                                class="form-control form-control-lg" placeholder="Enter your full name" />
                            <label class="form-label" for="form3Example5">Full Name</label>
                        </div>

                        <div class="form-outline mb-3">
                            <input name="age" type="number" id="form3Example6"
                                class="form-control form-control-lg" placeholder="Enter your age" />
                            <label class="form-label" for="form3Example6">Age</label>
                        </div>

                        
                        <div class="form-outline mb-3">
                            <input name="user_address" type="text" id="form3Example7"
                                class="form-control form-control-lg" placeholder="Enter your address" />
                            <label class="form-label" for="form3Example7">Address</label>
                        </div>

                        <div class="form-outline mb-3">
                            <input name="user_mobile" type="text" id="form3Example8"
                                class="form-control form-control-lg" placeholder="Enter your phone number" />
                            <label class="form-label" for="form3Example8">Phone Number</label>
                        </div>

                       
                        <div class="form-check mb-3">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">
                                I agree to the Terms and Conditions
                            </label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <input type="submit" value="Sign Up" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;" />
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <a href="#!" class="text-white me-4">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-google"></i>
            </a>
            <a href="#!" class="text-white">

                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </section>


</body>

</html>






























