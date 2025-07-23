# 面接提出用プログラム
## 本プログラムについて
本プログラムはRaspberryPiに接続された温度センサーdht11があります。
10分毎に温度センサーを使い温度と湿度の情報を、 VPSサーバーに送信します。
送信したデータをMySQLに格納し、過去約9時間分をグラフ化して画面に表示しています。

RaspberryPi関連のソースコードを、raspberry_pi/にまとめてあります。

## 詳細
RaspberryPiからVPSサーバーへのデータの通信は、Pythonのurllibより、
温度、湿度、パスワードをクエリパラメータで渡しています。

>https://****/room_temp/insert_temperature.php?temperature=(温度)&humid=(湿度)

データの外部からの入力等、セキュリテイ対策やバリデーションなどは 実装しておりません。

### 設定情報
## サーバー
ConoHa VPS(1コア/30GB/メモリ512MB)

## 使用ミドルウェア
Linux:CentOS8
Apache2.4.37.
MariaDB 10.3.28
PHP8.0
