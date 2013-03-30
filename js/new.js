// http://keepvideos.possum-cms.com
// http://keepvideos.appspot.com
// +   original by: Emerson Estrella

$(document).ready(function() {
  var url = getParameter("url");
  var passthru = getParameter("passthru");
  if(url)
    $('#url').val()
  if(passthru)
    checkUrl();
  else
    $('#download-btn').focus();
});

$('#again').click(function() {
  $('#hero2').fadeOut('fast');$('#hero1').fadeIn('slow');
});

$('#form').submit(function() {
  checkUrl();
});

function checkUrl(){
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
}

function getVideo(youtube_video_id){
  var results = [];
  var id = "b4VsluhWVh8";
  if(youtube_video_id!="")
    id = youtube_video_id;
  $.ajax({
    url: "http://www.youtube.com/get_video_info?video_id="+id+"&asv=2",
    dataType: "text"
  }).done(function(data) {
    var info = {};
    parse_str(data, info);
    var streams = explode(',', info['url_encoded_fmt_stream_map']);
    for(var i=0; i<streams.length; i++){
      var real_stream = {};
      parse_str(streams[i], real_stream);
      real_stream['url'] += '&signature=' + real_stream['sig'];
      results.push(real_stream);
    }

    //print results
    var html = '';
    html += '<h4 class="alert-heading" style="margin-top: 25px;">All video files found for your request</h4>';
    html += '<a id="again" style="margin-top: 25px;" class="btn btn-small btn-danger" href="#main" onclick="$(\'#hero2\').fadeOut(\'fast\');$(\'#hero1\').fadeIn(\'slow\');"><i class="icon-repeat icon-white"></i> Make Another Request</a>';
    html += '<table class="table table-striped musica" style="background: rgba(255,255,255,0.7); margin-top:25px;"><thead><tr><th>Quality</th><th>Format/Codecs</th><th style="text-align: right;"></th></tr></thead><tbody>';

    if(results.length > 0){
      $.each(results, function(index, value) {
        html += '\n\r<tr>';
        html += '<td>'+value.quality+'</td>';
        html += '<td>'+value.type+'</td>';
        html += '<td><a class="btn btn-success pull-left" href="'+value.url+'" style="margin-right: 15px;"><i class="icon-download-alt icon-white"></i> Download this video format file</a></td>';
        html += '</tr>\n\r';
      });
    }
    else{
        html += '\n\r<tr>';
        html += '<td>N/A</td>';
        html += '<td>N/A</td>';
        html += '<td>N/A</td>';
        html += '</tr>\n\r';
    }
    html += '</tbody></table><a style="margin-top: 10px; margin-bottom: 25px;" class="btn btn-small btn-danger" href="#main" onclick="$(\'#hero2\').fadeOut(\'fast\');$(\'#hero1\').fadeIn(\'slow\');"><i class="icon-repeat icon-white"></i> Make Another Request</a>';
    $('#vid').html(html);
    $('#vid').fadeIn('slow');

    $('#loading').hide();
    $('#hero1').hide();
    $('#hero2').fadeIn('slow');
    $('#download-btn').show();

  });

}


function parse_str (str, array) {
  var strArr = String(str).replace(/^&/, '').replace(/&$/, '').split('&'),
    sal = strArr.length,
    i, j, ct, p, lastObj, obj, lastIter, undef, chr, tmp, key, value,
    postLeftBracketPos, keys, keysLen,
    fixStr = function (str) {
      return decodeURIComponent(str.replace(/\+/g, '%20'));
    };

  if (!array) {
    array = this.window;
  }

  for (i = 0; i < sal; i++) {
    tmp = strArr[i].split('=');
    key = fixStr(tmp[0]);
    value = (tmp.length < 2) ? '' : fixStr(tmp[1]);

    while (key.charAt(0) === ' ') {
      key = key.slice(1);
    }
    if (key.indexOf('\x00') > -1) {
      key = key.slice(0, key.indexOf('\x00'));
    }
    if (key && key.charAt(0) !== '[') {
      keys = [];
      postLeftBracketPos = 0;
      for (j = 0; j < key.length; j++) {
        if (key.charAt(j) === '[' && !postLeftBracketPos) {
          postLeftBracketPos = j + 1;
        }
        else if (key.charAt(j) === ']') {
          if (postLeftBracketPos) {
            if (!keys.length) {
              keys.push(key.slice(0, postLeftBracketPos - 1));
            }
            keys.push(key.substr(postLeftBracketPos, j - postLeftBracketPos));
            postLeftBracketPos = 0;
            if (key.charAt(j + 1) !== '[') {
              break;
            }
          }
        }
      }
      if (!keys.length) {
        keys = [key];
      }
      for (j = 0; j < keys[0].length; j++) {
        chr = keys[0].charAt(j);
        if (chr === ' ' || chr === '.' || chr === '[') {
          keys[0] = keys[0].substr(0, j) + '_' + keys[0].substr(j + 1);
        }
        if (chr === '[') {
          break;
        }
      }

      obj = array;
      for (j = 0, keysLen = keys.length; j < keysLen; j++) {
        key = keys[j].replace(/^['"]/, '').replace(/['"]$/, '');
        lastIter = j !== keys.length - 1;
        lastObj = obj;
        if ((key !== '' && key !== ' ') || j === 0) {
          if (obj[key] === undef) {
            obj[key] = {};
          }
          obj = obj[key];
        }
        else { // To insert new dimension
          ct = -1;
          for (p in obj) {
            if (obj.hasOwnProperty(p)) {
              if (+p > ct && p.match(/^\d+$/g)) {
                ct = +p;
              }
            }
          }
          key = ct + 1;
        }
      }
      lastObj[key] = value;
    }
  }
}

function explode (delimiter, string, limit) {
  if ( arguments.length < 2 || typeof delimiter == 'undefined' || typeof string == 'undefined' ) return null;
  if ( delimiter === '' || delimiter === false || delimiter === null) return false;
  if ( typeof delimiter == 'function' || typeof delimiter == 'object' || typeof string == 'function' || typeof string == 'object'){
    return { 0: '' };
  }
  if ( delimiter === true ) delimiter = '1';
  
  // Here we go...
  delimiter += '';
  string += '';
  
  var s = string.split( delimiter );
  

  if ( typeof limit === 'undefined' ) return s;
  
  // Support for limit
  if ( limit === 0 ) limit = 1;
  
  // Positive limit
  if ( limit > 0 ){
    if ( limit >= s.length ) return s;
    return s.slice( 0, limit - 1 ).concat( [ s.slice( limit - 1 ).join( delimiter ) ] );
  }

  // Negative limit
  if ( -limit >= s.length ) return [];
  
  s.splice( s.length + limit );
  return s;
}

function getParameter(sParam){
  var sPageURL = window.location.search.substring(1);
  var sURLVariables = sPageURL.split('&');
  for (var i = 0; i < sURLVariables.length; i++){
    var sParameterName = sURLVariables[i].split('=');
    if(sParameterName[0] == sParam) {
      return sParameterName[1];
    }
  }
  return false;
}​