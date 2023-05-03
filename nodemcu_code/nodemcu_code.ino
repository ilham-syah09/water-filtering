// Wifi
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>

ESP8266WiFiMulti WiFiMulti;

HTTPClient http;
#define USE_SERIAL Serial

String simpan = "http://192.168.127.185/water-filtering/data/save?pH=";

String respon = "";

#include <SoftwareSerial.h>
SoftwareSerial mySerial(D7, D8);

String data;
char c;

String ph, ppm, debit, statuspH, statusTds;

void setup()
{
  // put your setup code here, to run once:
  Serial.begin(115200);
  mySerial.begin(115200);

  USE_SERIAL.begin(115200);
  USE_SERIAL.setDebugOutput(false);

  for (uint8_t t = 4; t > 0; t--)
  {
    USE_SERIAL.printf("[SETUP] Tunggu %d...\n", t);
    USE_SERIAL.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("ilhamsyah", "12345678"); // Sesuaikan SSID dan password ini

  for (int u = 1; u <= 5; u++)
  {
    if ((WiFiMulti.run() == WL_CONNECTED))
    {
      USE_SERIAL.println("Wifi Connected");
      USE_SERIAL.flush();
      delay(1000);
    }
    else
    {
      Serial.println("Wifi not Connected");
      delay(1000);
    }
  }
}
void loop()
{
  while (mySerial.available() > 0)
  {
    delay(10);
    c = mySerial.read();
    data += c;
  }

  if (data.length() > 0)
  {
    data.trim();

    Serial.println("Pembacaan Serial : " + data);

    Serial.println();

    debit = getValue(data, '#', 0);
    ppm = getValue(data, '#', 1);
    ph = getValue(data, '#', 2);
    statuspH = getValue(data, '#', 3);
    statusTds = getValue(data, '#', 4);

    Serial.print("PH Air : ");
    Serial.println(ph);
    Serial.print("TDS Value: ");
    Serial.println(ppm);
    Serial.print("Debit : ");
    Serial.println(debit);
    Serial.print("Status pH : ");
    Serial.println(statuspH);
    Serial.print("Status TDS : ");
    Serial.println(statusTds);

    Serial.println();

    kirim_database();

    data = "";
  }

  delay(300);
}

String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = {0, -1};
  int maxIndex = data.length() - 1;

  for (int i = 0; i <= maxIndex && found <= index; i++)
  {
    if (data.charAt(i) == separator || i == maxIndex)
    {
      found++;
      strIndex[0] = strIndex[1] + 1;
      strIndex[1] = (i == maxIndex) ? i + 1 : i;
    }
  }

  return found > index ? data.substring(strIndex[0], strIndex[1]) : "";
}

void kirim_database()
{
  if ((WiFiMulti.run() == WL_CONNECTED))
  {
    Serial.println(simpan + (String)ph + "&ppm=" + (String)ppm + "&debit=" + (String)debit + "&statuspH=" + (String)statuspH + "&statusTds=" + (String)statusTds);

    Serial.println();

    http.begin(simpan + (String)ph + "&ppm=" + (String)ppm + "&debit=" + (String)debit + "&statuspH=" + (String)statuspH + "&statusTds=" + (String)statusTds);

    USE_SERIAL.print("[HTTP] Kirim data ke database ...\n");
    int httpCode = http.GET();

    if (httpCode > 0)
    {
      USE_SERIAL.printf("[HTTP] kode response GET : %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK) // code 200
      {
        respon = http.getString();
        USE_SERIAL.println("Respon : " + respon);
      }
    }
    else
    {
      USE_SERIAL.printf("[HTTP] GET data gagal, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
  }

  Serial.println();
}
