<?php
session_start();
//BD
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'les-oasis');

//URL Basic
define("BURL", "http://127.0.0.1/les_oasis/");
//URL Admin
define("BURLA", "http://127.0.0.1/les_oasis/admin/");
//URL Assets
define("ASSETS", "http://127.0.0.1/les_oasis/assets/");
//Link basic
define("BL", __DIR__ . '/');
//Link basic admin
define("BLA", __DIR__ . '/admin/');


//connection BD
require_once(BL . 'functions/db.php');
