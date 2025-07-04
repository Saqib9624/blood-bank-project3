<?php
include 'db.php';

$message = '';

// Handle form submission to update stock
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = $_POST['blood_group'] ?? '';
    $units = intval($_POST['units'] ?? 0);

    if ($blood_group && $units > 0) {
        $stmt = $conn->prepare("UPDATE stock SET units = units + ? WHERE blood_group = ?");
        $stmt->bind_param("is", $units, $blood_group);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1&units=$units&group=" . urlencode($blood_group));
            exit;
        } else {
            $message = "Error updating stock: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Please select a blood group and enter valid units.";
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $units = intval($_GET['units'] ?? 0);
    $group = htmlspecialchars($_GET['group'] ?? '');
    $message = "✅ Successfully added <strong>$units</strong> unit(s) to <strong>$group</strong>.";
}

$stock_result = $conn->query("SELECT * FROM stock ORDER BY blood_group");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Blood Stock</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #f43b47, #453a94);
      min-height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 15px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .stock-card {
      background-color: #ffffff;
      border-radius: 20px;
      padding: 40px;
      max-width: 550px;
      width: 100%;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    h2 {
      font-weight: 700;
      color: #453a94;
      margin-bottom: 25px;
      text-align: center;
    }

    .form-label {
      font-weight: 600;
      color: #333;
    }

    .form-select, .form-control {
      border-radius: 12px;
      border: 1.5px solid #ccc;
      box-shadow: none;
      transition: border-color 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
      border-color: #f43b47;
      box-shadow: 0 0 8px rgba(244, 59, 71, 0.3);
    }

    .btn-add {
      background: #f43b47;
      border: none;
      padding: 12px;
      font-weight: 600;
      color: #fff;
      border-radius: 30px;
      width: 100%;
      transition: background 0.3s ease;
    }

    .btn-add:hover {
      background: #d7323a;
    }

    .table th {
      background-color: #453a94;
      color: white;
      font-weight: 600;
    }

    .table td, .table th {
      vertical-align: middle;
    }

    .alert {
      border-radius: 12px;
      padding: 12px 20px;
      font-weight: 500;
      text-align: center;
    }

    .btn-back {
      background: #453a94;
      color: white;
      border-radius: 30px;
      padding: 10px 25px;
      display: block;
      text-align: center;
      text-decoration: none;
      margin-top: 30px;
      font-weight: 600;
    }

    .btn-back:hover {
      background-color: #342a72;
    }
  </style>
</head>
<body>

<div class="stock-card">
  <h2>Manage Blood Stock</h2>

  <?php if ($message): ?>
    <div class="alert alert-info"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST" class="mb-4">
    <div class="mb-3">
      <label for="blood_group" class="form-label">Blood Group</label>
      <select class="form-select" name="blood_group" required>
        <option value="" disabled selected>Select Blood Group</option>
        <?php
          $groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
          foreach ($groups as $group) {
              echo "<option value=\"$group\">$group</option>";
          }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="units" class="form-label">Units to Add</label>
      <input type="number" class="form-control" name="units" min="1" required placeholder="Enter number of units">
    </div>

    <button type="submit" class="btn-add">Add to Stock</button>
  </form>

  <h5 class="text-center fw-bold text-primary mb-3">Current Stock</h5>
  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>Blood Group</th>
        <th>Units Available</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $stock_result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['blood_group']) ?></td>
          <td><?= intval($row['units']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="admin_dashboard.php" class="btn-back mt-4">← Back to Dashboard</a>
</div>

</body>
</html>
