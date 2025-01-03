<?php
    define('DB_HOST','localhost');
    define('DB_USER','user-name');
    define('DB_PASS','pass');
    define('DB_NAME','db-name');

    define('BOT_TOKEN','5830207024:AAHQ8iHk-a1C1WxkgOQ2x1TNScVo1tb2dyA');
    define('API_URL','https://api.telegram.org/bot'.BOT_TOKEN.'/');
    // Bot Name: @https://t.me/arduino1221bot
    // WebHock: https://api.telegram.org/bot5830207024:AAHQ8iHk-a1C1WxkgOQ2x1TNScVo1tb2dyA/setwebhook?url=https://freelancerishoo.ir/set-data.php

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
        if(isset($_GET['ontime'])){
            $stmt = $pdo_conn->prepare("UPDATE arduino SET ontime='" . $_GET['ontime'] . "'");
            $res = $stmt->execute();
        }
        if(isset($_GET['offtime'])){
            $stmt = $pdo_conn->prepare("UPDATE arduino SET offtime='" . $_GET['offtime'] . "'");
            $res = $stmt->execute();
        }
    }else{
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);

        $text = $update["message"]['text'];

        if(strstr($text, '/ledon')){
            $stmt = $pdo_conn->prepare("UPDATE arduino SET led='ON'");
            $res = $stmt->execute();
        }
        if(strstr($text, '/ledoff')){
            $stmt = $pdo_conn->prepare("UPDATE arduino SET led='OFF'");
            $res = $stmt->execute();
        }
        if(strstr($text, '/ontime')){
            $ontimeval = substr($text,strlen('/ontime') , strlen($text));
            $stmt = $pdo_conn->prepare("UPDATE arduino SET ontime='" . $ontimeval . "'");
            $res = $stmt->execute();
        }
        if(strstr($text, '/offtime')){
            $ontimeval = substr($text,strlen('/offtime') , strlen($text));
            $stmt = $pdo_conn->prepare("UPDATE arduino SET offtime='" . $ontimeval . "'");
            $res = $stmt->execute();
        }
    } 

    $stmt = $pdo_conn->prepare("SELECT * FROM arduino");
    $stmt->execute();
    $res = $stmt->fetchAll();
    $led_state = $res[0]["led"];
    $led_off_time = $res[0]["offtime"];
    $led_on_time = $res[0]["ontime"];
?>
<html dir="rtl">
    <body>
        <div style="text-align: center; padding: 50px 0px;">
            وضعیت رله و ال ای دی : 
            <?php echo $led_state; ?>
        </div>
        <div style="text-align: center; padding: 50px 0px;">
            مدت زمان خاموش ماندن رله و ال ای دی : 
            <?php echo $led_off_time; ?>
        </div>
        <div style="text-align: center; padding: 50px 0px;">
        مدت زمان روشن ماندن رله و ال ای دی : 
            <?php echo $led_on_time; ?>
        </div>
        <div style="text-align: center;">
            <a style=" padding: 8px 40px; border: 2px solid black; border-radius: 5px; margin: 10px;" 
            href = '/set-data.php?led=ON'> ON </a>
            <a style=" padding: 8px 40px; border: 2px solid black; border-radius: 5px; margin: 10px;" 
            href = '/set-data.php?led=OFF'> OFF </a>           
        </div>
        <form action="set-data.php" method="get" class="form-example">
            <input type="text" name="led" value="<?php echo $led_state; ?>" hidden><br><br>
            <label for="ontime">Time(ms) on: </label>
            <input type="text" name="ontime" id="ontime" required><br><br>
            <label for="offtime">Time(ms) off: </label>
            <input type="text" name="offtime" id="offtime" required><br><br>
            <input type="submit" value="Send">
        </form>
    </body>
</html>


