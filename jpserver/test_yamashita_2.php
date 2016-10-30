<?php
  $day = $_POST['item'];//ポストで受け取れる
  $day = $day*2;
  $html = $day;

  header('Content-type: application/json');//指定されたデータタイプに応じたヘッダーを出力する
  echo json_encode( $html );
?>
