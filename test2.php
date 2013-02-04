<?php
      
      $id = "Ujwod-vqyqA";
      
      echo "\n...downloading YouTube: ".$id."\n\n";
      
      $video1 = "";
      $video2 = "";
      $image  = "";
      if($id != ""){
        
        $youtube_id = $id;
        
        //$youtube_id = "hczRLTVYdA4";

        $info2 = file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$youtube_id);
        if($info2){
          $aux = explode("duration='", $info2);
          $duration = substr($aux[1], 0, strpos($aux[1], "'"));
          if(intval($duration)>0){
            // extract hours
            $hours = floor($duration / (60 * 60));
            // extract minutes
            $divisor_for_minutes = $duration % (60 * 60);
            $minutes = floor($divisor_for_minutes / 60);
            // extract the remaining seconds
            $divisor_for_seconds = $divisor_for_minutes % 60;
            $seconds = ceil($divisor_for_seconds);
            if($hours < 10) $hours = "0".$hours;
            if($minutes < 10) $minutes = "0".$minutes;
            if($seconds < 10) $seconds = "0".$seconds;
            $duration = $hours.":".$minutes.":".$seconds;
            //die('ok');
          }
        }

        $page = file_get_contents("http://www.youtube.com/watch?v=".$youtube_id);
        
        $i = explode('<meta property="og:image" content="', $page);
        $ii = explode('">', $i[1]);
        $image = str_replace("mqdefault", "default", $ii[0]);
        //echo "\n\n".$image."\n\n";
        //die();
        
        $aux = explode('"url_encoded_fmt_stream_map": "', $page);
        $aux2 = explode('"', $aux[1]);
        $aux3 = explode('"', $aux[1]);
        
        $content = str_replace("http", "\nhttp", $aux2[0]);
        
        $urls = explode("\n", $content);
        
                  //var_dump($urls);
        
        foreach($urls as $u){
        
          $u = urldecode($u);
          //$u = urldecode($u);
          
          $u = str_replace("\\u0026", "&", $u);
          $u = str_replace("sig=", "signature=", $u);
                    
          //$u = str_replace("%5C", "\\", $u);
          
          //echo "\n$u";
          
          $pos = strpos($u, 'default.jpg');
          if($pos !== false) {
            $ii = explode('/default.jpg', $u);
            if(count($ii) > 1){
              $image = $ii[0]."/default.jpg";
            }
          }
        
          $pos = strpos($u, 'codecs');
          if($pos !== false || $image!="") {
        
            //$uu = explode('itag=', $u);
        
            $aux = explode('codecs="', $u);
            if(isset($aux[1])){
              $aux2 = explode('"',$aux[1]);
              $codec = $aux2[0];
            }
        
            $uuu = explode('quality=', $u);
            if(isset($uuu[1])){
              $aux = explode(',', $uuu[1]);
              $quality = $aux[0];
            }
        
            $v3d = explode('stereo3d=', $u);
            if(isset($v3d[1])){
              $v3daux = explode('&', $v3d[1]);
              $stereo3d = $v3daux[0];
            }

            //echo "\n 3D = ".$stereo3d." - ".str_replace('"', '%22', $u);

            if($codec == "avc1.64001F, mp4a.40.2" && $quality == "hd720" && $stereo3d == ""){
              //$video1 = $uu[0];
              $video1 = str_replace('"', '%22', $u);
              //die("\n\n".$codec." - ".$video1."\n\n");
            }
            elseif($codec == "avc1.42001E, mp4a.40.2" && $quality == "medium" && $stereo3d == ""){
              //$video2 = $uu[0];
              $video2 = str_replace('"', '%22', $u);
              //die($codec." - ".$video2);
            }
        
          }
        }
        
        
        if(($video1 != "" || $video2 != "") && $image != ""){
          echo "-------------------------------------------------------------------------\n\n";
          echo "v1: $video1\n\n";
          echo "v2: $video2\n\n";
          echo "img: $image\n\n";

          echo "\n\n----------------| getting files (".$youtube_id.") |--------|Video Title|------------------------------------------------\n";
          echo "v1:\n".exec("wget --user-agent=\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4\" -O /Users/emersonestrella/Documents/Aptana\ Studio\ 3\ Workspace/keepvideos/".$youtube_id."-1.mp4 \"".$video1."\"");
          echo "v2:\n".exec("wget --user-agent=\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4\" -O /Users/emersonestrella/Documents/Aptana\ Studio\ 3\ Workspace/keepvideos/".$youtube_id."-2.mp4 \"".$video2."\"");
          echo "img:\n".exec("wget --user-agent=\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4\" -O /Users/emersonestrella/Documents/Aptana\ Studio\ 3\ Workspace/keepvideos/".$youtube_id.".jpg \"".$image."\"");
        }

      }
      
      die('\n\nFIM!');

