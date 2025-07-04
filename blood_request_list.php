<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $blood_group = $_POST['blood_group'] ?? '';
    $units = intval($_POST['units'] ?? 0);
    $contact = $_POST['contact'] ?? '';

    if ($name && $gender && $blood_group && $units > 0 && $contact) {
        // Check stock availability
        $check = $conn->prepare("SELECT units FROM stock WHERE blood_group = ?");
        $check->bind_param("s", $blood_group);
        $check->execute();
        $check->bind_result($available_units);
        $check->fetch();
        $check->close();

        if ($available_units >= $units) {
            $status = 'Approved';
            $update_stock = $conn->prepare("UPDATE stock SET units = units - ? WHERE blood_group = ?");
            $update_stock->bind_param("is", $units, $blood_group);
            $update_stock->execute();
            $update_stock->close();
        } else {
            $status = 'Rejected';
        }

        $insert = $conn->prepare("INSERT INTO blood_request (name, gender, blood_group, units, contact, status) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssiss", $name, $gender, $blood_group, $units, $contact, $status);
        if ($insert->execute()) {
            $message = "Blood request submitted successfully with status: $status.";
        } else {
            $message = "Error: " . $insert->error;
        }
        $insert->close();
    } else {
        $message = "Please fill all the fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Request Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: #fff;
        }
        .form-container {
            background-color: #f8f9fa;
            color: #212529;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }
        .title {
            color: #f87171;
            font-size: 2.2rem;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #f87171;
            color: #fff;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #dc2626;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center title mb-4">Request Blood</h2>

    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="form-container mx-auto w-100" style="max-width: 600px;">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Patient Name</label>
                <input type="text" name="name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Blood Group</label>
                <select name="blood_group" class="form-select" required>
                    <option value="">Select</option>
                    <?php
                    $groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                    foreach ($groups as $group) {
                        echo "<option value=\"$group\">$group</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Units Required</label>
                <input type="number" name="units" class="form-control" min="1" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-custom w-100">Submit Request</button>
        </form>

        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-outline-secondary">← Back to Home</a>
        </div>
    </div>
</div>
</body>
</html>
