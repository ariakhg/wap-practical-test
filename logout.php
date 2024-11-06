<?php
require 'config/connection.php';

// Destroys session and redirects
session_destroy();
header("Location: index.html")
?>