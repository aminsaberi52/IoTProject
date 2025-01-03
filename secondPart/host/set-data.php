<?php
    define('DB_HOST','localhost');
    define('DB_USER','user-name');
    define('DB_PASS','pass');
    define('DB_NAME','db-name');

    $pdo_conn = new PDO( 'mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS );
    
    if(isset($_GET['led'])){
        if(strstr($_GET['led'], "ON")){
            $stmt = $pdo_conn->prepare("UPDATE arduino SET led='ON'");
            $res = $stmt->execute();
        }
        if(strstr($_GET['led'], "OFF")){
            $stmt = $pdo_conn->prepare("UPDATE arduino SET led='OFF'");
            $res = $stmt->execute();
        }
    } 

    $stmt = $pdo_conn->prepare("SELECT * FROM arduino");
    $stmt->execute();
    $res = $stmt->fetchAll();
    $led_state = $res[0]["led"];
?>
<html dir="rtl">
    <body>
        <div style="text-align: center; padding: 50px 0px;">
            وضعیت رله و ال ای دی : 
            <?php echo $led_state; ?>
        </div>
        <div style="text-align: center;">
            <a style=" padding: 8px 40px; border: 2px solid black; border-radius: 5px; margin: 10px;" 
            href = '/set-data.php?led=ON'> ON </a>
            <a style=" padding: 8px 40px; border: 2px solid black; border-radius: 5px; margin: 10px;" 
            href = '/set-data.php?led=OFF'> OFF </a>           
        </div>
    </body>
</html>


