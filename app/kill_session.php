<?php
  session_start();

  session_destroy();

  header('Content-Type: text/html');
  echo "<!DOCTYPE html>"
  . "<html>"
  . "<head><meta charset=\"utf-8\"></head>"
  . "<body>"
  . "session close successfully."
  . "</body>"
  . "</html>";
?>