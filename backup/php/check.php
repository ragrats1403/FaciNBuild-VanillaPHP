<?php
if (!isset($_SESSION['user'])) {
  echo 'Unauthorised';
  exit();
}
?>