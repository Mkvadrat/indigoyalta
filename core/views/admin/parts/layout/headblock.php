  <div class="units-container head-block">
		<div class="headblock-icon">
    	<span><i class="fa fa-<?php echo $headblock['headicon']; ?>"></i></span>
    </div>

    <div class="units-row-end head-hgroup">
      <div class="unit-40"><hgroup><h3><?php echo $headblock['header']; ?></h3><h3 class="subheader"><?php echo $headblock['subheader']; ?></h3></hgroup></div>
      <div class="unit-60 more-space text-right toolbal-group">
      	<?php if($headblock['linkback']){ ?><a class="btn-cancel" href="<?php echo $headblock['linkback']['link']?>"><i class="fa fa-level-up fa-rotate-270"></i> <?php echo $headblock['linkback']['text']?></a><?php } ?>
				<?php if($headblock['lgactive']){?>
        	<?php foreach($headblock['linkgroup'] as $linkgroupitem => $linkgroupopts){ 
						if($linkgroupopts['link']){
					?>
					<a class="btn btn-iconed" href="<?php echo $linkgroupopts['link']; ?>"><i class="fa fa-<?php echo $linkgroupopts['icon']; ?>"></i> <?php echo $linkgroupopts['text']; ?></a>
					<?php } } ?>
				<?php } ?>
				<?php if($headblock['btngroup']){ ?>
        <div class="btn-<?php echo(count($headblock['btngroup']) ==1 ? 'single':'group');?>">
        	<?php foreach($headblock['btngroup'] as $btngroupitem => $btngroupitemopts){ ?>
          <input type="submit" class="btn btn-<?php echo $btngroupitem; ?>" name="<?php echo $btngroupitemopts['name']; ?>" value="<?php echo $btngroupitemopts['text']; ?>">
          <?php } ?>
				</div>
        <?php } ?>
      </div>
    </div>
    <div class="clear"></div>
    <?php if(count($breadcrumbs)){?>
    <nav class="breadcrumbs breadcrumbs-path">
        <ul>
        <?php foreach($breadcrumbs as $breadcrumblink => $breadcrumbtext){ ?>
          <li>
          <?php if($breadcrumblink != 'last') {?>
            <a href="<?php echo $breadcrumblink; ?>"><?php echo $breadcrumbtext; ?></a>
          <?php } else {?>
            <span><?php echo $breadcrumbtext; ?></span>
          <?php }?>
          </li>
				<?php }?>
        </ul>
    </nav>
    <?php } ?>
  </div>
