<?php

include 'db.php'; 


session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT user_id, username, password, user_type FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];

 
        if ($user['user_type'] == 'doctor') {
            header("Location: doctor_dashboard.php");
        } else {
            header("Location: patient_dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
  }

  .form-login {
    max-width: 500px;
    padding: 15px;
    margin: 0 auto;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .form-login h2 {
    margin-bottom: 20px;
  }
  </style>
</head>

<body>
  <div class="container">
    <form class="form-login" action="login.php" method="POST">
      <h2 class="form-login-heading text-center"> Login</h2>

      <div class="form-group">
        <label for="inputUsername">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus
          name="username">
      </div>

      <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
      </div>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="rememberMe" value="remember-me">
        <label class="form-check-label" for="rememberMe">Remember me</label>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

      <?php if (!empty($error)): ?>
      <p class="text-danger mt-3"><?php echo $error; ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>

</html>