<div class="breadcrumbs"><?php load_helper('breadcrumbs'); echo breadcrumbs(tree('breadcrumbs'));?></div>
<div class="page-outer">
<?php
$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');

$template_feedback_email = page('template_feedback_email');
$template_feedback_adress = page('template_feedback_adress');
$template_feedback_city = page('template_feedback_city');
$template_feedback_region = page('template_feedback_region');
$template_feedback_postcode = page('template_feedback_postcode');
$template_feedback_country = page('template_feedback_country');
$template_feedback_mobile = page('template_feedback_mobile');
$template_feedback_fixed = page('template_feedback_fixed');
$template_feedback_fax = page('template_feedback_fax');
$template_feedback_website = page('template_feedback_website');
$template_feedback_content = page('template_feedback_content');
?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo $page_body; ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="feedback-data">

		<ul class="left-part">
			<li class="location">
				<?php echo($template_feedback_adress)? $template_feedback_adress.', ' :''; ?>
				<?php echo($template_feedback_city)? $template_feedback_city.', ' :''; ?>
				<?php echo($template_feedback_region)? $template_feedback_region.', ' :''; ?>
				<?php echo($template_feedback_postcode)? $template_feedback_postcode.', ' :''; ?>
				<?php echo($template_feedback_country)? $template_feedback_country :''; ?>
			</li>
			<?php if($template_feedback_email){ ?>
			<li class="email">
				<?php echo safe_mailto($template_feedback_email); ?>
			</li>
			<?php } ?>
			<?php if($template_feedback_website){ ?>
			<li class="website">
				<?php echo $template_feedback_website; ?>
			</li>
			<?php } ?>
		</ul>
		
		<ul class="right-part">
			<?php
			if($template_feedback_mobile){ 
			$phones = explode(',',$template_feedback_mobile);
			foreach ($phones as $phone){
			?>
			<li class="mobile">
				<?php echo $phone; ?>
			</li>
			<?php } } ?>
			<?php if($template_feedback_fixed){ ?>
			<li class="fixed">
				<?php echo $template_feedback_fixed; ?>
			</li>
			<?php } ?>
			<?php if($template_feedback_fax){ ?>
			<li class="fax">
				<?php echo $template_feedback_website; ?>
			</li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
		<?php if($template_feedback_content){ ?>
		<div class="feedback-data-additional">
			<?php echo $template_feedback_content; ?>
		</div>
		<?php } ?>
	</div>
	
	<div class="feedback-form">
		<?php
		$config = array(
			'action' => 'email',
			'from' => 'website@indigo-yalta.com',
			'from_name' => settings('website_claim_ru'),
			'to' => settings('website_email'),
//			'to' => 'fastimus@fastimus.ru',
			'subject' => 'Новый запрос с сайта' );
		echo module('contact_form', $config)->render();
		?>
	<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>




