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
  session_start();
  $db_host = 'localhost';
  $db_user = 'root';
    $db_pass = '';
    $db_name = 'mywebsite_db';

  $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $conn->real_escape_string($_POST['name']);
      $email = $conn->real_escape_string($_POST['email']);
      $message = $conn->real_escape_string($_POST['message']);

      $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
      
      if ($conn->query($sql) === TRUE) {
          $_SESSION['success'] = "Message sent successfully!";
      } else {
          $_SESSION['error'] = "Error: " . $conn->error;
      }

      // Redirect to clear form data & messages on reload
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
  }

  // Show feedback if set
  if (isset($_SESSION['success'])) {
    echo "<div id='success-alert' class='alert alert-success'>" . $_SESSION['success'] . "</div>";
      unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
    echo "<div id='error-alert' class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
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
<script>
  // Auto-hide the success alert after 3 seconds (3000 ms)
  document.addEventListener('DOMContentLoaded', function() {
    var success = document.getElementById('success-alert');
    if (success) {
      // Give a short fade-out transition then remove the element
      setTimeout(function() {
        success.style.transition = 'opacity 0.5s ease';
        success.style.opacity = '0';
        setTimeout(function() { if (success && success.parentNode) success.parentNode.removeChild(success); }, 500);
      }, 2000);
    }
  });
</script>
</body>
</html>
