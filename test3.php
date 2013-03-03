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
        $ytfile = $real_stream['url'].'&signature='.$real_stream['sig'].'&asv=2';
        if($size == $real_stream['quality']){
          $ext = "";
          if($stype=="video/webm")
            $ext = "webm";
          elseif($stype=="video/x-flv")
            $ext = "flv";
          elseif($stype=="video/mp4")
            $ext = "mp4";
          elseif($stype=="video/3gpp")
            $ext = "3gp";
          downloadFile($ytfile, dirname(__FILE__)."/keepvideos.".$ext);
          exit;
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename='.basename("keepvideos.".$ext));
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          //@readfile_chunked($ytfile);

          $file = @fopen($ytfile,"rb");
          while(!feof($file))
          {
            print(@fread($file, 1024*8));
            ob_flush();
            flush();
          }
          fclose($f);
          exit;
        } 
      } 
    }

}


function readfile_chunked($filename,$retbytes=true) {
  $chunksize = 1*(1024*1024); // how many bytes per chunk
  $buffer = '';
  $cnt =0;
  // $handle = fopen($filename, 'rb');
  $handle = fopen($filename, 'rb');
  if ($handle === false) {
      return false;
  }
  while (!feof($handle)) {
      $buffer = fread($handle, $chunksize);
      echo $buffer;
      ob_flush(); 
      flush();
      if ($retbytes) {
          $cnt += strlen($buffer);
      }
  }
      $status = fclose($handle);
  if ($retbytes && $status) {
      return $cnt; // return num. bytes delivered like readfile() does.
  } 
  exit;
  return $status;
} 

function downloadFile ($url, $path) {

  $newfname = $path;
  $file = fopen ($url, "rb");
  if ($file) {
    $newf = fopen ($newfname, "wb");

    if ($newf)
    while(!feof($file)) {
      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
    }
    echo "1";
    flush();
  }

  if ($file) {
    fclose($file);
  }

  if ($newf) {
    fclose($newf);
  }
 }