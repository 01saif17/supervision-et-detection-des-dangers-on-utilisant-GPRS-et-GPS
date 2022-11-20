#include <TinyGPS++.h>
#include <SoftwareSerial.h>
#include <AltSoftSerial.h>
//#include <DHT.h>;
#include "SIM800L.h"

#define SIM800_RX_PIN 10
#define SIM800_TX_PIN 11
#define SIM800_RST_PIN 6
#define MQ2pin A1
//#define DHTPIN A0    // what pin we're connected to
//#define DHTTYPE DHT22   // DHT 22  (AM2302)
//DHT dht(DHTPIN, DHTTYPE); //// Initialize DHT sensor for normal 16mhz Arduino

//GPS Module RX pin to Arduino 9
//GPS Module TX pin to Arduino 8
AltSoftSerial neogps;


TinyGPSPlus gps;

unsigned long previousMillis = 0;
long interval = 60000;
const char APN[] = "******"; //set your access point name of your sim 
SIM800L* sim800l;
void setup()
{ 
  // Initialize Serial Monitor for debugging
       Serial.begin(115200);
       while(!Serial);
  // Initialize a SoftwareSerial
       SoftwareSerial* serial = new SoftwareSerial(SIM800_RX_PIN, SIM800_TX_PIN);
       serial->begin(9600);
       delay(1000); 
  // Initialize SIM800L driver with an internal buffer of 200 bytes and a reception buffer of 512 bytes, debug disabled
       sim800l = new SIM800L((Stream *)serial, SIM800_RST_PIN, 200, 512); 
        // Wait until the module is ready to accept AT commands
  while(!sim800l->isReady()) {
    Serial.println(F("Problem to initialize AT command, retry in 1 sec"));
    delay(1000);
    //
//    dht.begin();
  }
 Serial.println(F("Setup Complete!"));

  // Wait for the GSM signal
  uint8_t signal = sim800l->getSignal();
  while(signal <= 0) {
    delay(1000);
    signal = sim800l->getSignal();
  }
  Serial.print(F("Signal OK (strenght: "));
  Serial.print(signal);
  Serial.println(F(")"));
  delay(1000);

  // Wait for operator network registration (national or roaming network)
  NetworkRegistration network = sim800l->getRegistrationStatus();
  while(network != REGISTERED_HOME && network != REGISTERED_ROAMING) {
    delay(1000);
    network = sim800l->getRegistrationStatus();
  }
  Serial.println(F("Network registration OK"));
  delay(1000);

  // Setup APN for GPRS configuration
  bool success = sim800l->setupGPRS(APN);
  while(!success) {
    success = sim800l->setupGPRS(APN);
    delay(5000);
  }
 Serial.println(F("GPRS config OK"));

   //Begin serial communication with Arduino and SIM800L
       neogps.begin(9600);
       Serial.println("welcome,im on ready ");
       delay(2000);
}
//-----------------------------------------------------------------------------------//
     void GETGPSLOCATION()
  {
      // Establish GPRS connectivity (5 trials)
  bool connected = false;
  for(uint8_t i = 0; i < 100 && !connected; i++) {
    delay(1000);
    connected = sim800l->connectGPRS();
  }
   // Check if connected, if not reset the module and setup the config again
  if(connected) {
    //Serial.print(F("GPRS connected with IP "));
    Serial.println(sim800l->getIP());   
    //Can take up to 60 seconds
 boolean newData = false;
  for (unsigned long start = millis(); millis() - start < 2000;){
    while (neogps.available()){
      if (gps.encode(neogps.read())){
        newData = true;
          break;
        }
      }
    }
    //If newData is true
 if(true){
  newData = false;
 
double lat,lng;  
float gaz;
//float  temp= dht.readTemperature(); 
float g= analogRead(MQ2pin);
if(g>300){
  gaz=g;
}else 
gaz=0;                                                      
}
lat =gps.location.lat(); // Latitude in degrees (double)
lng =gps.location.lng(); // Longitude in degrees (double)
String lati ="";
  lati = String(lat,6);
  String lngi ="";
  lngi = String(lng,6);  
// String lngi="10";  
//String strUrl= "https://******.000webhostapp.com/gpsdata.php?lat="; //ancienne parce que changee dans database gpsdata par data
String strUrl= "https://****.000webhostapp.com/data.php?lat=";  // set your https url after created in webhost 
  strUrl += lati;
  strUrl += "&lng=";
  strUrl += lngi;
  strUrl += "&gaz=";
  strUrl += gaz; 
  //strUrl += "&temerature=";  
  //strUrl += temp; 
 // strUrl += "&humidity=";  
  //strUrl += hum;  
int str_len = strUrl.length() + 1; 
char URL[str_len];
strUrl.toCharArray(URL, str_len);    
Serial.println("this is your drone sir");
  Serial.print(" Latitude= "); 
Serial.print(lati);
Serial.print(" Longitude= "); 
Serial.print(lngi);
Serial.print(" gaz_valuer= ");
Serial.println(gaz);  
//Serial.print(" temperature= ");
//Serial.print(temp);   
//Serial.print(" humidity= ");
//Serial.println(hum); 
Serial.println(F("sending data..."));

  // Do HTTP GET communication with 10s for the timeout (read)
    uint16_t rc = sim800l->doGet(URL, 6000);
   if(rc == 200) {
    // Success, output the data received on the serial
    //Serial.print(F("Data sent successfully("));
    Serial.print(sim800l->getDataSizeReceived());
    Serial.println(F(" bytes)"));
    Serial.print(F("Received : "));
    Serial.println(sim800l->getDataReceived());
    Serial.println("Next Result...");    
   }else {
     // Failed...
    Serial.print(F("HTTP GET error "));
    Serial.println(rc); 
   }
    }
    }                                                             
    sim800l->reset();
  }
//---------------------------------------------------------------------------//
         
 void loop() 
 {
    GETGPSLOCATION();
 }
