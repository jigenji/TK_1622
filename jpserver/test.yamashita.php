<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>Ajax</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script type="text/javascript"></script>
<input type="range" min="0" max="86400" value="0" step="3600" onchange="showValue(this.value)"/> <!-- スライダを作成する,onchange属性は値が変更されたときに実行 -->
<span id="range">0:00</span> <!-- spanは特定の処理をさせる意味なしタグ -->

<script>
var time_hour = 0;
function showValue(newValue){
  var minute = ":00";
  var time_hour = newValue / 3600;
  if(newValue==86400){
    time_hour -= 1;
    minute = ":59";
  }else{}
    document.getElementById("range").innerHTML=time_hour+minute;
    var day = 0;
    $.ajax({
      type: 'POST',
      dataType:'json',
      url:'sent.php',
      data:{
        item:time_hour
      },
      success:function(data) {
        console.log(data);
      },
      error:function(XMLHttpRequest, textStatus, errorThrown) {
      }
    });
}
</script>

</head>

<body>
</body>
</html>
