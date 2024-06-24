<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'doctor') {
    header("Location: login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$doctorDetailsSql = "SELECT * FROM doctors_details WHERE doctor_id = ?";
$doctorDetailsStmt = $pdo->prepare($doctorDetailsSql);
$doctorDetailsStmt->execute([$doctor_id]);
$doctorDetails = $doctorDetailsStmt->fetch();

$appointmentsSql = "SELECT a.*, p.username AS patient_name, IFNULL(pr.prescription_text, 'N/A') AS prescription
                    FROM appointments a
                    JOIN users p ON a.patient_id = p.user_id
                    LEFT JOIN prescriptions pr ON a.appointment_id = pr.appointment_id
                    WHERE a.doctor_id = ? ORDER BY a.appointment_date DESC";
$appointmentsStmt = $pdo->prepare($appointmentsSql);
$appointmentsStmt->execute([$doctor_id]);
$appointments = $appointmentsStmt->fetchAll();

$schedulesSql = "SELECT * FROM doctor_schedules WHERE doctor_id = ?";
$schedulesStmt = $pdo->prepare($schedulesSql);
$schedulesStmt->execute([$doctor_id]);
$schedules = $schedulesStmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_schedule'])) {
        $start = $_POST['start_time'];
        $end = $_POST['end_time'];
        $insertSql = "INSERT INTO doctor_schedules (doctor_id, available_start, available_end) VALUES (?, ?, ?)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->execute([$doctor_id, $start, $end]);
        header("Refresh:0");
    } elseif (isset($_POST['prescribe'])) {
        $appointment_id = $_POST['appointment_id'];
        $prescription = $_POST['prescription'];
        

        $updateSql = "UPDATE appointments SET status = 'completed' WHERE appointment_id = ?";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$appointment_id]);
        
   
        $prescriptionSql = "INSERT INTO prescriptions (appointment_id, doctor_id, patient_id, prescription_text, date_prescribed)
                            VALUES (?, ?, ?, ?, NOW())
                            ON DUPLICATE KEY UPDATE 
                            prescription_text = VALUES(prescription_text), date_prescribed = NOW()";
        $prescriptionStmt = $pdo->prepare($prescriptionSql);
        $prescriptionStmt->execute([$appointment_id, $doctor_id, $_POST['patient_id'], $prescription]);
        
        header("Refresh:0");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Dashboard</title>
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
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  img.profile-pic {
    width: 100px;
    height: auto;
    border-radius: 50%;
    margin-bottom: 20px;
  }

  .dashboard h2 {
    margin-bottom: 20px;
  }

  .table th,
  .table td {
    vertical-align: middle;
  }

  @media print {
    body * {
      visibility: hidden;
    }

    .table,
    .table * {
      visibility: visible;
    }

    .table {
      position: absolute;
      left: 0;
      top: 0;
    }


    .table th:last-child,
    .table td:last-child {
      display: none;
    }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="dashboard">
      <h2 class="text-center">Welcome, Dr. <?php echo htmlentities($_SESSION['username']); ?></h2>
      <div class="text-center">
        <img src="<?php echo htmlentities($doctorDetails['photo_url']); ?>" alt="Profile Picture" class="profile-pic"
          style="border-radius: 0;">
      </div>
      <div class="text-center mb-3">
        <a href="profile.php" class="btn btn-info">Edit Profile</a>
      </div>
      <h4>Your Appointments:</h4>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Symptoms</th>
            <th>Status</th>
            <th>Prescription</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appointments as $appointment): ?>
          <tr>
            <td><?php echo htmlentities($appointment['patient_name']); ?></td>
            <td><?php echo $appointment['appointment_date']; ?></td>
            <td><?php echo htmlentities($appointment['symptoms']); ?></td>
            <td><?php echo $appointment['status']; ?></td>
            <td><?php echo htmlentities($appointment['prescription']); ?></td>
            <td>
              <?php if ($appointment['status'] == 'pending'): ?>
              <form action="doctor_dashboard.php" method="post" class="form-inline">
                <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                <input type="hidden" name="patient_id" value="<?php echo $appointment['patient_id']; ?>">
                <input type="text" name="prescription" class="form-control mb-2 mr-sm-2"
                  placeholder="Enter prescription" required>
                <button type="submit" name="prescribe" class="btn btn-primary mb-2">Prescribe</button>
              </form>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button class="btn btn-info" onclick="printAppointments()">Print Appointments </button>

      <h4>Add New Availability:</h4>
      <form action="doctor_dashboard.php" method="post" class="form-inline mb-3">
        <div class="form-group mb-2">
          <label for="start_time" class="sr-only">Start Time</label>
          <input type="datetime-local" id="start_time" name="start_time" class="form-control" required>
        </div>
        <div class="form-group mx-sm-3 mb-2">
          <label for="end_time" class="sr-only">End Time</label>
          <input type="datetime-local" id="end_time" name="end_time" class="form-control" required>
        </div>
        <button type="submit" name="add_schedule" class="btn btn-success mb-2">Add Schedule</button>
      </form>
      <h4>Your Schedule:</h4>
      <ul class="list-group">
        <?php foreach ($schedules as $schedule): ?>
        <li class="list-group-item">From: <?php echo $schedule['available_start']; ?> To:
          <?php echo $schedule['available_end']; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <script>
  function printAppointments() {
    let content = document.querySelector('.table').outerHTML;
    let originalContent = document.body.innerHTML;
    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = originalContent;
  }
  </script>



</body>

</html>