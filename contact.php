<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">Contact Us</h2>

  <?php
  // Connect to database
   $db_server = 'localhost';
   $db_username = 'root';
   $db_password = '';
   $db_name = 'mywebsite_db';
   
  $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $conn->real_escape_string($_POST['name']);
      $email = $conn->real_escape_string($_POST['email']);
      $message = $conn->real_escape_string($_POST['message']);

      $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
      
      if ($conn->query($sql) === TRUE) {
          echo "<div class='alert alert-success'>Message sent successfully!</div>";
      } else {
          echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
      }
  }
  ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="message" class="form-label">Message</label>
      <textarea name="message" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary w-100">Send Message</button>
  </form>
</div>
    
</body>
</html>