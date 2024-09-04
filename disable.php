<?php
// disable or enable user
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once 'DbConnect.php';
  $sql = "SELECT * FROM user WHERE user_id =" . $_GET['id'] . " AND (is_staff = true or is_customer = true);";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $sql2 = "UPDATE user SET is_active = true WHERE user_id = " . $_GET['id'] . " AND (is_staff = true or is_customer = true);";
    if ($row['is_active']) {
      $sql2 = "UPDATE user SET is_active = false WHERE user_id = " . $_GET['id'] . ";";
    }
    echo $sql2;
    $conn->query($sql2);
  }
  header("Location:admin.php");
  exit();
}
