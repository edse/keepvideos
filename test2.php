<?php

$url = 'http://r1---sn-xhcg5uxa-bg0e.c.youtube.com/videoplayback?id=6b1ebc90bd96851c&algorithm=throttle-factor&burst=40&upn=rNQtIDpRvAU&factor=1.25&sparams=algorithm%2Cburst%2Ccp%2Cfactor%2Cid%2Cip%2Cipbits%2Citag%2Csource%2Cupn%2Cexpire&cp=U0hVRVBPVF9NUENONV9ISVhJOmxiT3lsRWJFVUh1&ms=au&itag=34&key=yt1&fexp=923413%2C916602%2C929115%2C906440%2C914024%2C916625%2C901459%2C920704%2C912806%2C902000%2C922403%2C922405%2C929901%2C913605%2C925710%2C929114%2C920201%2C913302%2C919009%2C911116%2C926403%2C910221%2C901451%2C919114&source=youtube&ipbits=8&mt=1360024457&expire=1360046886&newshard=yes&mv=m&sver=3&ip=189.121.85.247&quality=medium,type=video/mp4;+codecs="avc1.42001E,+mp4a.40.2"&sig=5A56699550054647D5C69C346018AA0E2764915E.53E6A5673FC7DA2340988DD02EE93C730F22FD84&fallback_host=tc.v15.cache2.c.youtube.com&itag=18';
die($url);


die('http://r1---sn-xhcg5uxa-bg0e.c.youtube.com/videoplayback?expire=1360046886&fexp='.urlencode('927900,910019,916624,921039,920704,912806,902000,922403,922405,929901,913605,925710,929114,920201,913302,930101,919009,911116,926403,910221,901451,919114').
'&id=6b1ebc90bd96851c&sver=3&ip=189.121.85.247&sparams='.urlencode('cp,id,ip,ipbits,itag,ratebypass,source,upn,expire').'&source=youtube&ipbits=8&upn=3r8zcOEEaeY&cp=U0hVRVBPVF9NUENONV9ISVhJOkpnV2NGTU1INHVD&newshard=yes&key=yt1&ms=au&ratebypass=yes&mv=m'.
'&itag=43&mt=1360023617&itag=43&sig=92A3E383182EB422998D8C5FF6E6EAD28C1BA30E.137FC2A88E4D57CBF15A90C404AA7D9C62FEEC3D&fallback_host=tc.v7.cache3.c.youtube.com&type='.urlencode('video/webm;+codecs="vp8.0,+vorbis",quality=medium'));
      
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