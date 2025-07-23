<?php 
ini_set("display_errors", 1);
error_reporting(E_ALL);

//セッション開始

//　グラフカラー
$color1 = "#cccccc";
$color2 = "#999999";

// SQLクエリを読み込む
include('common_db/sql_queries.php');

// 月次データを格納する配列
$monthly_data = array();

// 検索欄に日付が入力されているとき
    // SQLからの検索結果を配列に格納する
    $monthly_data = sqlQueries::get_latest_temperature(54);

// SQLの検索結果をグラフ用の配列にまとめる
// $columns 配列に詰めたいカラム名
function get_graph_data($monthly_data,$columns)
{
    $chart_data = null;

    //体重グラフ用のデータを生成
    if(count($monthly_data) != 0)
    {    
       $chart_data = "[";
       foreach($monthly_data as $value)
       { 
           if($value[$columns] != -1)
           {
               $chart_data .='["'.$value['datetime'].'",'.$value[$columns].'],';
           }
       }
       $chart_data = substr($chart_data,0,-1);
       $chart_data .= "]";
    }
    else
    {
       $chart_data = "[['',0]]";
    }

    return $chart_data;
}

?>
<!DOCTYPE html>
<html lang="ja">
<?php require_once 'common_design/head.php'; ?>
<body>
<?php //require_once 'common_design/container.php';?>
<div class="row marketing">

      <!--温度のグラフ-->
      <div class="col-lg-12">
          <h4>温度グラフ</h4>
          <div id="jqPlot-temperature"></div>
          <h4>湿度グラフ</h4>
          <div id="jqPlot-humid"></div>
          <table class="table right">
            <tr>
              <td>日付</td>
              <td><span class="circle2"></span><b>温度</b></td>
              <td><span class="circle2"></span><b>湿度</b></td>
            </tr>
           <?php foreach($monthly_data as $value){ ?>
           <tr class="graph">
                <td><?php echo $value['datetime'];?></td>
                <td><b><?php echo $value['temperature'];?></b></td>
                <td><?php echo $value['humid'];?></td>
           </tr>
        <?php }?>
        </table>
      </div>
</div>

    <?php /*グラフ描画関連の設定 */ ?>
    <script>
      /*気温のグラフ*/
      $(document).ready(function()
      {
          // グラフに描画するデータ(配列)を変数に格納
          temperature_data = <?php echo get_graph_data($monthly_data,"temperature");?>;

          //  体重のグラグ
          graph_temperature = $.jqplot( 'jqPlot-temperature', [temperature_data],
          {
              seriesColors: ["<?php echo $color2;?>"],
              axes:
              {
                  xaxis:
                  {
                      renderer: jQuery . jqplot . DateAxisRenderer,
                      tickOptions: {
                        formatString: '%H:%M'
                      }
                  }
              },
              grid: 
              {
                  // グラフを囲む枠線の太さ、0で消える
                  borderWidth: 1,
                  // 背景色を透明に
                  background: 'transparent',
                  // 影もいらない
                  shadow: true,
              }
          });

          // グラフに描画するデータ(配列)を変数に格納
          humid_data = <?php echo get_graph_data($monthly_data,"humid");?>;

          //  体重のグラグ
          graph_humid = $.jqplot( 'jqPlot-humid', [humid_data],
            {
              seriesColors: ["<?php echo $color2;?>"],
              axes:
                {
                  xaxis:
                    {
                      renderer: jQuery . jqplot . DateAxisRenderer,
                      tickOptions: {
                        formatString: '%H:%M'
                      }
                    }
                },
              grid:
                {
                  // グラフを囲む枠線の太さ、0で消える
                  borderWidth: 1,
                  // 背景色を透明に
                  background: 'transparent',
                  // 影もいらない
                  shadow: true,
                }
            });

            // ウインドウをリサイズしたとき
            window.onresize = function(event)
            {
                graph_temperature.replot();
                graph_humid.replot();
            }
  });
  </script>
  <link href="common_css/month_weight.css" rel="stylesheet">
  </body>
</html>
