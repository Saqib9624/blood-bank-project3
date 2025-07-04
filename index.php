<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Blood Bank Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: #fff;
      min-height: 100vh;
      padding: 30px 15px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .home-box {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 60px 40px;
      text-align: center;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
      max-width: 720px;
      width: 100%;
    }

    .home-box h1 {
      font-size: 2.5rem;
      color: #f87171;
      font-weight: bold;
      margin-bottom: 40px;
    }

    .btn-custom {
      padding: 14px 24px;
      font-size: 1.1rem;
      border-radius: 50px;
      transition: all 0.3s ease;
      font-weight: bold;
      min-width: 180px;
    }

    .btn-danger {
      background-color: #e53935;
      border: none;
    }
    .btn-danger:hover {
      background-color: #b71c1c;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
    }
    .btn-secondary:hover {
      background-color: #495057;
    }

    .btn-dark {
      background-color: #343a40;
      border: none;
    }
    .btn-dark:hover {
      background-color: #1d2124;
    }

    .btn-warning {
      background-color: #f0ad4e;
      border: none;
      color: white;
    }
    .btn-warning:hover {
      background-color: #ec971f;
    }

    .btn-success {
      background-color: #28a745;
      border: none;
      color: white;
    }
    .btn-success:hover {
      background-color: #1e7e34;
    }

    .btn-info {
      background-color: #17a2b8;
      border: none;
      color: white;
    }
    .btn-info:hover {
      background-color: #117a8b;
    }

    .row-gap {
      row-gap: 20px;
    }
  </style>
</head>
<body>
  <div class="home-box">
    <h1>Blood Bank Management System</h1>

    <!-- Admin Login Button -->
    <div class="d-flex justify-content-center mb-4">
      <a href="admin_login.php" class="btn btn-dark btn-custom">Admin Login</a>
    </div>

    <!-- First Row -->
    <div class="d-flex flex-wrap justify-content-center row-gap column-gap-3 mb-3">
      <a href="donor_register.php" class="btn btn-danger btn-custom">Register as Donor</a>
      <a href="donor_list.php" class="btn btn-secondary btn-custom">View Donors</a>
      <a href="blood_request_list.php" class="btn btn-warning btn-custom">Request Blood</a>
    </div>

    <!-- Second Row -->
    <div class="d-flex flex-wrap justify-content-center column-gap-3">
      <a href="add_stock.php" class="btn btn-success btn-custom">Add Stock</a>
      <a href="manage_blood_request.php" class="btn btn-info btn-custom">Manage Requests</a>
    </div>
  </div>
</body>
</html>
