<div class="page-homepage">
<?php
$page_h1 = page('meta_h1');
$page_title = page('title');
$page_id = page('id_record');
$page_body = page('content');
?>
	<div class="page-title"><h1><?php echo ($page_h1)? $page_h1:$page_title; ?></h1></div>
	<?php if($page_body){ ?>
	<div class="page-inner">
		<?php echo str_replace('<p align="center">', '<p style="text-align:center;">', $page_body); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>
  
<?php 
$news = find('news')->where('show_homepage','T')->documents(TRUE)->limit(5)->order_by('date_publish', 'DESC')->get(); 

if($news){
?>

	<div class="page-title"><h2>Новости</h2></div>
	<ul>
	<?php foreach ($news as $newsitem){ 
	
		$thumbnail = $newsitem->get('thumbnail');
		if (is_array($thumbnail) && count($thumbnail)) {
			$thumbnailsrs = preset_url(attach_url($thumbnail[0]->path), 'thumbnail');
		}else{
			$thumbnailsrs = false;
		}
	
	
	?>
		<li>
			<h3><a href="<?php echo semantic_url($newsitem); ?>"><?php echo $newsitem->get('title'); ?></a></h3>
				<div class="excerpt">
        	<?php if($thumbnailsrs){ ?> <img style="float:left; margin:0 20px 10px 0" src="<?php echo $thumbnailsrs;  ?>"  alt="<?php echo htmlspecialchars(strip_tags($newsitem->get('title'))); ?>" ><?php } ?>
					<?php echo auto_typography(strip_tags($newsitem->get('excerpt')));?>
				<div class="clear"></div>
				</div>
			<a href="<?php echo semantic_url($newsitem); ?>">подробнее</a>
		</li>
	<?php } ?>
	</ul>
<?php } ?>  
  
  
</div>