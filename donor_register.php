<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Donor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #ff4e50, #f9d423);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .registration-container {
      background: #fff;
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 10px 30px rgba(255, 78, 80, 0.3);
      max-width: 420px;
      width: 100%;
    }
    h2 {
      color: #c62828;
      font-weight: 700;
      text-align: center;
      margin-bottom: 30px;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      text-shadow: 1px 1px 3px rgba(198, 40, 40, 0.6);
    }
    input.form-control, select.form-control {
      border-radius: 50px;
      padding: 12px 20px;
      font-size: 1rem;
      border: 2px solid #f9d423;
      box-shadow: 0 3px 10px rgba(249, 212, 35, 0.3);
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    input.form-control:focus, select.form-control:focus {
      outline: none;
      border-color: #c62828;
      box-shadow: 0 0 8px rgba(198, 40, 40, 0.6);
    }
    input[type="submit"] {
      border-radius: 50px;
      background: #c62828;
      border: none;
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
      padding: 12px;
      width: 100%;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(198, 40, 40, 0.5);
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background: #b71c1c;
    }
    .gender-group {
      border: 2px solid #f9d423;
      border-radius: 50px;
      padding: 10px 20px;
      margin-bottom: 1rem;
      box-shadow: 0 3px 10px rgba(249, 212, 35, 0.3);
    }
    .gender-group label {
      margin-right: 15px;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="registration-container">
    <h2>Donor Registration</h2>
    <form action="donor_insert.php" method="post" autocomplete="off">
      <input type="text" name="name" class="form-control mb-4" placeholder="Donor Name" required />
      
      <input type="number" name="age" class="form-control mb-4" placeholder="Age" min="18" max="65" required />
      
      <div class="gender-group d-flex align-items-center justify-content-between">
        <label><input type="radio" name="gender" value="Male" required> Male</label>
        <label><input type="radio" name="gender" value="Female" required> Female</label>
      </div>
      
      <select name="blood_group" class="form-control mb-4" required>
        <option value="" disabled selected>Select Blood Group</option>
        <option value="A+">A+</option><option value="A-">A-</option>
        <option value="B+">B+</option><option value="B-">B-</option>
        <option value="O+">O+</option><option value="O-">O-</option>
        <option value="AB+">AB+</option><option value="AB-">AB-</option>
      </select>

      <input type="text" name="city" class="form-control mb-4" placeholder="City" required />

      <input type="text" name="hospital" class="form-control mb-4" placeholder="Hospital (Optional)" />

      <input type="tel" name="contact" class="form-control mb-4" placeholder="Contact Number (e.g. +92XXXXXXXXXX)" pattern="^\+92\d{10}$" required />

      <input type="submit" value="Register" />
    </form>
  </div>
</body>
</html>