/*
http://o-o---preferred---sn-hp576n7s---v2---lscache1.c.youtube.com/videoplayback?upn=RvvTT8YbiJQ&sparams=cp,id,ip,ipbits,itag,ratebypass,source,upn,expire&fexp=912301,906520,914076,916611,922401,920704,912806,927201,925003,913546,913556,920201,900816,911112,901451&key=yt1&expire=1351740008&itag=37&ipbits=8&sver=3&ratebypass=yes&mt=1351714272&ip=200.136.27.146&mv=m&source=youtube&ms=au&cp=U0hURldPTl9FUkNONF9PSVJBOnNVNEtBZ2thdldN&id=85ccd12d3558740e&newshard=yes&type=video/mp4; codecs=%22avc1.64001F, mp4a.40.2%22&fallback_host=tc.v8.cache1.c.youtube.com &signature=5868654F052B6ED5FBF5A311709114B042B26862.07098D123A5CA57014CF8AB4EDBB94F0EEB2A114&quality=hd1080,itag=45&url=

http://o-o---preferred---sn-hp576n7s---v2---lscache1.c.youtube.com/videoplayback?upn=RvvTT8YbiJQ&sparams=cp,id,ip,ipbits,itag,ratebypass,source,upn,expire&fexp=912301,906520,914076,916611,922401,920704,912806,927201,925003,913546,913556,920201,900816,911112,901451&key=yt1&expire=1351740008&itag=22&ipbits=8&sver=3&ratebypass=yes&mt=1351714272&ip=200.136.27.146&mv=m&source=youtube&ms=au&cp=U0hURldPTl9FUkNONF9PSVJBOnNVNEtBZ2thdldN&id=85ccd12d3558740e&newshard=yes&type=video/mp4; codecs=%22avc1.64001F, mp4a.40.2%22&fallback_host=tc.v16.cache4.c.youtube.com&signature=3E32974CCA84179A426460363F90AB9E89F66069.B8874D45B42AF7BFC53D4EF69CF184DE61EE387E&quality=hd720,itag=84&url=

http://o-o---preferred---sn-hp576n7s---v2---lscache1.c.youtube.com/videoplayback?upn=RvvTT8YbiJQ&sparams=cp,id,ip,ipbits,itag,ratebypass,source,upn,expire&fexp=912301,906520,914076,916611,922401,920704,912806,927201,925003,913546,913556,920201,900816,911112,901451&key=yt1&expire=1351740008&itag=84&ipbits=8&sver=3&ratebypass=yes&mt=1351714272&ip=200.136.27.146&mv=m&source=youtube&ms=au&cp=U0hURldPTl9FUkNONF9PSVJBOnNVNEtBZ2thdldN&id=85ccd12d3558740e&newshard=yes&type=video/mp4; codecs=%22avc1.64001F, mp4a.40.2%22&fallback_host=tc.v18.cache6.c.youtube.com&stereo3d=1&signature=A53407F78ED20C35911F8E7A123905E74FCD37F3.119C88390345413043D4EC51AD0B7A76A465B709&quality=hd720,itag=44&url=
*/