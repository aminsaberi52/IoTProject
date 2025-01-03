#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

const char *ssid = "Xiaomi11TPro";
const char *password =  "#123456789#";
const char *host = "http://freelancerishoo.ir/get-data.php";

const int LedRelayPin = 5;

void setup() {
  Serial.begin(115200);
  pinMode(LedRelayPin, OUTPUT);
  pinMode(LED_BUILTIN, OUTPUT);     // Initialize the LED_BUILTIN pin as an output
  
  digitalWrite(LedRelayPin, LOW);
  digitalWrite(LED_BUILTIN, LOW);
    
  WiFi.mode(WIFI_OFF); 
  delay(1000);
  WiFi.mode(WIFI_STA); //WiFi Station Mode default mode is both station and acccess point modes

  //connect to WIFI network
  Serial.println(); Serial.println(); Serial.print("Connecting to "); Serial.println(ssid);
  WiFi.begin(ssid, password); //connecting to router
  Serial.println(""); Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);

  
}
void loop() {
  WiFiClient client;
  HTTPClient http;
  //String postingData = "names=test&age=43" ;
  String postingData = "" ;
  http.begin(client , host);
  http.addHeader("Content-Type" , "application/x-www-form-urlencoded");
  
  int httpCode = http.POST(postingData);   //Sending the request
  String payload = http.getString();   //Get the response payload
  //Serial.println(httpCode);          //Print HTTP return code(200)
  Serial.println(payload);             //printing the respose from the submitted data
  payload.trim();
  Serial.println(payload.length());
  if(payload.equals("ON")){
    digitalWrite(LED_BUILTIN, LOW);
    digitalWrite(LedRelayPin, LOW);
  }
  if(payload.equals("OFF")){
    digitalWrite(LED_BUILTIN, HIGH);
    digitalWrite(LedRelayPin, HIGH);
  }
  http.end();                          //Close connection
  
  delay(4000);                         //Looping delay 
}
