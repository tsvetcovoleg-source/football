<?php
// Basic application settings. Edit these values after uploading to shared hosting.
define('DB_HOST', 'localhost');
define('DB_NAME', 'football_predictions');
define('DB_USER', 'root');
define('DB_PASS', '');
define('APP_TIMEZONE', 'Europe/Chisinau');

// Keep all PHP date operations in the contest timezone.
date_default_timezone_set(APP_TIMEZONE);
