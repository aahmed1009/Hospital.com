<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];


$userSql = "SELECT * FROM users WHERE user_id = ?";
$userStmt = $pdo->prepare($userSql);
$userStmt->execute([$user_id]);
$user = $userStmt->fetch();


if ($user_type == 'doctor') {
    $detailsSql = "SELECT * FROM doctors_details WHERE doctor_id = ?";
    $detailsStmt = $pdo->prepare($detailsSql);
    $detailsStmt->execute([$user_id]);
    $details = $detailsStmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

   
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        } else {
            $target_file = $details['photo_url'] ?? null;
        }

        $updateUserSql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
        $updateUserStmt = $pdo->prepare($updateUserSql);
        $updateUserStmt->execute([$username, $email, $user_id]);

        if ($user_type == 'doctor') {
            $available_times = $_POST['available_times'];

            $updateDetailsSql = "UPDATE doctors_details SET phone = ?, photo_url = ?, available_times = ? WHERE doctor_id = ?";
            $updateDetailsStmt = $pdo->prepare($updateDetailsSql);
            $updateDetailsStmt->execute([$phone, $target_file, $available_times, $user_id]);
        } else {
            $updateDetailsSql = "UPDATE patient_details SET phone = ?, photo_url = ? WHERE patient_id = ?";
            $updateDetailsStmt = $pdo->prepare($updateDetailsSql);
            $updateDetailsStmt->execute([$phone, $target_file, $user_id]);
        }


        header("Refresh:0");
    } elseif (isset($_POST['change_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (password_verify($old_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updatePasswordSql = "UPDATE users SET password = ? WHERE user_id = ?";
                $updatePasswordStmt = $pdo->prepare($updatePasswordSql);
                $updatePasswordStmt->execute([$hashed_password, $user_id]);
                $password_message = "Password updated successfully.";
            } else {
                $password_message = "New passwords do not match.";
            }
        } else {
            $password_message = "Old password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
  }

  .dashboard {
    max-width: 960px;
    padding: 15px;
    margin: 0 auto;
  }

  img.profile-pic {
    width: 100px;
    height: auto;
    border-radius: 50%;
    margin-bottom: 20px;
  }
  </style>
</head>

<body>
  <div class="dashboard">
    <h2>Profile Management</h2>
    <form action="profile.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" class="form-control" name="username"
          value="<?php echo htmlentities($user['username']); ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" class="form-control" name="email"
          value="<?php echo htmlentities($user['email']); ?>" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" class="form-control" name="phone"
          value="<?php echo htmlentities($details['phone']); ?>" required>
      </div>
      <div class="form-group">
        <label for="photo">Profile Photo</label>
        <input type="file" id="photo" class="form-control-file" name="photo">
        <?php if (isset($details['photo_url']) && $details['photo_url']): ?>
        <img src="<?php echo htmlentities($details['photo_url']); ?>" alt="Profile Picture" class="profile-pic"
          style="border-radius: 0;">
        <?php endif; ?>
      </div>
      <?php if ($user_type == 'doctor'): ?>
      <div class="form-group">
        <label for="available_times">Available Times</label>
        <input type="text" id="available_times" class="form-control" name="available_times"
          value="<?php echo htmlentities($details['available_times']); ?>" required>
      </div>
      <?php endif; ?>
      <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>
    <h2>Change Password</h2>
    <form action="profile.php" method="post">
      <div class="form-group">
        <label for="old_password">Old Password</label>
        <input type="password" id="old_password" class="form-control" name="old_password" required>
      </div>
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" class="form-control" name="new_password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" class="form-control" name="confirm_password" required>
      </div>
      <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
      <?php if (isset($password_message)): ?>
      <p><?php echo htmlentities($password_message); ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>

</html>