<!DOCTYPE html>
<?php
$con = mysqli_connect("localhost","root","","social");

if(mysqli_connect_errno()){
    echo "Failed to connect" . mysqli_connect_errno();
}

// Declaring Variable names to prvent errors

$fname = "";
$lname = "";
$email = "";
$email2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = "";



if(isset($_POST['register_button'])){

    // Registering Form Values

    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '', $fname);  
    $fname = ucfirst(strtolower($fname)); // Uppercase First Letter
    //Last Name
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);  
    $lname = ucfirst(strtolower($lname)); // Uppercase First Letter
    //Email
    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(' ', '', $email);  
    $email = ucfirst(strtolower($email)); // Uppercase First Letter
    //Email Confirm
    $email2 = strip_tags($_POST['reg_email2']);
    $email2 = str_replace(' ', '', $email2);  
    $email2 = ucfirst(strtolower($email2)); // Uppercase First Letter
    //Password
    $password = strip_tags($_POST['reg_password']);
   
    //Confirm Password
    $password2 = strip_tags($_POST['reg_password2']);


    $date = date("Y-m-d"); // Current Date


    if( $email == $email2 ){
        // Check if email in valid formate

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);


            // Check if email Already Exists
            $e_check = mysqli_query($con," SELECT email FROM users WHERE email = '$email' ");

            // Count Number of rows return
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0){
                echo "Email Already in Use";
            }



        }else{
            
        }

    }else{
        echo "Email Doesn't Match";
    }
   
    if(strlen($fname > 25 || $fname < 2 )){
        echo "First Name should be greater than 2 and less than 25 chracters";
    }
    if(strlen($lname > 25 || $lname < 2 )){
        echo "First Name should be greater than 2 and less than 25 chracters";
    }
    if($password != $password2){
        echo "Passwords Don't Match";
    }else{
        if(preg_match('/[^A-Za-z0-9]/', $password)){
            echo "Password can only contain english characters or Numbers";
        }
    }   

    if(strlen($password > 30 || $password < 5)){
        echo "Password Must be between 5 and 30 characters";
    }




}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Social App</title>
</head>
<body>
    <form action="register.php" method="POST" >
    
        <input type="text" name="reg_fname" placeholder="First Name" required > 
        <br>
        <input type="text" name="reg_lname" placeholder="Last Name" required >
        <br>
        <input type="email" name="reg_email" placeholder="Email" required > 
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" required > 
        <br>
        <input type="password" name="reg_password" placeholder="Password" required >
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required >
        <br>
        <input type="submit" name="register_button" value="Register" >

    </form>
</body>
</html>