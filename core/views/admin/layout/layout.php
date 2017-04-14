<?php

$css_url = '/gui/corecss/';
$js_url = '/gui/corejs/';

//If is an ajax request, we will render just the content.

if($this->auth->is_logged()){
	$bodyclassbg = 'auth-page';
	$loguserid = $this->auth->user('id');
	$loggroupid = $this->auth->user('id_group');
	
}else{
	$bodyclassbg = 'login-page';
}


if ($this->input->is_ajax_request())
{
	$this->load->view($view, $content);
} else {

?><!doctype html>
<html lang="<?php echo $this->lang->current_language; ?>">
	<head>
		<title>FastCMS<?php echo $title != '' ? $title . ' &bull; ' : ''; ?></title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="/gui/corecss/font-awesome.min.css" type="text/css">	
		<link rel="stylesheet" href="/gui/corecss.php" type="text/css">
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<?php /*?> 
    <script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/multisortable.js"></script>
    <script type="text/javascript" src="<?php echo site_url() . THEMESPATH; ?>admin/js/jquery-ui-nestedSortable.js"></script>
    <?php */?>
    <script type="text/javascript" src="<?php echo $js_url; ?>jquery.shapeshift.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>validate.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>kube.tabs.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>jquery.tablesorter.widgets.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>jquery.textchange.min.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>jquery.dynatree.min.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>fasteditor.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>fastnotify.js"></script>
    <script type="text/javascript" src="<?php echo $js_url; ?>core.js"></script>
<?php /*?>    <script>
    $(document).ready(function() {
      $(".uploaded-images-list").shapeshift({
					handle: ".reorder",
					});
			$(".uploaded-images-list").on("ss-rearranged", function(e, selected) {
          modifier = $(this).find(".ss-dragging")[0] ? 1 : 0

              $(this).children().each(function() {
                $(this).find(".i-order input").val($(this).index()+1)
              })
            });
    })
  </script>
<?php */?>	</head>
	<body class="<?php echo $bodyclassbg; ?>">
		<div class="body-wrapper">
		<?php if ($header) { $this->load->view($base.'layout/header', $content); } ?>
			<div class="wrapper" id="pagewrapper">
				<?php $this->load->view($view, $content); ?>
				<div class="clear"></div>
			</div>
    <div class="clear"></div>
		</div>
		<?php // if ($header) { $this->load->view($base.'layout/footer', $content); } ?>
		<script type="text/javascript">
		var site_url = '<?php echo site_url(); ?>';
		var admin_url = '<?php echo admin_url(); ?>/';
		var current_url = '<?php echo current_url(); ?>';
		var local_date_format = '<?php echo LOCAL_DATE_FORMAT; ?>';
		</script>
	</body>
</html><?php } ?>