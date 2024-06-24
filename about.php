<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    height: 200px;
    object-fit: cover;
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

  img {
    border-radius: 10px;
    width: 100%;
  }

  .team-member {
    text-align: center;
  }

  .team-member h5 {
    margin-top: 15px;
    color: #007bff;
  }

  .team-member p {
    color: #6c757d;
  }
  </style>
</head>

<body>
  <div class="header">
    <h1>About Us</h1>
    <p>Discover the heart and soul of our hospital and meet the dedicated professionals who care for you.</p>
  </div>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h2>Welcome to Our Hospital</h2>
        <p>At our hospital, we are committed to providing the highest quality care to our patients. Our state-of-the-art
          facilities and experienced team ensure you receive the best possible treatment and care.</p>
        <p>Since our establishment in 1990, we have been a pillar of the community, offering a wide range of healthcare
          services from emergency care to specialized treatments.</p>
      </div>
      <div class="col-md-6">
        <img src="images/hospital.jpg" class="img-fluid" alt="Hospital Image">
      </div>
    </div>
  </div>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Our Mission</h3>
            <p class="card-text">To deliver compassionate, high-quality, and affordable healthcare services, enhancing
              the health and well-being of our community.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Our Vision</h3>
            <p class="card-text">To be the leading healthcare provider, renowned for excellence in patient care,
              innovative practices, and community health improvement.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <h2>Meet Our Team</h2>
    <div class="row">
      <div class="col-md-4">
        <div class="card team-member">
          <img src="images/mm.jpg" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
            <h5 class="card-title">Dr. Ahmed Mahmoud</h5>
            <p class="card-text">Chief Medical Officer</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card team-member">
          <img src="images/na.jpg" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
            <h5 class="card-title">Dr. Nashwa Ali</h5>
            <p class="card-text">Head of Surgery</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card team-member">
          <img src="images/fh.png" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
            <h5 class="card-title">Dr. Fatma Hassan</h5>
            <p class="card-text">Chief of Pediatrics</p>
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