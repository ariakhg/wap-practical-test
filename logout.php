<?php
require 'config/connection.php';

session_destroy();
header("Location: index.html")
?>