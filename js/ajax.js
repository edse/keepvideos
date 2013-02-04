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
  
  var menuId = $("ul.nav").first().attr("id");
  var request = $.ajax({
    url: "ajax.php",
    type: "POST",
    data: {id : youtube_video_id},
    dataType: "html"
  });
  request.done(function(msg) {
    console.log(msg);
    $("#log").html( msg );
    
    html = msg;
    $('#vid').html(html);
    $('#vid').fadeIn('slow');

    $('#loading').hide();
    $('#hero1').hide();
    $('#hero2').fadeIn('slow');
    $('#download-btn').show();
  });
  request.fail(function(jqXHR, textStatus) {
    alert("Request failed: "+textStatus);
  });
  
  //html += '</tbody></table><a style="margin-top: 10px; margin-bottom: 25px;" class="btn btn-small btn-danger" href="#main" onclick="$(\'#hero2\').fadeOut(\'fast\');$(\'#hero1\').fadeIn(\'slow\');"><i class="icon-repeat icon-white"></i> Make Another Request</a>';

}