<?php 
$youtube_id = "NDJANzCQpOY";
$page = file_get_contents("http://www.youtube.com/watch?v=".$youtube_id);

$i = explode('<meta property="og:image" content="', $page);
$ii = explode('">', $i[1]);
//die($ii[0]);
$image = $ii[0];

$aux = explode('"url_encoded_fmt_stream_map": "', $page);
$aux2 = explode('"', $aux[1]);
$aux3 = explode('"', $aux[1]);

//die($aux2[0]);

$content = str_replace("http", "\nhttp", $aux2[0]);

//echo $content;
//die();

$urls = explode("\n", $content);
foreach($urls as $u){

  $u = urldecode($u);
  $u = urldecode($u);
  
  //echo "\n".$u."\n";
  
  $u = str_replace("\\u0026", "&", $u);
  $u = str_replace("sig=", "signature=", $u);
  //$u = str_replace("%5C", "\\", $u);
  
  $pos = strpos($u, 'default.jpg');
  if($pos !== false) {
    die("\n\n>>>>> image");
    $ii = explode('/default.jpg', $u);
    echo "\n>>>".count($ii);
    if(count($ii) > 1){
      $image = $ii[0]."/default.jpg";
      echo "\n\n".$image;
    }
  }

  $pos = strpos($u, 'codecs');
  if($pos !== false || $image!="") {

    $uu = explode('itag=', $u);

    $aux = explode('codecs="', $u);
    $aux2 = explode('"',$aux[1]);
    $codec = $aux2[0];

    $uuu = explode('quality=', $u);
    $aux = explode(',', $uuu[1]);
    $quality = $aux[0];

    if($codec == "avc1.64001F, mp4a.40.2" && $quality == "hd720"){
      $video1 = $uu[0];
      $video1 = $u;
      //die("\n\n".$codec." - ".$video1."\n\n");
    }
    elseif($codec == "avc1.42001E, mp4a.40.2" && $quality == "medium"){
      $video2 = $uu[0];
      $video2 = $u;
      //die($codec." - ".$video2);
    }

    //echo "v1: $video1\n";
    //echo "v2: $video2\n";
    //echo "img: $image\n";

    if(($video1 != "" || $video2 != "") && $image != ""){
      echo "-------------------------------------------------------------------------\n";
      echo "v1: $video1\n";
      echo "v2: $video2\n";
      echo "img: $image\n";
      die();

      echo "\n\n----------------| getting files (".$youtube_id.") |--------|Video Title|------------------------------------------------\n";
      echo "v1:\n".exec("wget --user-agent=\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4\" -O /Users/emersonestrella/Documents/Aptana Studio\ 3\ Workspace/keepvideos/".$youtube_id."-1.mp4 \"".$video1."\"");
      echo "v2:\n".exec("wget --user-agent=\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4\" -O /Users/emersonestrella/Documents/Aptana Studio\ 3\ Workspace/keepvideos/".$youtube_id."-2.mp4 \"".$video2."\"");
      echo "img:\n".exec("wget --user-agent=\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4\" -O /Users/emersonestrella/Documents/Aptana Studio\ 3\ Workspace/keepvideos/".$youtube_id.".jpg \"".$image."\"");
    }
  }
}


die();