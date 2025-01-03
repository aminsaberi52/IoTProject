<?php
    define('DB_HOST','localhost');
    define('DB_USER','user-name');
    define('DB_PASS','pass');
    define('DB_NAME','db-name');

  $pdo_conn = new PDO( 'mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS );

  $stmt = $pdo_conn->prepare("SELECT * FROM arduino");
  $stmt->execute();
  $res = $stmt->fetchAll();
  echo $res[0]["led"];
?>

