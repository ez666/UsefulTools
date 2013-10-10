<?php
if($_REQUEST['action'] == 'php') { 
  if (get_magic_quotes_gpc() == true) {
    foreach($_COOKIE as $key => $value) {
      $_COOKIE[$key] = stripslashes($value);
    }
  }
  $cookie = json_decode($_COOKIE['mycookie'], true);
  print_r($cookie);
} else {
?>
<!DOCTYPE html>
<html lang="en-au">
  <head>
    <title>kos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body style="padding:15px">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Form</h3>
            </div>
            <div class="panel-body">
              <form id="html-form" role="form" method="post" action="cookies.php">
                <div class="form-group">
                  <label for="firstname">Enter Firstname</label>
                  <input class="form-control" id="firstname" name="firstname" type="text" value="" placeholder="Enter Firstname" />
                </div>
                <div class="form-group">
                  <label for="lastname">Enter Lastname</label>
                  <input class="form-control" id="lastname" name="lastname" type="text" value="" placeholder="Enter Lastname" />
                </div>
                <br>
                <button class="btn btn-primary" id="submit" type="submit">Save to cookie</button>
                <button class="btn btn-primary" type="reset">Reset from</button>
                <button id="loaddata" class="btn btn-primary">Load from cookie</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">PHP</h3>
            </div>
            <div class="panel-body">
              <textarea id="txt" class="form-control" rows="16" style="font-family:arial;font-size:12px"></textarea>
              <br>
              <button id="loadphp" class="btn btn-primary">Load cookies using PHP</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.3.1/jquery.cookie.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(function(){
      $("#html-form").submit(function() {
        $.post($("#html-form").attr("action"), $("#html-form"), function(data){
          $.cookie("mycookie", form2string($("#html-form")), {expires:365});
        });
        return false;
      });
      
      $('#loaddata').click(function() {
        string2form($('#html-form'), $.cookie('mycookie'));
        return false;
      });
      
      $('#loadphp').click(function() {
        $( "#txt" ).load( "cookies.php?action=php" );
        return false;
      });

      function form2string($form){
        return JSON.stringify($form.serializeArray());
      }

      function string2form(form, serializedStr){
        var fields = JSON.parse(serializedStr);
        for(var i=0; i< fields.length; i++){
          var controlName = fields[i].name;
          var controlValue = fields[i].value;
          form.find('[name="'+ controlName +'"]').val(controlValue);
        }
      }  
    });
    </script>
  </body>
</html>
<?php } ?>