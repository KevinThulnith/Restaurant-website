<?php
if (!isset($_SESSION['username'])) {
  echo "<li><a href='login.php'>Login</a></li>
        <li><a href='singUp.php'>Sing Up</a></li>
        <li><a href='resetPassword.php'>Reset password</a></li>";
} else {
  if (isset($_COOKIE['user_data'])) {
    // Decode the JSON string back to an array
    $user_data = json_decode($_COOKIE['user_data'], true);
    $name = $user_data['name'];
    $is_admin = $user_data['is_admin'];
    echo "<h4>Hey $name,</h4>
          <li><a href='reservation.php'>My Resavations</a></li>
          <li><a href='#'>My Orders</a></li>      
          <li><a href='logout.php'>Logout</a></li>";

    if ($is_admin) {
      echo "<li><a href='admin.php'>Admin panal</a></li>";
      echo "<li><a href='addfood.php'>Add Menu Item</a></li>";
    }
  }
}
