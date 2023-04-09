<?php
session_start();

$username = $password = "";
$username_err = $password_err = "";
if(!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ){
    header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    require_once 'db-connect.php';
    //username validation
    if(empty(trim($_POST['username']))){
        $username_err = "Please enter username";
    }else{
        $username = trim($_POST['username']);
    }

    //password validation
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter password";
    }else{
        $password = trim($_POST['password']);
    }

    //check if there are no errors
    if( empty($username_err) && empty($password_err) ){

        $sql1 = "SELECT * FROM users where username='".$username."'";
        $result = $con->query($sql1);

        if($result->num_rows> 0){
            $user = $result->fetch_assoc();
            
            if($user['password'] == sha1($password)){

                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = array(
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'id' => $user['id']
                );

                header('location: index.php');
                exit;

            }else{
                $password_err = 'Invalid password';
            }

        }else{
            $username_err = 'Invalid username';
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
    <title>Login Form</title>

    <!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3 text-center" style="margin-top: 170px;">
                <form method="post" class="rounded bg-white shadow p-5">
                    <h3 class="text-primary fw-bolder fs-4 mb-2">Login as a Student</h3>

                    <!-- <div class="fw-normal text-muted mb-4">
                        <a href="#" class="text-dark fw-bold text-decoration-none">Sign in with Username</a>
                    </div> -->

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?=empty($username_err) ? '' : 'is-invalid'?>" value="<?=$username?>" name="username" id="floatingUsername" placeholder="Username">
                        <label for="floatingUsername">Username</label>
                        <div class="invalid-feedback"><?=$username_err?></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?=empty($password_err) ? '' : 'is-invalid'?>" name="password" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                        <div class="invalid-feedback"><?=$password_err?></div>
                    </div>

                    <button type="submit" class="btn btn-primary submit_btn w-100 my-4">Sign In</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>