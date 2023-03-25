#include <SoftwareSerial.h>

SoftwareSerial mySerial(4, 5);

//TDS Sensor
#include <EEPROM.h>
#include "GravityTDS.h"

#define TdsSensorPin A1
GravityTDS gravityTds;

float temperature = 25, tdsValue = 0;

// PH Sensor
#define SensorPin A0            //pH meter Analog output to Arduino Analog Input 0
#define Offset -0.02           //deviation compensate
#define samplingInterval 20
#define printInterval 800
#define ArrayLenth  40    //times of collection

int pHArray[ArrayLenth];   //Store the average value of the sensor feedback
int pHArrayIndex=0;
float nilaiPH = 0;

// WaterFlow
volatile int pulsa_sensor;
unsigned int debit;
unsigned char pinFlowsensor = 2;
unsigned long waktuAktual;
unsigned long waktuLoop;

unsigned int flowmlt;
float totalmlt;
unsigned long oldTime;
float liter = 0;

//biaya meter perkubik
int biayaliter = 2000;

float kubik = 0;

//total biaya
int totalbiaya = 0;

void cacahPulsa()
{
  pulsa_sensor++;
}

// LCD
#include <LiquidCrystal_I2C.h>

//define I2C address......
LiquidCrystal_I2C lcd(0x3F, 20, 4);

// SCL -> A5
// SDA -> A4

void setup(void)
{
  Serial.begin(115200);
  mySerial.begin(115200);

  // TDS
  gravityTds.setPin(TdsSensorPin);
  gravityTds.setAref(5.0);  //reference voltage on ADC, default 5.0V on Arduino UNO
  gravityTds.setAdcRange(1024);  //1024 for 10bit ADC;4096 for 12bit ADC
  gravityTds.begin();  //initialization

  // WaterFlow
  pinMode(pinFlowsensor, INPUT);
  digitalWrite(pinFlowsensor, HIGH);
  
  attachInterrupt(0, cacahPulsa, RISING);
  sei();
  waktuAktual = millis();
  waktuLoop = waktuAktual;
  
  Serial.println("Water filtering");
  
  lcd.init();
  lcd.backlight();

  lcd.clear();
  lcd.setCursor(6, 1);
  lcd.print("WELCOME");
  lcd.setCursor(2, 2);
  lcd.print("WATER FILTERING");
  
  delay(1000);
}
void loop(void)
{
  lcd.clear();

  lcd.setCursor(2, 0);
  lcd.print("WATER FILTERING");
  
  readPHSensor();
  readTDSSensor();
  readWaterFlow();

  Serial.println();

  Serial.println("Kirim ke nodemcu : " + (String) debit + "#" + (String) tdsValue + "#" + (String) nilaiPH + "#kirim");
  mySerial.println((String) debit + "#" + (String) tdsValue + "#" + (String) nilaiPH + "#kirim");

  Serial.println();

  delay(2000);
}

void readTDSSensor() {
  gravityTds.setTemperature(temperature);  // set the temperature and execute temperature compensation
  gravityTds.update();  //sample and calculate 
  tdsValue = gravityTds.getTdsValue();  // then get the value

  Serial.print("TDS Value : ");
  Serial.print(tdsValue, 0);
  Serial.println(" ppm");

  lcd.setCursor(0, 2);
  lcd.print("TDS       :");
  lcd.setCursor(12, 2);
  lcd.print(tdsValue);
}

void readWaterFlow()
{
  waktuAktual = millis();
  
  if(waktuAktual >= (waktuLoop + 1000))
  {
    waktuLoop = waktuAktual;
    debit = (pulsa_sensor * 60 / 4.5);
    pulsa_sensor = 0;

    flowmlt = (debit / 60) * 1000;
    totalmlt += flowmlt;
    
    liter = totalmlt / 1000;
    kubik = liter / 1000;
    
    Serial.print("Debit Air : ");
    Serial.print(int(debit));
    Serial.println(" L/min");

    lcd.setCursor(0, 3);
    lcd.print("DEBIT AIR :");
    lcd.setCursor(12, 3);
    lcd.print(int(debit));
  }
}

void readPHSensor() {
  static unsigned long samplingTime = millis();
  static unsigned long printTime = millis();
  static float pHValue, voltage;
  
  if(millis()-samplingTime > samplingInterval)
  {
      pHArray[pHArrayIndex++] = analogRead(SensorPin);
      if (pHArrayIndex == ArrayLenth) pHArrayIndex = 0;
      
      voltage = avergearray(pHArray, ArrayLenth) * 5.0 / 1024;
      pHValue = 3.5 * voltage + Offset;
      samplingTime=millis();

      nilaiPH = pHValue;
  }
  
  if (millis() - printTime > printInterval)   // Every 800 milliseconds, print a numerical, convert the state of the LED indicator
  {
    Serial.print("pH value: ");
    Serial.println(pHValue, 2);
  
    lcd.setCursor(0, 1);
    lcd.print("PH AIR    :");
    lcd.setCursor(12, 1);
    lcd.print(pHValue);
    
    printTime=millis();

    nilaiPH = pHValue;
  }
}

double avergearray(int* arr, int number){
  int i;
  int max,min;
  double avg;
  long amount=0;
  if(number<=0){
    Serial.println("Error number for the array to avraging!/n");
    return 0;
  }
  if(number<5){   //less than 5, calculated directly statistics
    for(i=0;i<number;i++){
      amount+=arr[i];
    }
    avg = amount/number;
    return avg;
  }else{
    if(arr[0]<arr[1]){
      min = arr[0];max=arr[1];
    }
    else{
      min=arr[1];max=arr[0];
    }
    for(i=2;i<number;i++){
      if(arr[i]<min){
        amount+=min;        //arr<min
        min=arr[i];
      }else {
        if(arr[i]>max){
          amount+=max;    //arr>max
          max=arr[i];
        }else{
          amount+=arr[i]; //min<=arr<=max
        }
      }//if
    }//for
    avg = (double)amount/(number-2);
  }//if
  return avg;
}
