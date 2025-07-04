<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Success - Blood Request</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f44336, #e57373);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .success-box {
      background: #fff;
      padding: 50px 40px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }
    .success-box i {
      font-size: 60px;
      color: #4caf50;
      margin-bottom: 20px;
    }
    .success-box h2 {
      color: #4caf50;
      font-weight: bold;
      margin-bottom: 15px;
    }
    .success-box p {
      font-size: 18px;
      color: #555;
    }
    .btn-home {
      margin-top: 30px;
      background-color: #f44336;
      border: none;
      color: white;
      font-weight: bold;
      padding: 12px 25px;
      border-radius: 30px;
      transition: background 0.3s ease;
      text-transform: uppercase;
    }
    .btn-home:hover {
      background-color: #d32f2f;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <i class="fas fa-check-circle"></i>
    <h2>Request Submitted!</h2>
    <p>Your blood request has been sent successfully. Our team will contact you shortly.</p>
    <a href="index.php" class="btn btn-home">Back to Home</a>
  </div>
</body>
</html>
