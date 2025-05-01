<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}
$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting...</title>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          var user = "<?php echo htmlspecialchars($username); ?>";
          localStorage.setItem('coxylUser', user);
          window.location.href = "index.html"; // After setting username, send to home page
      });
    </script>
</head>
<body>
    Redirecting to homepage...
</body>
</html>
