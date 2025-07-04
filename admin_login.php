<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - Blood Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      padding: 2rem;
    }
    .form-title {
      font-weight: bold;
      font-size: 24px;
      color: #343a40;
    }
    .btn-custom {
      background: #2575fc;
      color: white;
      font-weight: bold;
      border: none;
      transition: background 0.3s ease-in-out;
    }
    .btn-custom:hover {
      background: #1a5fd0;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-card w-100" style="max-width: 400px;">
      <h3 class="text-center form-title mb-4">Admin Login</h3>
      <form method="post" action="admin_dashboard.php">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
        </div>
        <button type="submit" class="btn btn-custom w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
