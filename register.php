<?php

$first_name = $last_name = $username = $password = $confirm_password = '';
$first_name_err = $last_name_err = $username_err = $password_err = $confirm_password_err = '';

$validate_failed = false;

if(!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ){
    header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    require_once 'db-connect.php';

    //first name validation
    if(empty(trim($_POST['first_name']))){
        $first_name_err = "Please enter first name";
        $validate_failed = true;
    }else{
        $first_name = trim($_POST['first_name']);
    }

    //last name validation
    if(empty(trim($_POST['last_name']))){
        $last_name_err = "Please enter last name";
        $validate_failed = true;
    }else{
        $last_name = trim($_POST['last_name']);
    }

    //username validation
    if (empty(trim($_POST['username']))) {
        $username_err = "Please enter username";
        $validate_failed = true;
    } else {
    // Get the entered username
    $username = trim($_POST['username']);

    // Check if username exists in database
    $sql = "SELECT id FROM users WHERE username = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $username_err = "This username is already taken";
                $validate_failed = true;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}


    //password validation
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter password";
        $validate_failed = true;
    }else{
        $password = trim($_POST['password']);
    }

    //password confirmation validation
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err = "Please confirm password";
        $validate_failed = true;
    }else{
        $confirm_password = trim($_POST['confirm_password']);
    }

    //check if password and confirm password are the same
    if($password != $confirm_password){
        $validate_failed = true;
        $confirm_password_err = "Passwords do not match";
    }

    if(!$validate_failed){

        $stm = $con->prepare("INSERT INTO users (first_name, last_name, username, password, registered_date, status) VALUES (?, ?, ?, ?, ?, 'active')");
        
        // $status = 'active';
        $registered_date = time();
        $hashed_password = sha1($password);


        $stm->bind_param('ssssi', $first_name, $last_name, $username, $hashed_password, $registered_date);

        
        $result = $stm->execute();

        if($result){
            header('location: login.php');
        }else{
            $error = 'Something went wrong';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3 mt-5">
                <form method="post" class="rounded bg-white shadow p-5">
                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                        <?=$error?>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-primary fw-bolder fs-4 mb-4 text-center">Register as a Student</h3>

                    <!-- <div class="fw-normal text-muted mb-4">
                        <a href="#" class="text-dark fw-bold text-decoration-none">Sign up with Username</a>
                    </div> -->

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?=empty($first_name_err) ? '' : 'is-invalid' ?>" value="<?=$first_name?>" name="first_name" id="floatingInput" placeholder="First Name">
                        <label for="floatingInput">First name</label>
                        <div class="invalid-feedback"><?=$first_name_err?></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?=empty($last_name_err) ? '' : 'is-invalid' ?>" value="<?=$last_name?>" name="last_name" id="floatingInput" placeholder="Last Name">
                        <label for="floatingInput">Last name</label>
                        <div class="invalid-feedback"><?=$last_name_err?></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?=empty($username_err) ? '' : 'is-invalid' ?>" value="<?=$username?>" name="username" id="floatingInput" placeholder="Username">
                        <label for="floatingInput">Username</label>
                        <div class="invalid-feedback"><?=$username_err?></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?=empty($password_err) ? '': 'is-invalid' ?>" name="password" id="floatingInput" placeholder="Password">
                        <label for="floatingInput">Password</label>
                        <div class="invalid-feedback"><?=$password_err?></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?=empty($confirm_password_err) ? '': 'is-invalid' ?>" name="confirm_password" id="floatingInput" placeholder="Confirm Password">
                        <label for="floatingInput">Confirm Password</label>
                        <div class="invalid-feedback"><?=$confirm_password_err?></div>
                    </div>

                    <button type="submit" class="btn btn-primary submit_btn w-100 my-4">Sign Up</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>