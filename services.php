<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Services</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f6;
    color: #343a40;
  }

  .header {
    background-color: #007bff;
    color: #fff;
    padding: 60px 20px;
    text-align: center;
    margin-bottom: 20px;
  }

  .content-container {
    margin-top: 80px;
  }

  h2 {
    color: #007bff;
    margin-bottom: 30px;
  }

  .card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
  }

  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }

  .service-icon {
    font-size: 50px;
    color: #007bff;
    margin-bottom: 15px;
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007bff;
  }

  .card-text {
    color: #6c757d;
  }

  .container {
    padding: 20px;
  }

  .my-5 {
    margin-top: 3rem !important;
    margin-bottom: 3rem !important;
  }

  p {
    line-height: 1.6;
  }
  </style>
</head>

<body>
  <div class="header">
    <h1>Our Services</h1>
    <p>We offer a wide range of healthcare services to meet your needs.</p>
  </div>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <div class="service-icon">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <h5 class="card-title">Appointment Scheduling</h5>
            <p class="card-text">Easily schedule appointments with your preferred doctor through our online platform.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <div class="service-icon">
              <i class="fas fa-notes-medical"></i>
            </div>
            <h5 class="card-title">Symptom Reporting</h5>
            <p class="card-text">Describe your symptoms to our healthcare professionals, who will provide a thorough
              evaluation and appropriate care.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <div class="service-icon">
              <i class="fas fa-prescription"></i>
            </div>
            <h5 class="card-title">Prescription Services</h5>
            <p class="card-text">Receive prescriptions for necessary medications from our licensed doctors, sent
              directly to your pharmacy of choice.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <div class="service-icon">
              <i class="fas fa-stethoscope"></i>
            </div>
            <h5 class="card-title">Medical Consultations</h5>
            <p class="card-text">Consult with our experienced doctors for personalized medical advice and treatment
              plans tailored to your needs.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <div class="service-icon">
              <i class="fas fa-vials"></i>
            </div>
            <h5 class="card-title">Lab Testing</h5>
            <p class="card-text">Access a wide range of lab tests to monitor your health and get accurate diagnoses from
              our certified laboratories.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <div class="service-icon">
              <i class="fas fa-user-md"></i>
            </div>
            <h5 class="card-title">Specialist Referrals</h5>
            <p class="card-text">Get referrals to top specialists for advanced treatments and second opinions on complex
              medical conditions.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
include "footer.php";
?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>