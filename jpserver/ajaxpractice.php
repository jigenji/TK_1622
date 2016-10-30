
<!---　制作情報
  // Created by Yamashita Keisuke
  // Date:23/10/2016
  // Authorized by Σηθ
                            -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>総括のTEST</title>

  <!-- 外部ファイルのインポート -->
  <link rel="stylesheet" href="index.style.css">
  <?php require(dirname(__FILE__)."/server/database/FinalReadMachine.php");?>
  <?php $Yam = new DaysRecordMachine(); ?>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB-DChcRioj2lMlZk0hj0-SbnrEeKfYVp8&libraries=visualization"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</head>


<body onload="initialize()"> <!--文書全体の読み込みが終了次第、属性onloadの属性値oinitialize()が実行される-->
  <div id="map_canvas" style="width:100%; height:94.8%"></div>
  <input type="range" min="0" max="64800" value="0" step="3600" onchange="showValue(this.value)"/> <!-- スライダを作成する,onchange属性は値が変更されたときに実行 -->
  <span id="range">6:00</span> <!-- spanは特定の処理をさせる意味なしタグ -->
  <script type="text/javascript">
    var map,loadcounter=0;
    function initialize(time_hour = 6,markerData=[]) {
      var timeNumber = "time" + (time_hour-5);
      if(loadcounter != 0){
        var address = "台東区";//今の所、固定
        // var address = map.getCenter();
        // map.setCenter(address);
        // console.log(address);
        }

      else{
        var address = prompt("表示したい区を”〇〇区”のように入力してください。");
        // var markerData = [ // この真下の引数は時間$timeと区認識番号$wardである。
        //   <?php echo json_encode($Yam->getUsersValueArray(6,6), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>
        // ];
        loadcounter ++;
      }
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( {'address':address}, function(results, status) {
        // ジオコーディングが成功した場合
        if (status == google.maps.GeocoderStatus.OK) {
          // google.maps.Map()コンストラクタに定義されているsetCenter()メソッドで
          map.setCenter(results[0].geometry.location);
          // 変換した緯度・経度情報を渡してインスタンスを生成
          var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
          });
        } else {alert('住所情報を取得することができませんでした: ' + status);}
      })


      // 地図の作成
      map = new google.maps.Map(document.getElementById('map_canvas'), { // google.maps.Map(第一引数(表示位置,サイズ)のdiv要素（ここではid指定した),第二引数(オプション))
        zoom: 14, 								// 地図のズームを指定
        streetViewControl:false, 	//ストリートビュー無効化
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
      });

    // ヒートマップ用のデータ
    var heatmapData = [];
    for (var j = 0; j < markerData.length; j++) {
      if(markerData[j][timeNumber]!=0){
      heatmapData[j] = new google.maps.LatLng({lat: markerData[j]['latitude'], lng: markerData[j]['longitude']});
    }else{}
  }

    // レイヤーの作成、プロパティ
    var heatmap = new google.maps.visualization.HeatmapLayer({
      radius : 18,
      data: heatmapData
    });

    // ヒートマップを表示
    if(heatmap.getMap() == null){
    heatmap.setMap(map);
    heatmap.setData(heatmapData);
  }

}

    // スライダーを表示、値を取得
    function showValue(newValue){
      var minute = ":00";
      var time_hour = newValue / 3600 + 6;
      if(newValue==86400){
        time_hour -= 1;
        minute = ":59";
      }else{}
        document.getElementById("range").innerHTML=time_hour+minute;
        // initialize(time_hour);
        $.ajax({
          type: 'POST',
          dataType:'json',
          url:'sent.php',
          data:{
            item:time_hour
          },
          success:function(data) {
            // console.log(data);
            var markerData = data;
            console.log(markerData[1]);
            // console.log(markerData.length);
            initialize(time_hour,markerData);
          },
          error:function(XMLHttpRequest, textStatus, errorThrown) {
          }
        });
    }

    // phpの変数からjavascriptの変数への受け渡しラップ関数
    function json_safe_encode($data){
      return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }
  </script>
</body>
</html>
