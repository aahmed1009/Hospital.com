<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
  body {
    padding-top: 70px;
    background-color: #f4f7f6;
  }

  .hero-section {
    background-color: #f8f9fa;
    padding: 100px 0;
    text-align: center;
  }

  .hero-section h1 {
    font-size: 4rem;
    margin-bottom: 20px;
  }

  .hero-section p {
    font-size: 1.5rem;
    margin-bottom: 30px;
  }

  .services-section {
    padding: 60px 0;
    background-color: #007bff;
    color: #fff;
    text-align: center;
  }

  .services-section h2 {
    margin-bottom: 40px;
    color: #fff;
  }

  .services-section .card {
    background-color: #fff;
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
  }

  .services-section .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }

  .services-section .service-icon {
    font-size: 50px;
    color: #007bff;
    margin-bottom: 15px;
  }

  .services-section .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007bff;
  }

  .services-section .card-text {
    color: #6c757d;
  }

  .testimonial-section {
    padding: 60px 0;
    background-color: #f8f9fa;
    text-align: center;
  }

  .testimonial-section h2 {
    margin-bottom: 40px;
  }

  .testimonial-section .testimonial {
    margin-bottom: 30px;
    font-style: italic;
  }

  .testimonial-section .testimonial p {
    margin-bottom: 5px;
  }

  .team-section {
    padding: 60px 0;
    background-color: #007bff;
    color: #fff;
  }

  .team-section h2 {
    margin-bottom: 40px;
    text-align: center;
  }

  .team-section .card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .team-section .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }

  .team-section .card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    height: 200px;
    object-fit: cover;
  }

  .team-section .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007bff;
  }

  .team-section .card-text {
    color: #6c757d;
  }

  footer {
    background-color: #343a40;
    color: #fff;
    padding: 20px 0;
    text-align: center;
  }

  .container {
    padding: 0;
  }
  </style>
</head>

<body>
  <div class="hero-section">
    <div class="container">
      <h1>Welcome to Our Online Hospital</h1>
      <p class="lead">Providing quality healthcare services to everyone</p>
      <a href="register.php" class="btn btn-primary btn-lg">Get Started</a>
    </div>
  </div>

  <div class="services-section">
    <div class="container">
      <h2>Our Services</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="card service-card text-center">
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
          <div class="card service-card text-center">
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
          <div class="card service-card text-center">
            <div class="card-body">
              <div class="service-icon">
                <i class="fas fa-capsules"></i>
              </div>
              <h5 class="card-title">Prescription Services</h5>
              <p class="card-text">Receive prescriptions for necessary medications from our licensed doctors, sent
                directly to your pharmacy of choice.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="testimonial-section">
    <div class="container">
      <h2>Testimonials</h2>
      <div class="row">
        <div class="col-md-4 testimonial">
          <p>"The doctors and staff were incredibly attentive and caring. I felt like I was in good hands throughout my
            entire stay."</p>
          <p><strong>- Alaa Ahmed</strong></p>
        </div>
        <div class="col-md-4 testimonial">
          <p>"Excellent service and top-notch facilities. I highly recommend this hospital to anyone in need of medical
            care."</p>
          <p><strong>- Youssef Ahmed</strong></p>
        </div>
        <div class="col-md-4 testimonial">
          <p>"I received prompt and professional treatment. The staff was friendly and the environment was clean and
            welcoming."</p>
          <p><strong>- Ahmed Ali</strong></p>
        </div>
      </div>
    </div>
  </div>

  <div class="team-section">
    <div class="container">
      <h2>Meet Our Team</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="card team-member text-center">
            <img src="images/mm.jpg" class="card-img-top" alt="Doctor Image">
            <div class="card-body">
              <h5 class="card-title">Dr. Ahmed Mahmoud</h5>
              <p class="card-text">Chief Medical Officer</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card team-member text-center">
            <img src="images/na.jpg" class="card-img-top" alt="Doctor Image">
            <div class="card-body">
              <h5 class="card-title">Dr. Nashwa Ali</h5>
              <p class="card-text">Head of Surgery</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card team-member text-center">
            <img src="images/fh.png" class="card-img-top" alt="Doctor Image">
            <div class="card-body">
              <h5 class="card-title">Dr. Fatma Hassan</h5>
              <p class="card-text">Chief of Pediatrics</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
include "footer.php";
?>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>