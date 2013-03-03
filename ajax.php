<?php
@set_time_limit(0);
$id = $_REQUEST['id'];
$type = $_REQUEST['type'];
$size = $_REQUEST['size'];
$html = "";

parse_str(file_get_contents('http://www.youtube.com/get_video_info?video_id=' . $id . '&asv=2'), $info);
$streams = explode(',', $info['url_encoded_fmt_stream_map']);

foreach ($streams as $stream) {
  parse_str($stream, $real_stream);
  $stype = $real_stream['type'];

  $codec = str_replace('"', "", substr($real_stream['type'], strpos($real_stream['type'], '"'), strlen($real_stream['type']) - strpos($real_stream['type'], '"')));
  if ($codec == $stype)
    $codec = "N/A";

  if (strpos($real_stream['type'], ';') !== false) {
    $tmp = explode(';', $real_stream['type']);
    $stype = $tmp[0];
    unset($tmp);
  }
  if ($type == "" && $size == "") {
    $html .= '<tr>';
    $html .= '<td>'.$real_stream['quality'].'</td>';
    $html .= '<td>'.$stype.'</td>';
    $html .= '<td>'.$codec.'</td>';
    $html .= '<td> </td>';
    $html .= '<td><a class="btn btn-large btn-success pull-left" href="ajax.php?id='.$id.'&type='.$stype.'&size='.$real_stream['quality'].'" style="margin-right: 15px;"><i class="icon-download-alt icon-white"></i> Download this video file</a></td>';
    $html .= '</tr>';
    //echo "<a href='test3.php?id=" . $id . "&type=" . $stype . "&size=" . $real_stream['quality'] . "'>" . $stype . " - " . $codec . " - " . $real_stream['quality'] . "</a><br>";
  } else {
    if ($stype == $type && ($real_stream['quality'] == 'hd1080' || $real_stream['quality'] == 'hd720' || $real_stream['quality'] == 'large' || $real_stream['quality'] == 'medium' || $real_stream['quality'] == 'small')) {
      if ($size == $real_stream['quality']) {
        $ext = "";
        if($stype=="video/webm")
          $ext = "webm";
        elseif($stype=="video/x-flv")
          $ext = "flv";
        elseif($stype=="video/mp4")
          $ext = "mp4";
        elseif($stype=="video/3gpp")
          $ext = "3gp";
        //header("Content-Description: File Transfer");
        //header("Content-Disposition: attachment; filename=keepvideos.$codec");
        //header("Content-Transfer-Encoding: binary");
        //'Content-type: '.$stype."\n\r"."
        //header("Content-Disposition: attachment; filename=keepvideos.$codec\n\r"."Content-Description: File Transfer\n\r");
        header("Content-Disposition: attachment; filename=keepvideos.$ext\n\r");
        //header('Content-disposition: attachment; filename=keepvideos.'.$ext."\n\r".'Content-type: '.$stype);
        //header('Content-type: '.$stype);
        //readfile('movie.mpg');

        //header('Transfer-encoding: chunked');
        ob_flush();
        flush();
        @readfile($real_stream['url'] . '&signature=' . $real_stream['sig']);
        ob_flush();
        flush();
        break;
      }
    }
  }
}

if($html)
  echo "<table style='width:100%'>".$html."</table>";
