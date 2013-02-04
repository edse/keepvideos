<?php 
@set_time_limit(0);
$id = $_GET['id']; 
$type = $_GET['type']; 
$size = $_GET['size']; 

parse_str(file_get_contents('http://www.youtube.com/get_video_info?video_id='.$id.'&asv=2'),$info); 
$streams = explode(',',$info['url_encoded_fmt_stream_map']); 

foreach($streams as $stream){ 
    parse_str($stream,$real_stream); 
    $stype = $real_stream['type'];

    $codec = str_replace('"', "", substr($real_stream['type'],strpos($real_stream['type'], '"'),strlen($real_stream['type'])-strpos($real_stream['type'], '"')));
    if($codec == $stype)
      $codec = "N/A";

    if(strpos($real_stream['type'],';') !== false){ 
        $tmp = explode(';',$real_stream['type']); 
        $stype = $tmp[0]; 
        unset($tmp);
    }

    if($type=="" && $size==""){
      echo "<a href='test3.php?id=".$id."&type=".$stype."&size=".$real_stream['quality']."'>".$stype." - ".$codec." - ".$real_stream['quality']."</a><br>";
    }else{
      if($stype == $type && ($real_stream['quality'] == 'hd1080' || $real_stream['quality'] == 'hd720' || $real_stream['quality'] == 'large' || $real_stream['quality'] == 'medium' || $real_stream['quality'] == 'small')){
        if($size == $real_stream['quality']){
          header('Content-type: '.$stype); 
          //header('Transfer-encoding: chunked'); 
          @readfile($real_stream['url'].'&signature='.$real_stream['sig']); 
          ob_flush(); 
          flush(); 
          break; 
        } 
      } 
    }

}
