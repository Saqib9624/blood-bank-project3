<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db.php';

// Stats
$total_donors = $conn->query("SELECT COUNT(*) as total FROM donors")->fetch_assoc()['total'];
$total_requests = $conn->query("SELECT COUNT(*) as total FROM blood_requests")->fetch_assoc()['total'];
$total_approved = $conn->query("SELECT COUNT(*) as total FROM blood_requests WHERE status = 'Approved'")->fetch_assoc()['total'];
$total_stock = $conn->query("SELECT SUM(units) as total FROM stock")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - Blood Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .dashboard-card {
        border-radius: 1rem;
        color: white;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    .card-donors { background: #6f42c1; }
    .card-requests { background: #fd7e14; }
    .card-approved { background: #198754; }
    .card-stock { background: #0d6efd; }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <h1 class="text-center text-primary mb-5">Admin Dashboard</h1>

  <div class="row text-center g-4 mb-4">
    <div class="col-md-3">
      <div class="dashboard-card card-donors">
        <h5>Total Donors</h5>
        <h2><?= $total_donors ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-card card-requests">
        <h5>Total Requests</h5>
        <h2><?= $total_requests ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-card card-approved">
        <h5>Approved Requests</h5>
        <h2><?= $total_approved ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-card card-stock">
        <h5>Total Stock (Units)</h5>
        <h2><?= $total_stock ?? 0 ?></h2>
      </div>
    </div>
  </div>

  <div class="text-center mb-3">
    <a href="add_stock.php" class="btn btn-primary btn-lg m-2">Manage Blood Stock</a>
    <a href="blood_request_list.php" class="btn btn-warning btn-lg m-2">Manage Requests</a>
    <a href="donor_list.php" class="btn btn-success btn-lg m-2">View Donors</a>
    <a href="logout.php" class="btn btn-danger btn-lg m-2">Logout</a>
  </div>
</div>
</body>
</html>
