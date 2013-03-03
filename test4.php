<?php
header('X-Frame-Options: GOFORIT'); 
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta http-equiv="Access-Control-Allow-Origin" content="*">
  <meta http-equiv="X-Frame-Options" content="GOFORIT">
</head>
<body>
<iframe src="http://www.youtube.com/embed/ax68kL2WhRw?html5=1" id="ext" style="opacity: 0.5"></iframe>
<div id="log"></div>
<form action="" method="post" id="form" class="well pane2" novalidate="novalidate">
<input type="text" class="input-medium" name="url" id="url" placeholder="YouTube Video URL like: www.youtube.com/watch?v=5KlnlCq2M5Q" style="width: 550px">
<div>
  <button id="download-btn" class="btn btn-large btn-primary" type="submit"><i class="icon-download-alt icon-white"></i> Download Video</button>
  <img id="loading" alt="Loading..." style="border-width:0; display: none;" src="img/loading.gif" />
</div>
</form>
<script src="js/libs/jquery-1.7.2.min.js"></script>
<!-- <script src="js/full2.js"></script> -->
<script>
$(document).ready(function() {
    parent = null;
    var id = "ax68kL2WhRw";
    //var url = "http://www.youtube.com/watch?v="+id+"&html5=true";
    var url = "http://www.youtube.com/embed/"+id+"?html5=true";
    $("#log").html($("#ext").contents());
    //console.log($("#ext").contents());
    
    //$("#log").load(url);

    /*
    $.ajax({
      url: url, 
      //dataType: 'html',
      async: false,
      type: "GET",
      crossDomain: true,
      dataType: "jsonp",
      success: function(data) {
        console.log(data.length);
      },
      error: function(request, status, error) {
        console.log(request+" "+status+" "+error);
      }
    });
    */
   
/*
    $.ajax({
      url: "http://www.youtube.com/watch?v="+id+"&html5=true&callback=?",
      dataType: 'html',
      async: false,
      type: "GET",
      crossDomain: true,
      dataType: "jsonp",
      success: function(res) {
        //var headline = $(res.responseText).find('a.tsh').text();
        //alert(headline);
        //$("#log").html(res)
        console.log(res);
      }
    });
*/
    /*
    $.getJSON(url + "?callback=?", null, function(res) {
      console.log(res);
      //$("#log").html(res)
    });
    */
});
</script>
</body>
</html>