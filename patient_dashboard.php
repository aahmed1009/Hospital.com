<?php
include 'db.php';  
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'patient') {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['user_id'];

$appointmentsSql = "SELECT a.*, d.specialization, d.photo_url, d.phone, u.username AS doctor_name, pr.prescription_text
                    FROM appointments a
                    JOIN doctors_details d ON a.doctor_id = d.doctor_id
                    JOIN users u ON d.doctor_id = u.user_id
                    LEFT JOIN prescriptions pr ON a.appointment_id = pr.appointment_id
                    WHERE a.patient_id = ? ORDER BY a.appointment_date DESC";
$appointmentsStmt = $pdo->prepare($appointmentsSql);
$appointmentsStmt->execute([$patient_id]);
$appointments = $appointmentsStmt->fetchAll();

$specializationsSql = "SELECT DISTINCT specialization FROM doctors_details";
$specializationsStmt = $pdo->prepare($specializationsSql);
$specializationsStmt->execute();
$specializations = $specializationsStmt->fetchAll(PDO::FETCH_COLUMN);

$doctorsSql = "SELECT doctor_id, specialization, username, photo_url FROM doctors_details JOIN users ON doctors_details.doctor_id = users.user_id";
$doctorsStmt = $pdo->prepare($doctorsSql);
$doctorsStmt->execute();
$doctors = $doctorsStmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['book_appointment'])) {
        $doctor_id = $_POST['doctor_id'];
        $date = $_POST['date'];
        $symptoms = $_POST['symptoms'];

        $bookSql = "INSERT INTO appointments (doctor_id, patient_id, appointment_date, symptoms, status) VALUES (?, ?, ?, ?, 'pending')";
        $bookStmt = $pdo->prepare($bookSql);
        $bookStmt->execute([$doctor_id, $patient_id, $date, $symptoms]);

        header("Refresh:0");
    } elseif (isset($_POST['cancel_appointment'])) {
        $appointment_id = $_POST['appointment_id'];
        $cancelSql = "DELETE FROM appointments WHERE appointment_id = ?";
        $cancelStmt = $pdo->prepare($cancelSql);
        $cancelStmt->execute([$appointment_id]);

        header("Refresh:0");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Dashboard</title>
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

  .doctor-info {
    display: flex;
    align-items: center;
  }

  .doctor-info img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }
  </style>
</head>

<body>
  <div class="dashboard">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

    <h4>Your Appointments:</h4>
    <table class="table">
      <thead>
        <tr>
          <th>Doctor</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Specialization</th>
          <th>Date</th>
          <th>Symptoms</th>
          <th>Status</th>
          <th>Prescription</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
          <td><img src="<?php echo htmlentities($appointment['photo_url']); ?>" alt="Doctor"
              style="width: 50px; height: 50px; border-radius: 50%;"></td>
          <td><?php echo htmlentities($appointment['doctor_name']); ?></td>
          <td><?php echo htmlentities($appointment['phone']); ?></td>
          <td><?php echo htmlentities($appointment['specialization']); ?></td>
          <td><?php echo $appointment['appointment_date']; ?></td>
          <td><?php echo htmlentities($appointment['symptoms']); ?></td>
          <td><?php echo $appointment['status']; ?></td>
          <td><?php echo $appointment['prescription_text'] ? htmlentities($appointment['prescription_text']) : 'N/A'; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <h4>Book an Appointment:</h4>
    <form action="patient_dashboard.php" method="post">
      <div class="form-group">
        <label for="specialization">Select Specialization:</label>
        <select id="specialization" class="form-control" required onchange="populateDoctors()">
          <option value="">Select Specialization</option>
          <?php foreach ($specializations as $specialization): ?>
          <option value="<?php echo htmlentities($specialization); ?>"><?php echo htmlentities($specialization); ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="doctor_id">Select Doctor:</label>
        <select id="doctor_id" name="doctor_id" class="form-control" required>
          <option value="">Select Doctor</option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Date:</label>
        <input type="datetime-local" id="date" name="date" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="symptoms">Symptoms:</label>
        <textarea id="symptoms" name="symptoms" class="form-control" rows="3" required></textarea>
      </div>
      <button type="submit" name="book_appointment" class="btn btn-primary">Book Appointment</button>
    </form>
  </div>

  <script>
  const doctors = <?php echo json_encode($doctors); ?>;

  function populateDoctors() {
    const specialization = document.getElementById('specialization').value;
    const doctorSelect = document.getElementById('doctor_id');
    doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

    doctors.forEach(doctor => {
      if (doctor.specialization === specialization) {
        const option = document.createElement('option');
        option.value = doctor.doctor_id;
        option.textContent = doctor.username;
        doctorSelect.appendChild(option);
      }
    });
  }
  </script>
</body>

</html>