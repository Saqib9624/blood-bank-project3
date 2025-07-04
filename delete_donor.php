<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM donor WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: donor_list.php?deleted=1");
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Failed to delete donor: " . $stmt->error . "</div>";
    }

    $stmt->close();
} else {
    header("Location: donor_list.php");
    exit;
}
?>
