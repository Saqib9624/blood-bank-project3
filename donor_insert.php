<?php
include 'db.php';

$message = '';
$message_class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? '';
    $group = $_POST['blood_group'] ?? '';
    $city = trim($_POST['city'] ?? '');
    $hospital = trim($_POST['hospital'] ?? '');
    $contact = trim($_POST['contact'] ?? '');

    if ($name === '' || $age <= 0 || $gender === '' || $group === '' || $city === '' || $contact === '') {
        $message = 'Please fill all the required fields correctly.';
        $message_class = 'alert-warning';
    } else {
        $stmt = $conn->prepare("INSERT INTO donor (name, age, gender, blood_group, city, hospital, contact) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssss", $name, $age, $gender, $group, $city, $hospital, $contact);

        if ($stmt->execute()) {
            $message = 'Donor Registered Successfully!';
            $message_class = 'alert-success';
            // Clear form
            $name = $age = $gender = $group = $city = $hospital = $contact = '';
        } else {
            $message = 'Error: ' . htmlspecialchars($stmt->error);
            $message_class = 'alert-danger';
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Donor - Blood Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #ff4e50, #f9d423);
      min-height: 100vh;
    }
    .form-container {
      background: white;
      border-radius: 15px;
      padding: 30px;
      max-width: 600px;
      margin: 50px auto;
      box-shadow: 0 8px 25px rgb(0 0 0 / 0.15);
    }
    h2 {
      font-weight: 700;
      color: #d32f2f;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    }
    label {
      font-weight: 600;
    }
    .btn-danger {
      background: #d32f2f;
      border: none;
    }
    .btn-danger:hover {
      background: rgb(177, 37, 37);
    }
  </style>
</head>
<body>

<div class="form-container shadow-lg">
    <h2 class="text-center mb-4">Register New Donor</h2>

    <?php if ($message): ?>
        <div class="alert <?= $message_class ?> text-center" role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Donor Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($name ?? '') ?>" required placeholder="Enter full name" />
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" id="age" name="age" class="form-control" min="18" max="65" value="<?= htmlspecialchars($age ?? '') ?>" required />
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Gender</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="male" name="gender" value="Male" <?= (isset($gender) && $gender === 'Male') ? 'checked' : '' ?> required />
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="female" name="gender" value="Female" <?= (isset($gender) && $gender === 'Female') ? 'checked' : '' ?> required />
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="blood_group" class="form-label">Blood Group</label>
            <select id="blood_group" name="blood_group" class="form-select" required>
                <option value="" <?= empty($group) ? 'selected' : '' ?>>Select Blood Group</option>
                <?php
                $groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                foreach ($groups as $g) {
                    $sel = ($group === $g) ? 'selected' : '';
                    echo "<option value=\"$g\" $sel>$g</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars($city ?? '') ?>" required />
        </div>

        <div class="mb-3">
            <label for="hospital" class="form-label">Hospital (Optional)</label>
            <input type="text" id="hospital" name="hospital" class="form-control" value="<?= htmlspecialchars($hospital ?? '') ?>" />
        </div>

        <div class="mb-4">
            <label for="contact" class="form-label">Contact Number</label>
            <input type="tel" id="contact" name="contact" class="form-control" placeholder="+92XXXXXXXXXX" pattern="^\+92\d{10}$" value="<?= htmlspecialchars($contact ?? '') ?>" required />
        </div>

        <button type="submit" class="btn btn-danger w-100">Add Donor</button>
    </form>

    <div class="text-center mt-3">
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
