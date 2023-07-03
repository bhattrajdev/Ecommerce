<?php
  if (!empty($_SESSION['name']) && !empty($_SESSION['email'])) {
    session_destroy();
  }
  header('location:index.php');