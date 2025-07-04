<?php
include 'db.php';

$message = '';

// Process Approve, Reject, Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'], $_POST['id'])) {
        $id = intval($_POST['id']);
        $action = $_POST['action'];

        $requestStmt = $conn->prepare("SELECT blood_group, units, status FROM blood_request WHERE id = ?");
        $requestStmt->bind_param("i", $id);
        $requestStmt->execute();
        $requestResult = $requestStmt->get_result();

        if ($requestResult->num_rows === 0) {
            $message = "Request not found.";
        } else {
            $request = $requestResult->fetch_assoc();

            if ($action === 'approve' && $request['status'] === 'Pending') {
                $stockStmt = $conn->prepare("SELECT units FROM stock WHERE blood_group = ?");
                $stockStmt->bind_param("s", $request['blood_group']);
                $stockStmt->execute();
                $stockResult = $stockStmt->get_result();

                if ($stockResult->num_rows > 0) {
                    $stock = $stockResult->fetch_assoc();
                    if ($stock['units'] >= $request['units']) {
                        $newUnits = $stock['units'] - $request['units'];
                        $updateStockStmt = $conn->prepare("UPDATE stock SET units = ? WHERE blood_group = ?");
                        $updateStockStmt->bind_param("is", $newUnits, $request['blood_group']);
                        $updateStockStmt->execute();

                        $updateRequestStmt = $conn->prepare("UPDATE blood_request SET status = 'Approved' WHERE id = ?");
                        $updateRequestStmt->bind_param("i", $id);
                        $updateRequestStmt->execute();

                        $message = "Request approved and stock updated.";
                    } else {
                        $message = "Not enough stock to approve this request.";
                    }
                    $stockStmt->close();
                } else {
                    $message = "Stock info not found for blood group.";
                }
            } elseif ($action === 'reject' && $request['status'] === 'Pending') {
                $updateRequestStmt = $conn->prepare("UPDATE blood_request SET status = 'Rejected' WHERE id = ?");
                $updateRequestStmt->bind_param("i", $id);
                $updateRequestStmt->execute();
                $message = "Request rejected.";
            } elseif ($action === 'delete') {
                $deleteStmt = $conn->prepare("DELETE FROM blood_request WHERE id = ?");
                $deleteStmt->bind_param("i", $id);
                $deleteStmt->execute();
                $message = "Request deleted.";
            } else {
                $message = "Invalid action or request already processed.";
            }
        }
        $requestStmt->close();
    }
}

$result = $conn->query("SELECT * FROM blood_request ORDER BY request_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Blood Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  body {
    background: linear-gradient(135deg, #ff4e50, #f9d423);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 12px 25px rgba(255, 78, 80, 0.35);
  }
  h2 {
    font-weight: 700;
    letter-spacing: 1.5px;
    background: linear-gradient(90deg, #ff416c, #ff4b2b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  table {
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }
  thead.table-dark {
    background: #ff4b2b;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  tbody tr:nth-child(odd) {
    background: #fff0f0;
  }
  tbody tr:hover {
    background: #ffd6d1 !important;
  }
  .badge {
    font-size: 0.9em;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }
  .badge.bg-success {
    background-color: #28a745;
  }
  .badge.bg-danger {
    background-color: #dc3545;
  }
  .badge.bg-warning {
    background-color: #ffc107;
    color: #212529;
  }
  button.btn {
    border-radius: 50px;
    transition: all 0.3s ease;
    font-weight: 600;
    padding: 6px 18px;
  }
  button.btn-success {
    background: linear-gradient(45deg, #28a745, #218838);
    border: none;
  }
  button.btn-success:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
  }
  button.btn-warning {
    background: linear-gradient(45deg, #ffc107, #e0a800);
    border: none;
    color: #212529;
  }
  button.btn-warning:hover {
    background: linear-gradient(45deg, #e0a800, #c69500);
  }
  button.btn-danger {
    background: linear-gradient(45deg, #dc3545, #b02a37);
    border: none;
  }
  button.btn-danger:hover {
    background: linear-gradient(45deg, #b02a37, #8a2028);
  }
  button.btn-secondary {
    background: #6c757d;
    border: none;
  }
  button.btn-secondary:hover {
    background: #5a6268;
  }
  .alert-info {
    background: #ffe9e8;
    border-color: #ff4b2b;
    color: #a1281f;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(255, 75, 43, 0.4);
  }
  a.btn-secondary {
    border-radius: 50px;
    padding: 8px 25px;
    font-weight: 600;
  }
</style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Blood Requests</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <table class="table table-hover table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Contact</th>
                <th>Request Date</th>
                <th>Status</th>
                <th style="min-width: 240px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows === 0): ?>
                <tr><td colspan="8" class="text-center">No blood requests found.</td></tr>
            <?php else: ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['blood_group']) ?></td>
                        <td><?= intval($row['units']) ?></td>
                        <td><?= htmlspecialchars($row['contact']) ?></td>
                        <td><?= htmlspecialchars($row['request_date']) ?></td>
                        <td>
                            <?php
                            $statusClass = match ($row['status']) {
                                'Approved' => 'badge bg-success',
                                'Rejected' => 'badge bg-danger',
                                default => 'badge bg-warning text-dark',
                            };
                            ?>
                            <span class="<?= $statusClass ?>"><?= $row['status'] ?></span>
                        </td>
                        <td>
                            <?php if ($row['status'] === 'Pending'): ?>
                                <form method="post" style="display:inline-block;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm" onclick="return confirm('Approve this request?')">Approve</button>
                                </form>

                                <form method="post" style="display:inline-block; margin-left: 5px;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="action" value="reject" class="btn btn-warning btn-sm" onclick="return confirm('Reject this request?')">Reject</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>No actions</button>
                            <?php endif; ?>

                            <form method="post" style="display:inline-block; margin-left: 5px;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Delete this request?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
