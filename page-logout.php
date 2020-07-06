<?php
session_start();
unset($_SESSION['nama']);
unset($_SESSION['email']);
unset($_SESSION['id']);
session_unset();
session_destroy();
header("Location: ../");
