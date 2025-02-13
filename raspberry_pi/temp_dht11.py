import RPi.GPIO as GPIO
import dht11
import time
import datetime
import sqlite3
import urllib.request, urllib.error

# initialize GPIO
GPIO.setwarnings(True)
GPIO.setmode(GPIO.BCM)

# read data using pin 14
instance = dht11.DHT11(pin=14)

try:
    while True:
        result = instance.read()
        if result.is_valid():
            #time.sleep(5)
            dt_now = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            temp = "{0:.1f}".format(result.temperature)
            humid = "{0:.1f}".format(result.humidity)
            url = 'https://****/room_temp/insert_temperature.php?temperature='
            url += temp + '&humid=' + humid
            #print(dt_now)
            #print(result.temperature)
            #print(humid)
            f = urllib.request.urlopen(url=url)
            f.close()

            dbname = '/home/pp/Documents/dht11/dht11.db'
            # 1.データベースに接続
            conn = sqlite3.connect(dbname)

            # 2.sqliteを操作するカーソルオブジェクトを作成
            cur = conn.cursor()

            sql = 'INSERT INTO temp '
            sql = sql + '(date,temp,humid) '
            sql = sql + 'values(' + "'" + dt_now + "',"
            sql = sql + temp + ","
            sql = sql + humid + ')'

            cur.execute(sql)

            # 4.データベースにデータをコミット
            conn.commit()

            # 5.データベースの接続を切断
            cur.close()
            conn.close()
            break

except KeyboardInterrupt:
    print("Cleanup")
    GPIO.cleanup()
