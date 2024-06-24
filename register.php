<?php
// Include the database connection script
include 'db.php'; // Make sure the path and file exist

// Define popular specializations
$specializations = [
    "Cardiology", "Dermatology", "Neurology", "Pediatrics", "General Medicine", 
    "Orthopedics", "Gynecology", "Oncology", "Radiology", "Psychiatry"
];

// Handle the POST request to register a user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    // Check if username already exists
    $checkUsernameSql = "SELECT COUNT(*) FROM users WHERE username = ?";
    $checkUsernameStmt = $pdo->prepare($checkUsernameSql);
    $checkUsernameStmt->execute([$username]);
    $usernameExists = $checkUsernameStmt->fetchColumn();

    if ($usernameExists) {
        echo "Error: Username already exists. Please choose another username.";
    } else {
        // Insert into users table
        $sql = "INSERT INTO users (username, password, email, user_type, address, gender, dob) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$username, $password, $email, $user_type, $address, $gender, $dob])) {
            $user_id = $pdo->lastInsertId();

            // Handle additional details for doctor
            if ($user_type == 'doctor') {
                $specialization = $_POST['specialization'] == 'other' ? $_POST['new_specialization'] : $_POST['specialization'];
                $phone = $_POST['phone'];
                $available_times = $_POST['available_times'];
                $qualifications = $_POST['qualifications'];
                
                // Handle file upload
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                    $target_dir = "uploads/";
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
                } else {
                    $target_file = null;
                }

                $sql = "INSERT INTO doctors_details (doctor_id, specialization, phone, photo_url, available_times, qualifications) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user_id, $specialization, $phone, $target_file, $available_times, $qualifications]);
            }

            // Handle additional details for patient
            if ($user_type == 'patient') {
                $emergency_contact = $_POST['emergency_contact'];

                $sql = "INSERT INTO patients_details (patient_id, emergency_contact) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user_id, $emergency_contact]);
            }

            // Redirect to login page or dashboard
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
  <style>
  body {
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
  }

  .form-register {
    max-width: 500px;
    padding: 15px;
    margin: 0 auto;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .form-register h2 {
    margin-bottom: 20px;
  }

  .error-message {
    color: red;
    margin-top: 5px;
  }

  .success-message {
    color: green;
    margin-top: 5px;
  }
  </style>
</head>

<body>
  <div class="container">
    <form class="form-register" action="register.php" method="POST" enctype="multipart/form-data">
      <h2 class="form-register-heading text-center"> Register</h2>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" required autofocus name="username">
        <div id="username-feedback" class="error-message"></div>
      </div>

      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" class="form-control" placeholder="Email address" required name="email">
        <div id="email-feedback" class="error-message"></div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Password" required name="password">
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" class="form-control" placeholder="Address" required name="address">
      </div>

      <div class="form-group">
        <label for="gender">Gender</label>
        <select id="gender" class="form-control" name="gender" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" class="form-control" placeholder="Date of Birth" required name="dob">
      </div>

      <div class="form-group">
        <label for="user_type">User Type</label>
        <select id="user_type" class="form-control" name="user_type" required onchange="showDoctorInfo(this.value)">
          <option value="patient">Patient</option>
          <option value="doctor">Doctor</option>
        </select>
      </div>

      <div id="doctor-info" style="display: none;">
        <div class="form-group">
          <label for="specialization">Specialization</label>
          <select id="specialization" class="form-control" name="specialization"
            onchange="toggleNewSpecialization(this.value)">
            <?php foreach ($specializations as $spec): ?>
            <option value="<?= $spec ?>"><?= $spec ?></option>
            <?php endforeach; ?>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="form-group" id="new-specialization-group" style="display: none;">
          <label for="new_specialization">New Specialization</label>
          <input type="text" id="new_specialization" class="form-control" placeholder="Enter new specialization"
            name="new_specialization">
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" id="phone" class="form-control" placeholder="Phone" name="phone">
        </div>

        <div class="form-group">
          <label for="photo">Photo</label>
          <input type="file" id="photo" class="form-control-file" name="photo">
        </div>

        <div class="form-group">
          <label for="available_times">Available Times</label>
          <input type="text" id="available_times" class="form-control" placeholder="Available Times"
            name="available_times">
        </div>

        <div class="form-group">
          <label for="qualifications">Qualifications</label>
          <input type="text" id="qualifications" class="form-control" placeholder="Qualifications"
            name="qualifications">
        </div>
      </div>

      <div id="patient-info" style="display: none;">
        <div class="form-group">
          <label for="emergency_contact">Emergency Contact</label>
          <input type="text" id="emergency_contact" class="form-control" placeholder="Emergency Contact"
            name="emergency_contact">
        </div>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
  </script>
  <script>
  $(document).ready(function() {
    $('#available_times').datetimepicker({
      format: 'Y-m-d H:i',
      step: 30
    });

    $('#username').on('input', function() {
      checkAvailability('username', $(this).val());
    });

    $('#email').on('input', function() {
      checkAvailability('email', $(this).val());
    });
  });

  function showDoctorInfo(value) {
    if (value === 'doctor') {
      $('#doctor-info').show();
      $('#patient-info').hide();
    } else {
      $('#doctor-info').hide();
      $('#patient-info').show();
    }
  }

  function toggleNewSpecialization(value) {
    if (value === 'other') {
      $('#new-specialization-group').show();
    } else {
      $('#new-specialization-group').hide();
    }
  }

  function checkAvailability(type, value) {
    if (value.length < 3) return;
    $.ajax({
      url: 'check_availability.php',
      type: 'POST',
      data: {
        type: type,
        value: value
      },
      success: function(response) {
        const data = JSON.parse(response);
        const feedbackElement = $('#' + type + '-feedback');
        feedbackElement.removeClass('error-message success-message');
        if (data.status === 'error') {
          feedbackElement.addClass('error-message').text(data.message);
        } else {
          feedbackElement.addClass('success-message').text(data.message);
        }
      }
    });
  }
  </script>
</body>

</html>