<?php
include 'db.php';

// Search filter (optional)
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM donor";
if (!empty($search)) {
    $query .= " WHERE blood_group LIKE '%$search%'";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Donors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            font-family: Arial, sans-serif;
            padding: 40px 15px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            color: #d6336c;
            margin-bottom: 30px;
        }

        .search-box {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .search-box input[type="text"] {
            width: 60%;
            border-radius: 25px 0 0 25px;
            border: 2px solid #d6336c;
            padding: 10px 20px;
            outline: none;
        }

        .search-box button {
            border-radius: 0 25px 25px 0;
            background-color: #d6336c;
            border: none;
            color: #fff;
            padding: 10px 25px;
            font-weight: bold;
        }

        .table thead {
            background-color: #d6336c;
            color: white;
        }

        .btn-danger {
            padding: 5px 12px;
            font-size: 0.85rem;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registered Donors</h2>

    <!-- Success message -->
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Donor deleted successfully.</div>
    <?php endif; ?>

    <!-- Search -->
    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search Blood Group" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>City</th>
                    <th>Hospital</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['gender']) . "</td>
                            <td>" . intval($row['age']) . "</td>
                            <td>" . htmlspecialchars($row['blood_group']) . "</td>
                            <td>" . htmlspecialchars($row['city']) . "</td>
                            <td>" . (!empty($row['hospital']) ? htmlspecialchars($row['hospital']) : 'N/A') . "</td>
                            <td>
                                <form method='POST' action='delete_donor.php' onsubmit='return confirm(\"Are you sure you want to delete this donor?\");'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "' />
                                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No donors found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
