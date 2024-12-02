<?php
session_start();
session_destroy();
header("Location: account2.php");
