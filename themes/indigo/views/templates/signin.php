<div class="page-outer">
<?php
$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');
?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="signin-wrapper">
		<form action="<?php echo site_url('/admin/auth/login');?>" method="post" class="forms forms-columnar">
			<p>
				<label>Логин:</label>
				<input name="username" type="text" class="width-100" value="<?php echo $this->input->post('username'); ?>" />
			</p>
			<p>
				<label>Пароль:</label>
				<input name="password" type="password" class="width-100" value="" />
			</p>
			<p>
      	<input type="submit" class="btn btn-blue" name="submit" value="Войти">
			</p>
		</form>
	</div>
	<div class="clear"></div>
</div>

