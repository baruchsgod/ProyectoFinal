<?php
session_start();
session_destroy();

header("Location:index.php"); //logs out, destroy the session and heads to index.php

?>
