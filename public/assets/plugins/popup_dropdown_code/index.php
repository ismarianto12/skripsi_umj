<!DOCTYPE html>

<html lang="en-US">
<head>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<style>

</style>
<body>
	<div class="container">

      <!-- Main component for a primary marketing message or call to action -->
       <h1>Dropdown in Popup</h1>
		<div id="popover1" class="col-sm-12 col-xs-12 col-md-9">
		<a title="" class="btn btn-primary change-project" href="javascript:;" data-original-title="popover Test" >Popover Example</a>        
      <div class="hide" id="select-div">
            <div class="col-sm-2 "  style="width:250px;">
			<select class="form-control">
			<option>Test</option>
			<option>Test1</option></select>
			</div>
        
			<div class="clearfix col-sm-10" style="margin:8px 0;">
			  <button type="button" class="btn btn-default btn-go">Go!</button>
			  <button type="button" class="btn btn-default btn-cancel-option">Cancel</button>
			</div>
	</div>
	</div>
       </div>
</body>

</html>
<?php 
$options = array(0=>'No', 1=>'Yes');
?>
<script type="text/javascript">
$(window).bind('ChangeView', function(e, data){
		$('.change-project').popover({
            placement : 'Right',
            title : 'Change',
            trigger : 'click',
            html : true,
            content : function(){
                var content = '';
				content = $('#select-div').html();
				return content;
            } 
        }).on('shown.bs.popover', function(){
        });

        $(document).delegate('.btn-go','click', function(e){
            e.preventDefault();
            alert('Go Click');
        });

        $(document).delegate('.btn-cancel-option', 'click', function(e){
            e.preventDefault();
            var element = $(this).parents('.popover');
            if(element.size()){
                $(element).removeClass('in').addClass('out');
            }
        });
	});
$(document).ready(function(){


$(window).trigger('ChangeView', {}); 
  

});

</script>