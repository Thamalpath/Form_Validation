<?php 
session_start();

if(empty($_SESSION['logged_in'])){
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="style.css">
    <title>Home Page</title>
</head>
<body>
  <div class="container">
    <h1 class="text-center col-md-8" style="color: #fff;">
      Hello <?=$_SESSION['user']['first_name']?> <?php echo $_SESSION['user']['last_name']?>
    </h1>

    <div class="text-center mt-3 col-md-4">
      <form action="logout.php">
        <button type="submit" class="btn btn-danger">Log out</button>
      </form>
    </div>
  </div>
</body>

<style>
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
</style>
</html>