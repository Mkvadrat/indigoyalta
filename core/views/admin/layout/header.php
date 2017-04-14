<?php
$avamil = $this->auth->user('email');

$_admin_url = admin_url() . '/';
$segment_2 = $this->uri->segment(2);
$segment_3 = $this->uri->segment(3);
$segment_4 = $this->uri->segment(4);

$tipi_content = array();
$tipi_pages = array();
foreach ($this->content->types() as $tipo) {
	if ($tipo['tree']) {
		$tipi_pages[] = array(
			'name'	=> $tipo['description'],
			'url'	=> $_admin_url . 'pages/type/' . $tipo['name'],
			'acl'	=> 'content|' . $tipo['name'],
			'altsegment' =>  $tipo['name']
		);
	} else {
		$tipi_content[] = array(
			'name'	=> $tipo['description'],
			'url'	=> $_admin_url . 'contents/type/' . $tipo['name'],
			'acl'	=> 'content|' . $tipo['name'],
			'altsegment' =>  $tipo['name']
		);
		}
}

$menu = array(
//	array(
//		'name'		=> 'Просмотр сайта',
//		'url'		=> site_url(),
//		'target'	=> '_blank',
//		'segment'	=> 'dashboard',
//		'icon'	=> 'desktop',
//	),
//
	array(
		'name'		=> 'Страницы',
		'url'		=> $_admin_url . 'schemes',
		'icon'	=> 'file-text-o',
		'type'	=> 'item',
		'color'	=> 'blue',
		'segment'	=> 'pages',
		'sons'		=> $tipi_pages
	),
	array(
		'name'		=> 'Разделы',
		'url'		=> $_admin_url . 'schemes',
		'icon'	=> 'file-text-o',
		'type'	=> 'item',
		'color'	=> 'aqua',
		'segment'	=> 'contents',
		'sons'		=> $tipi_content
	),
	array(
		'type'	=> 'separator',
	),
	array(
			'name'	=> 'Связки разделов',
		'type'	=> 'item',
		'acl'	=> 'settings|manage',
		'color'	=> 'lavender',
		'icon'	=> 'random',
		'url'	=> $_admin_url . 'hierarchies',
		'segment' => 'hierarchies'
			),
	array(
		'name'	=> 'Навигация',
		'icon'	=> 'sitemap',
		'acl'	=> 'settings|manage',
		'color'	=> 'mint',
		'type'	=> 'item',
		'url'	=> $_admin_url . 'navigation',
		'segment' => 'navigation',
	),
	array(
		'name'	=> _('Repository'),
		'type'	=> 'item',
		'color'	=> 'sunflower',
		'icon'	=> 'picture-o ',
		'url'	=> $_admin_url . 'repository',
		'segment' => 'repository',
	),
	array(
		'type'	=> 'separator',
	),
	array(
		'name'	=> 'Запросы в СП',
		'type'	=> 'item',
		'acl'	=> 'settings|manage',
		'color'	=> 'grapefruit',
		'icon'	=> 'envelope-o',
		'url'	=> $_admin_url . 'requests',
		'segment' => 'requests',
	),
	array(
		'type'	=> 'separator',
	),
	array(
		'name'		=> _('Users'),
		'url'		=> '#',
		'acl'		=> 'users|list',
		'color'	=> 'green',
		'type'	=> 'item',
		'segment'	=> 'users',
		'icon'	=> 'user',
		'sons'	=> array(
			array(
				'name'	=> _('Users list'),
				'url'	=> $_admin_url . 'users/allusers',
				'acl'	=> 'users|list',
				'altsegment' => 'users'
			),
			array(
				'name'	=> _('Groups and permissions'),
				'url'	=> $_admin_url . 'users/groups',
				'acl'	=> 'users|groups',
				'altsegment' => 'groups'
			)
		)
	),
	array(
		'type'	=> 'separator',
	),
	array(
		'name'		=> 'Настройки',
		'url'		=> $_admin_url . 'settings',
		'type'	=> 'item',
		'color'	=> 'orange',
		'segment'	=> 'settings',
		'acl'	=> 'settings|manage',
		'icon'	=> 'cogs',
	),
	array(
		'name'		=> 'Сброс кеша',
		'acl'	=> 'settings|manage',
		'type'	=> 'item',
		'url'		=> $_admin_url . 'schemes/rebuild_cache',
		'segment'	=> 'rebuild_cache',
		'icon'	=> 'refresh',
	),
	array(
		'type'	=> 'separator',
	),
	array(
		'name'		=> 'Выход',
		'type'	=> 'item',
		'url'		=> $_admin_url . 'auth/logout',
		'segment'	=> 'logout',
		'icon'	=> 'sign-out',
	),
);

