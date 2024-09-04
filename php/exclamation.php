<?php
session_start();
if (!isset($_SESSION['username'])) echo "<i class='fa fa-exclamation-circle'></i>";
