<?php

if (!isset($_COOKIE['hub'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit();
}