<?php
session_start();
session_destroy();
echo "<script>
localStorage.removeItem('coxylUser');
window.location.href='login.html';
</script>";
exit();
?>
