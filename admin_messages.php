<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - View Messages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4 text-center">Submitted Messages</h2>

  <?php
  session_start();
  $conn = new mysqli('localhost', 'root', '', 'mywebsite_db');

  // Handle delete request
  if (isset($_GET['delete'])) {
      $id = intval($_GET['delete']);
      $conn->query("DELETE FROM contact_messages WHERE id = $id");

      $_SESSION['deleted'] = "Message deleted successfully!";
      header("Location: " . $_SERVER['PHP_SELF']); // redirect to clear query string
      exit();
  }

  // Show message (if any) once
  if (isset($_SESSION['deleted'])) {
    echo "<div id='deleted-alert' class='alert alert-danger'>" . $_SESSION['deleted'] . "</div>";
      unset($_SESSION['deleted']);
  }

  $result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
  ?>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
        <td><?= $row['submitted_at'] ?></td>
        <td>
          <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
             onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
<script>
  // Auto-hide any alert (success or error) after 3 seconds
  document.addEventListener('DOMContentLoaded', function() {
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
      setTimeout(function() {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(function() { if (alert && alert.parentNode) alert.parentNode.removeChild(alert); }, 500);
      }, 2000);
    });
  });
</script>
</body>
</html>
