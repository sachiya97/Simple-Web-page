<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            <?php 
                include("php/config.php");
                $secretKey  = '6LeG6PolAAAAAOcpsJZO2Km5LbJa_RQp2emNKKPf';    
                // If the form is submitted 
                $postData = $statusMsg = ''; 
                $status = 'error'; 
              if(isset($_POST['submit'])){
                
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);
                if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
 
                    // Verify the reCAPTCHA API response 
                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
                     
                    // Decode JSON data of API response 
                    $responseData = json_decode($verifyResponse); 
                     
                    // If the reCAPTCHA API response is valid 
                    if($responseData->success){ 
                        $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                        $row = mysqli_fetch_assoc($result);

                        if(is_array($row) && !empty($row)){
                            $_SESSION['valid'] = $row['Email'];
                            $_SESSION['username'] = $row['Username'];
                            $_SESSION['age'] = $row['Age'];
                            $_SESSION['id'] = $row['Id'];
                        }else{
                            echo "<div class='message'>
                            <p>Invalid Email or Password</p>
                            </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button>";
                
                        }
                        if(isset($_SESSION['valid'])){
                            header("Location: home.php");
                        }
                    }else{ 
                        echo "<div class='message'>
                            <p>Robot verification failed, please try again.</p>
                            </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button>";
                        
                    } 
                }else{ 
                    echo "<div class='message'>
                            <p>Please check the reCAPTCHA checkbox.</p>
                            </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button>";
                }
              }
              else{

            
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="g-recaptcha" data-sitekey="6LeG6PolAAAAAGbwxV0sUvfEQa3owAjN_h_l4K2A"></div>
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>