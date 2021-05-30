<?php  
require './config/config.php';

if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    $userDetailsQuery = mysqli_query($con," SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($userDetailsQuery);
}else{
    header("Location: register.php");
}


?>

<html>
<head>
	<title>Welcome to Social Site</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- JavaScript  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d6a9aadf68.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="top_bar">
    <div class="logo">
        <a href="index.php">Social Site</a>
    </div>

    <nav>
        <a href="<?php echo $userLoggedIn; ?>"> <?php echo $user['first_name']; ?> </a>
        <a href="#"> <i class="fas fa-home fa-lg"></i></a>
        <a href="#"><i class="fas fa-envelope fa-lg"></i></a>
        <a href="#"><i class="far fa-bell fa-lg"></i></a>
        <a href="#"><i class="fas fa-users fa-lg"></i></a>
        <a href="#"><i class="fas fa-cog fa-lg"></i></a>
        <a href="includes/handlers/logout.php"><i class="fas fa-sign-out-alt fa-lg"></i></a>
    </nav>


</div>

<div class="wrapper">