<?php
  setcookie("ID_site","", time() - 1);
  header("Location: login.php");
?>