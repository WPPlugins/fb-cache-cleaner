<?php

@ini_set('memory_limit', '128M');
@ini_set('max_execution_time', 300);
@error_reporting(0);

if(get_option('fcc_post') == 1){
	$posts = get_posts(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1));
	
	foreach($posts as $p){
		sendPOST(get_permalink($p->ID));
	}
}

if(get_option('fcc_page') == 1){
	$page = get_pages(array('post_type'=>'page', 'post_status'=>'publish'));

	foreach($page as $a){
		echo get_permalink($a->ID).'<br>';
	}
}

?>

<div class="wrap">
	<h1>FB Cache Clear: <?php echo __('Settings', 'fcc'); ?></h1>
	
	<div class="notice notice-success"><p><?php echo __('Cache cleared!', 'fcc'); ?></p></div>
	<a href="options-general.php?page=fcc-home"><input type="button" name="submit" class="button" value="<?php __('Return back', 'fcc'); ?>"></a>
	
</div>