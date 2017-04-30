<?php
 
$client = new Mosquitto\Client();
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');
$client->connect("172.18.38.137", 1883, 60);
$client->subscribe('/ble/rssi/', 1);
 
 
while (true) {
        $client->loop();
        sleep(2);
}
 
$client->disconnect();
unset($client);
 
function connect($r) {
        echo "I got code {$r}\n";
}
 
function subscribe() {
        echo "Subscribed to a topic\n";
}
 
function message($message) {
        printf("\nGot a message on topic %s with payload:%s", 
                $message->topic, $message->payload);

        $url = 'http://phf.garrettiam.com/btInput.php';

        $ch = curl_init($url);

        $jsonDataEncoded = $message->payload;

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

        $result = curl_exec($ch);
}
 
function disconnect() {
        echo "Disconnected cleanly\n";
}
?>
