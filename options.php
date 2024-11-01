<?php
add_action('admin_menu', 'sod_create_drawer_menu');
add_action( 'admin_init', 'register_sod_drawer_settings' );
add_action('admin_enqueue_scripts', 'sod_drawer_plugins_admin_js_css');
function sod_drawer_plugins_admin_js_css(){
	wp_register_style('sod_drawer_admin_colorpicker_css', plugin_dir_url(__FILE__) . 'css/picker.css', false, '1.0.0' );
	wp_register_style('sod_drawer_admin_css', plugin_dir_url(__FILE__) . 'css/admin.css', false, '1.0.0' );
	wp_register_script('sod_drawer_admin_colorpicker_js', plugin_dir_url(__FILE__) . 'js/colorpicker.js');
	wp_register_script('sod_drawer_admin_js', plugin_dir_url(__FILE__) . 'js/admin.js');
	wp_enqueue_style( 'sod_drawer_admin_colorpicker_css' );
	wp_enqueue_style( 'sod_drawer_admin_css' );
	wp_enqueue_script("sod_drawer_admin_colorpicker_js");
	wp_enqueue_script("sod_drawer_admin_js");
}
function sod_create_drawer_menu() {
	//create new top-level menu
	add_menu_page('61D Plugin Settings', 'Sliding Drawer', 'administrator', __FILE__, 'sod_drawer_settings_page',plugins_url('/images/icon.png', __FILE__));
	add_options_page('Sliding Drawer Plugin Options', 'Drawer Plugin', 'administrator', 'sod-drawer-settings', 'sod_drawer_settings_page');
}
function register_sod_drawer_settings() {
	$options = array(
		'position'=>'top',
		'widget_areas'=>'3',
		'handle_position'=>'right',
		'widget_layout'=>'vertical',
		'drawer_width'=>'300px',
		'drawer_grid_width'=>'960px',
		'color'=>'#CF5A0C',
		'text_color'=>'#fff',
		'link_color'=>'#fff',
		'handle_text_color'=>'#fff',
		'handle_text'=>'Click Here',
		'vertical_handle_position'=>'middle'
		);
	add_option("sod_drawer_options", $options);
	register_setting( 'sod-drawer-settings', 'sod_drawer_options' );
}
function sod_drawer_settings_page() {
?>
<div class="wrap sod">
<h2>Sliding Drawer Plugin</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'sod-drawer-settings' ); ?>
    <?php $options = get_option('sod_drawer_options'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">
        	<h3>Drawer Position</h3>
		</th>
         <td>
         	<?php $positions = array( 'top', 'bottom','left','right')?>	
         	<select name="sod_drawer_options[position]" id="position">
				<?php foreach($positions as $position) {
					if($position==$options['position']){?>
					<option selected="selected" value="<?php echo $position; ?>"><?php echo $position; ?></option>	
				<?php }else{?>
					<option value="<?php echo $position;?>"><?php echo $position; ?></option>
				<?php };
				};
				?>
			</select>
			</td>
        </tr>
        <tr valign="top">
        <th scope="row">
        	<h3>Drawer Handle Position</h3>
		</th>
         <td>
         	<div id="horizontal-handle-position" class="no-display" style="float:left;">
         	<?php $positions = array( 'left','right')?>	
         	<select name="sod_drawer_options[handle_position]" id="sod_drawer_options[handle_position]">
				<?php foreach($positions as $position) {
					if($position==$options['handle_position']){?>
					<option selected="selected" value="<?php echo $position; ?>"><?php echo $position; ?></option>	
				<?php }else{?>
					<option value="<?php echo $position;?>"><?php echo $position; ?></option>
				<?php };
				};
				?>
			</select>
			</div>
			<div id="vertical-handle-position" class="no-display" style="float:left;">
				<?php $positions = array( 'top', 'middle','bottom')?>	
         	<select name="sod_drawer_options[vertical_handle_position]" id="vertical_handle_position">
				<?php foreach($positions as $position) {
					if($position==$options['vertical_handle_position']){?>
					<option selected="selected" value="<?php echo $position; ?>"><?php echo $position; ?></option>	
				<?php }else{?>
					<option value="<?php echo $position;?>"><?php echo $position; ?></option>
				<?php };
				};
				?>
			</select>
			</div>
			</td>
        </tr>
         <tr valign="top">
        <th scope="row">
        	<h3>Number of Widget Areas</h3>
        </th>
        <td>
        	<?php $widget_areas = array( '1', '2','3','4')?>	
         	<select name="sod_drawer_options[widget_areas]" id="sod_drawer_options[widget_areas]">
				<?php foreach($widget_areas as $widget_area) {
					if($widget_area==$options['widget_areas']){?>
					<option selected="selected" value="<?php echo $widget_area; ?>"><?php echo $widget_area; ?></option>	
				<?php }else{?>
					<option value="<?php echo $widget_area;?>"><?php echo $widget_area; ?></option>
				<?php };
				};
				?>
			</select>
		</td>
        </tr>
      <tr valign="top" id="drawer-width" class="no-display">
        <th scope="row">
        	<h3>Drawer Width (px)</h3>
        </th>
        <td>
        	<input type="text" name="sod_drawer_options[drawer_width]" id="sod_drawer_options[drawer_width]" value="<?php echo $options['drawer_width'];?>"/>
		</td>
        </tr>
        <tr valign="top" id="drawer-content-width" class="no-display">
        <th scope="row">
        	<h3>Drawe Content Width (px) - Leave Blank for Full Width</h3>
        </th>
        <td>
        	<input type="text" name="sod_drawer_options[drawer_grid_width]" id="sod_drawer_options[drawer_grid_width]" value="<?php echo $options['drawer_grid_width'];?>"/>
		</td>
        </tr>
     	<tr valign="top">
        <th scope="row">
        	<h3>Drawer Handle Text</h3>
		</th>
        <td>
        	<input type="text" name="sod_drawer_options[handle_text]" id="sod_drawer_options[handle_text]" value="<?php echo $options['handle_text'];?>"/>
		</td>
        </tr>
        <script type="text/javascript">        
				  jQuery(document).ready(function(){
				     jQuery('.colorSelector').each(function(){
						var Othis = this; //cache a copy of the this variable for use inside nested function
						var initialColor = jQuery(Othis).next('input').attr('value');
						jQuery(this).ColorPicker({
							color: initialColor,
							onShow: function (colpkr) {
								jQuery(colpkr).fadeIn(500);
								return false;
							},
							onHide: function (colpkr) {
								jQuery(colpkr).fadeOut(500);
								return false;
							},
							onChange: function (hsb, hex, rgb) {
								jQuery(Othis).children('div').css('backgroundColor', '#' + hex);
								jQuery(Othis).next('input').attr('value','#' + hex);
							}
						});
				   		});
				   });
				</script>
        <tr valign="top">
        	<th scope="row">
        		<h3>Drawer Color</h3>
			</th>
        	<td>
        		<div class="colorSelector left">
					<div style="background-color: <?php echo $options['color'];?>">
					</div>
				</div>
				<input class="color-picker" name="sod_drawer_options[color]" id="sod_drawer_options[color]" type="text" value="<?php echo $options['color'];?>" />
			</td>
		</tr>
		<tr valign="top">
        	<th scope="row">
        		<h3>Drawer Handle Color</h3>
			</th>
    		<td>
        		<div class="colorSelector left">
					<div style="background-color: <?php echo $options['handle_text_color'];?>">
					</div>
				</div>
				<input class="color-picker" name="sod_drawer_options[handle_text_color]" id="sod_drawer_options[handle_text_color]" type="text" value="<?php echo $options['handle_text_color'];?>" />
			</td>
		</tr>
		<tr valign="top">
        	<th scope="row">
        		<h3>Text Color</h3>
			</th>
			<td>
				<div class="colorSelector left">
					<div style="background-color: <?php echo $options['text_color'];?>">
					</div>
				</div>
				<input class="color-picker" name="sod_drawer_options[text_color]" id="sod_drawer_options[text_color]" type="text" value="<?php echo $options['text_color'];?>" />
			</td>
		</tr>
		<tr valign="top">
        	<th scope="row">
        		<h3>Link Color</h3>
			</th>
			<td>
				<div class="colorSelector left">
					<div style="background-color: <?php echo $options['link_color'];?>">
					</div>
				</div>
				<input class="color-picker" name="sod_drawer_options[link_color]" id="sod_drawer_options[link_color]" type="text" value="<?php echo $options['link_color'];?>" />
			</td>
        </tr>
    </table>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<div class="sod-donation">
	<div class="left one-third">
		<h3>Did you find this useful?</h3>
		<p>We're all part of the Wordpress eco-system, so let's keep things going. If you like our work, if it saved you some time, or you just want to say thanks, please consider donating what you can.</p>
	</div>
	<div class="left one-third">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="PVF396GDPYPNE">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</div>
</div>
<?php } ?>