/* Author: Emerson Estrella */

$('#again').click(function() {
  $('#hero2').fadeOut('fast');$('#hero1').fadeIn('slow');
});

$('#form').submit(function() {
  var url = $('#url').val();
  var regExp = /.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
  var match = url.match(regExp);
  if(match){
    $('#download-btn').fadeOut('fast');
    $('#loading').fadeIn('slow');
    setTimeout("getVideo('"+match[1]+"')",2000);
  }
  else{
    alert('Invalid URL!');
    $('#url').val("");
    $('#url').focus();
  }
  return false;
});

function getVideo(youtube_video_id){
  
  var id = "b4VsluhWVh8";
  id = youtube_video_id;

  $.ajax({
    url: "http://www.youtube.com/get_video_info?video_id="+id,
    dataType: "text"
  }).done(function(data) {
    var results = [];
    var r = 0;
    data = (data+'').replace(/\+/g, '%20');
    data = data.replace(/url%3D/g, '\n\r\n\r<break>');
    data = data.replace(/sig%3D/g, 'signature%3D');

    var urls = data.split('<break>');
    for(var u = 0; u < urls.length; u++){
      var result = {};
      var d = unescape(unescape(decodeURIComponent((urls[u]+'').replace(/\+/g, '%20'))));
      d = d.replace(/="/g, '%3D%22');
      d = d.replace(/"/g, '%22');
      var url = d;
      //console.log(d);
      //console.log(d.length);
      if(d.length > 1500){
        aux = d.split('&has_cc');
        d = aux[0];
      }
      
      var vars = [], hash;
      var hashes = d.slice(d.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++){
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = unescape(hash[1]);
      }
      
      if(vars['type']!=undefined){
        result.type = vars['type'];
        if(vars['type'].indexOf("codecs")>0){
          var cs = vars['type'].split(';+codecs="');
          result.type = cs[0];
          result.codecs = cs[1].replace('"','').replace('+',' ');
        }
      }
              
      //quality
      if(vars['quality']!=undefined){
        result.quality = vars['quality'];
        if(vars['quality'].indexOf(",")>0){
          var cs = vars['quality'].split(',');
          result.quality = cs[0];
        }
      }
      
      if(result.type && result.quality){
        result.url = url;
        results[r] = result;
        r++;
      }

    }

    //console.log(results);
    
    //print results
    var html = '';
    html += '<h4 class="alert-heading" style="margin-top: 25px;">All video files found for your request</h4>';
    html += '<a id="again" style="margin-top: 25px;" class="btn btn-small btn-danger" href="#main" onclick="$(\'#hero2\').fadeOut(\'fast\');$(\'#hero1\').fadeIn(\'slow\');"><i class="icon-repeat icon-white"></i> Make Another Request</a>';
    html += '<table class="table table-striped musica" style="background: rgba(255,255,255,0.7); margin-top:25px;"><thead><tr><th>Quality</th><th>Format</th><th>Codecs</th><th style="text-align: right;"></th></tr></thead><tbody>';
    $.each(results, function(index, value) {
      html += '\n\r<tr>';
      html += '<td>'+value.quality+'</td>';
      html += '<td>'+value.type+'</td>';
      if(value.codecs!=undefined)
        html += '<td>'+value.codecs+'</td>';
      else
        html += '<td>N/A</td>';
      html += '<td><a class="btn btn-success pull-left" href="'+value.url+'" style="margin-right: 15px;"><i class="icon-download-alt icon-white"></i> Download this video format file</a></td>';
      html += '</tr>\n\r';
    });
    html += '</tbody></table><a style="margin-top: 10px; margin-bottom: 25px;" class="btn btn-small btn-danger" href="#main" onclick="$(\'#hero2\').fadeOut(\'fast\');$(\'#hero1\').fadeIn(\'slow\');"><i class="icon-repeat icon-white"></i> Make Another Request</a>';
    $('#vid').html(html);
    $('#vid').fadeIn('slow');

    $('#loading').hide();
    $('#hero1').hide();
    $('#hero2').fadeIn('slow');
    $('#download-btn').show();

  });

}