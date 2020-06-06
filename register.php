<?php
error_reporting(E_ALL ^ E_WARNING); 
require_once "config.php";

$errors = array();
if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['fullname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
      array_push($errors, "The two passwords do not match");
    }
  
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { 
      if ($user['email'] === $email) {
        array_push($errors, "email already exists");
      }
    }
    if (count($errors) == 0) {
        $password = md5($password_1);
  
        $query = "INSERT INTO users (name, email, password) 
                  VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
  }

?>

<?php require "template/header.php" ?>


<body>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Registration Info</h2>
                    <form method="post" action="register.php" id="registrationForm">
                    <?php  if (count($errors) > 0) : ?>
                      <div class="alert alert-danger" role="alert">
                          <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error ?></p>
                          <?php endforeach ?>
                      </div>
                    <?php  endif ?>
                      <div class="form-group">
                        <label for="InputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                      </div>
                      <div class="form-group">
                        <label for="fullname">Full name</label>
                        <input type="text" name="fullname" class="form-control" id="InputName" placeholder="Enter your name">
                      </div>
                      <div class="form-group">
                        <label for="InputPassword1">Password</label>
                        <input type="password" name="password_1" class="form-control" id="InputPassword1" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <label for="InputPassword2">Confirm password</label>
                        <input type="password" name="password_2" class="form-control" id="InputPassword2" placeholder="Password">
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary text-align-center" name="reg_user">Register</button>
                      </div>
                      <br><br>
                      <p>Already have an account? <a href="login.php">Log in now</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php require "template/footer.php" ?>