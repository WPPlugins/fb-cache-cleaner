<?php

if(isset($_POST['submit'])){
	$ppp = filter_input(INPUT_POST, 'fcc_post', FILTER_SANITIZE_NUMBER_INT);
	$ppa = filter_input(INPUT_POST, 'fcc_pag', FILTER_SANITIZE_NUMBER_INT);
	
	$pp = ($ppp == 1) ? 1 : 0;
	$pa = ($ppa == 1) ? 1 : 0;
	
	update_option('fcc_post', $pp);
	update_option('fcc_page', $pa);
	
	$upd = 1;
}


$dbpost = get_option('fcc_post');
$dbpag = get_option('fcc_page');
?>


<div class="wrap">
	<h1>FB Cache Clear: <?php echo __('Settings', 'fcc'); ?></h1>
	
<?php if($upd){ ?>
	<div class="notice notice-success"><p><?php __('Settings updated!', 'fcc'); ?></p></div>
<?php } ?>
	
	<form method="post" action="options-general.php?page=fcc-home">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<?php echo __('Clean cache on', 'fcc'); ?>
					</th>
					<td>
						<fieldset>
							<label for="fcc_post">
								<input name="fcc_post" type="checkbox" id="fcc_post" value="1"<?php if($dbpost == 1){ echo ' checked'; } ?>> Post
							</label>
							<br>
							<label for="fcc_pag">
								<input name="fcc_pag" type="checkbox" id="fcc_pag" value="1"<?php if($dbpag == 1){ echo ' checked'; } ?>> <?php echo __('Pages', 'fcc'); ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php echo __('Manually delete of all cache', 'fcc'); ?>
					</th>
					<td>
						<a href="options-general.php?page=fcc-home&option=del_all"><input type="button" name="submit" class="button" value="<?php echo __('Delete all', 'fcc'); ?>"></a>
						<p class="description"><?php echo __('This may take a long time depending on the performance of the server and the number of pages / post.', 'fcc'); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" class="button button-primary" value="<?php echo __('Save settings', 'fcc'); ?>">
		</p>
	</form>
	
</div>