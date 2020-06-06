<?php
session_start();

$errors = array();
require_once "config.php";

if (isset($_POST['new_password'])) {
    $password_1 = mysqli_real_escape_string($db, $_POST['new_pass']);
    $password_2 = mysqli_real_escape_string($db, $_POST['new_pass_c']);

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    if (count($errors) == 0) {
        $password = md5($password_1);
        $user = $_SESSION['username'];
        $query = "UPDATE users SET password='$password' WHERE name='$user'";

        mysqli_query($db, $query);
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
                    <h2 class="title">Reset Password</h2>
                    <p>Please fill in your credentials to reset your password.</p>
                    <form class="login-form" action="reset-password.php" method="post">
                    <?php  if (count($errors) > 0) : ?>
                      <div class="alert alert-danger" role="alert">
                          <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error ?></p>
                          <?php endforeach ?>
                      </div>
                    <?php  endif ?>
                        <div class="form-group">
                            <label>New password</label>
                            <input type="password" name="new_pass" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Confirm new password</label>
                            <input type="password" name="new_pass_c" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="new_password" class="btn btn-primary" >Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require "template/footer.php" ?>