?>

	<div id="sidenavi" class="sidebar">
	<div class="cms-logo"><a href="<?php echo admin_url(); ?>"><img src="/gui/coreimages/logo.png" alt="FastCMS"></a></div>
	
  <div class="user-minipanel">
  	<div class="minipanel-wrapper clearfixing">
    
          <div class="user-miniavatar"><a><img src="https://s.gravatar.com/avatar/<?php echo md5(trim($avamil))?>?s=60" width="60" height="60" alt="ava"></a></div>
          <div class="user-miniinfo">
          	<ul class="zero">
            	<li class="user-mininame">
              	 <strong><?php echo $this->session->userdata('user_full_name');?>  </strong>              
              </li>
            	<li class="user-minirole"><em class="small"><?php echo $this->auth->user('groupname'); ?></em></li>
             	<li class="user-gofront">
              	<a href="<?php echo site_url(); ?>" class="label" target="_blank">перейти на сайт <i class="fa fa-caret-right"></i>  </a>
              </li>
           </ul>
          </div>
    
    </div>
  </div>

	<ul id="nav" class="main-navigation">
		<?php
		foreach ($menu as $row) {
			
			if($row['type'] == 'item'){
			
				if (isset($row['acl'])) {
					list($controller, $action) = explode('|', $row['acl']);
					$available = $this->auth->has_permission($controller, $action);
					if (!$available) continue;
				}
				$iconbody ='';
				if(isset($row['icon'])) {
					$iconbody = '<i class="fa fa-'.$row['icon'].' fa-fw"></i>';
				}
				$parentclass ='';
				if (isset($row['sons']) && count($row['sons'])) {$parentclass =' parent';}
				echo '<li class="first-level' . ($segment_2 == $row['segment'] ? ' open icon-'.$row['color'] : '') .$parentclass. '">'.
					 $iconbody.'<a href="' . $row['url'] . '" '.(isset($row['target']) ? ' target="'.$row['target'].'"' : '').'>' . $row['name'] . '</a>';
	
				if (isset($row['sons']) && count($row['sons'])) {
					echo '<ul class="nested">';
					foreach ($row['sons'] as $son) {
	
						if(isset($son['acl'])) {
							list($controller_2, $action_2) = explode('|', $son['acl']);
							$available_2 = $this->auth->has_permission($controller_2, $action_2);
						} else {
							$available_2 = TRUE;
						}
						
						if ($available_2) {
							if (isset($son['altsegment'])) {
								$is_active = $segment_3 == $son['altsegment'] || $segment_4 == $son['altsegment'];
							} else if (isset($son['segment'])) {
								$is_active = $segment_2 == $son['segment'];
							} else {
								$is_active = FALSE;
							}
	
							echo   '<li class="second-level' . ($is_active ? ' active' : '') . '">'
									.'<a href="' . $son['url'] . '">' . $son['name'] . '</a>'
									.'</li>';
						}
					}
					echo '</ul>';
				}
				echo '</li>';
			
			}else{
			
				echo '<li class="separator-menu"></li>';
			
			}
		
		}
		?>

	</ul>
</div>