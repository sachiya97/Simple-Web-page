<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    
    <title>Register</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("./php/config.php");
         if(isset($_POST['submit'])){
         
             // Given password
            $password = $_POST['password'];
             
             // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            }else{
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                

         //verifying the unique email

                $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

                if(mysqli_num_rows($verify_query) !=0 ){
                    echo "<div class='message'>
                        <p>This email is used, Try another One Please!</p>
                        </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                }else{
                  mysqli_query($con,"INSERT INTO users(Username,Email,Age,Password) VALUES('$username','$email','$age','$password')") or die("Erroe Occured");
                    echo "<div class='message'>
                    <p>Registration successfully!</p>
                    </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button>";
                }
       }   
         }else{
         
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register"  required>
                </div>
                <div id="message">
                    <h4>Password must contain the following:</h4>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
      <script src="./php/validationpassword.js"></script> 
</body>
</html>