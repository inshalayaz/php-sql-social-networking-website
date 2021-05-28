<!DOCTYPE html>
<?php

session_start();

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
$error_array = [];



if(isset($_POST['register_button'])){

    // Registering Form Values

    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '', $fname);  
    $fname = ucfirst(strtolower($fname)); // Uppercase First Letter
    $_SESSION['reg_fname'] = $fname; // This store the variable in Session Variable

    //Last Name
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);  
    $lname = ucfirst(strtolower($lname)); // Uppercase First Letter
    $_SESSION['reg_lname'] = $lname; // This store the variable in Session Variable

    //Email
    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(' ', '', $email);  
    $email = ucfirst(strtolower($email)); // Uppercase First Letter
    $_SESSION['reg_email'] = $email; // This store the variable in Session Variable

    //Email Confirm
    $email2 = strip_tags($_POST['reg_email2']);
    $email2 = str_replace(' ', '', $email2);  
    $email2 = ucfirst(strtolower($email2)); // Uppercase First Letter
    $_SESSION['reg_email2'] = $email2; // This store the variable in Session Variable

    //Password
    $password = strip_tags($_POST['reg_password']);
    $_SESSION['reg_password'] = $password; // This store the variable in Session Variable

   
    //Confirm Password
    $password2 = strip_tags($_POST['reg_password2']);
    $_SESSION['reg_password2'] = $password2; // This store the variable in Session Variable


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
                array_push($error_array,"Email Already In Use <br>");
            }



        }else{
            array_push($error_array, "Invalid Email Formate <br>");
        }

    }else{
        array_push($error_array, "Email Doesn't Match<br>");
    }
   
    if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
	}

	if($password != $password2) {
		array_push($error_array,  "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}

    if(empty($error_array)){
        $password = md5($password); // Encrypting the password

        // Generating Username

        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, " SELECT username FROM users WHERE username='$username' ");

        $i = 0;
        //If users exists add numbers
        while(mysqli_num_rows($check_username_query) != 0){
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, " SELECT username FROM users WHERE username='$username' ");

        }

        // Profile Picture
        $rand = rand(1,2);
        if($rand == 1){
            $profile_pic = "assets/images/profile_pics/defaults/head_alizarin.png";
        }else{
            $profile_pic = "assets/images/profile_pics/defaults/head_amethyst.png";   
        }

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
    
        <input type="text" name="reg_fname" placeholder="First Name" required 
        value = "<?php 
            if(isset($_SESSION['reg_fname'])){
                echo $_SESSION['reg_fname'];
            }
        ?> ">
        <br>
        
        <?php if(in_array("First Name should be greater than 2 and less than 25 chracters <br>", $error_array)) echo "First Name should be greater than 2 and less than 25 chracters <br>";?>

        <input type="text" name="reg_lname" placeholder="Last Name" required 
        value = "<?php 
            if(isset($_SESSION['reg_lname'])){
                echo $_SESSION['reg_lname'];
            }
            ?> "
        >
        <br>
        <?php if(in_array("Last Name should be greater than 2 and less than 25 chracters <br>", $error_array)) echo "Last Name should be greater than 2 and less than 25 chracters <br>";?>

        <input type="email" name="reg_email" placeholder="Email" required
        value = "<?php 
            if(isset($_SESSION['reg_email'])){
                echo $_SESSION['reg_email'];
            }
        ?> "
        > 
        <br>
        
        <input type="email" name="reg_email2" placeholder="Confirm Email" required 
        value = "<?php 
            if(isset($_SESSION['reg_email2'])){
                echo $_SESSION['reg_email2'];
            }
        ?> "
        > 
        <br>
        <?php if(in_array("Email Already In Use <br>", $error_array)) echo "Email Already In Use <br>";?>
        <?php if(in_array("Invalid Email Formate <br>", $error_array)) echo "Invalid Email Formate <br>";?>
        <?php if(in_array("Email Doesn't Match<br>", $error_array)) echo "Email Doesn't Match<br>";?>

        <input type="password" name="reg_password" placeholder="Password" required >
        <br>
        <?php if(in_array("Passwords Don't Match <br>", $error_array)) echo "Passwords Don't Match <br>";?>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required x>
        <br>
        <?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Passwords Don't Match <br>";?>
        <?php if(in_array("Password can only contain english characters or Numbers <br>", $error_array)) echo "Password can only contain english characters or Numbers <br>";?>
        <?php if(in_array("Password Must be between 5 and 30 characters <br>", $error_array)) echo "Password Must be between 5 and 30 characters <br>";?>



        <input type="submit" name="register_button" value="Register" >

    </form>
</body>
</html>