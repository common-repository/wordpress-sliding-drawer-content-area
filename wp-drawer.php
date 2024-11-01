<?php
/*
Plugin Name: 61 Designs Drawer Plugin
Plugin URI: http://sixtyonedesigns.com
Description: Adds a fully customizeable widget area and sliding drawer to the top of your theme
Version: 1.0
Author: 61 Designs
Author URI: http://sixtyonedesigns.com
License: A "Slug" license name e.g. GPL2
*/
?>
<?php
/*On the fly CSS
 *add link to custom css
 */
function sod_drawer_header_items(){
	?>
	<link rel='stylesheet' type='text/css' href="<?php echo home_url(); ?>/?drawer-css=css" />
	<?php
}
/*Hook into wordpress head */
add_action('wp_head','sod_drawer_header_items');

// hook into the new dynamic stylesheet created below
add_action( 'parse_request', 'sod_drawer_custom_wp_request' );
function sod_drawer_custom_wp_request( $wp ) {
	$options = get_option('sod_drawer_options');
    if (
        !empty( $_GET['drawer-css'] )
        && $_GET['drawer-css'] == 'css'
        
    ) {
        # get theme options
      
	header( 'Content-Type: text/css' );
	$width;
	$handle_position = $options['vertical_handle_position'];
		switch($handle_position){
			case 'top':
				$handle_position = "7%;";
				break;
			case 'middle':
				$handle_position = "40%;";
				break;
			case 'bottom':
				$handle_position = "93%;";
				break;
		}
		if(substr($options['drawer_width'], -2) !="px"){
			$width =  $options['drawer_width']."px"; 
		}else{
			$width =  $options['drawer_width'];
		}
		if($options['drawer_grid_width']==''){
			$gridwidth="100&";
		}else{
			if(substr($options['drawer_grid_width'], -2) !="px" && substr($options['drawer_grid_width'], -1) !="%" ){
				$gridwidth =  $options['drawer_grid_width']."px"; 
			}else{
				$gridwidth =  $options['drawer_grid_width'];
			}
		}
?>
 
/*--------------------------drawer elements --------------------------*/
#sod-drawer-plugin.right,#sod-drawer-plugin.left{
	width:<?php echo $width;?>;
	background:<?php echo $options['color'];?>;
}
#sod-drawer-plugin.right #sod-drawer-handle,#sod-drawer-plugin.left #sod-drawer-handle{
	background-color:<?php echo $options['color'];?>;
	top:<?php echo $handle_position;?>;	
}
#sod-drawer-plugin.top .content,#sod-drawer-plugin.bottom .content{
	background:<?php echo $options['color'];?>;
	
}
#sod-drawer-plugin.top .content .sod-drawer-inner,#sod-drawer-plugin.bottom .content .sod-drawer-inner{
	width:<?php echo $gridwidth;?>;
}
#sod-drawer-plugin.top #sod-drawer-handle,#sod-drawer-plugin.bottom #sod-drawer-handle{
	background-color:<?php echo $options['color'];?>;
}
#sod-drawer-plugin #sod-drawer-handle .tag{
	color:<?php echo $options['handle_text_color'];?>;
}
#sod-drawer-plugin,
#sod-drawer-plugin h1,
#sod-drawer-plugin h2, 
#sod-drawer-plugin h3, 
#sod-drawer-plugin h4, 
#sod-drawer-plugin h5, 
#sod-drawer-plugin h6,
#sod-drawer-plugin p, 
#sod-drawer-plugin span, 
#sod-drawer-plugin li   
{
	color:<?php echo $options['text_color'];?> ;
	font-family:Arial, HelveticaNeue, Helvetica, sans-serif;
}
 #sod-drawer-plugin h1 a,
 #sod-drawer-plugin h2 a,
 #sod-drawer-plugin h3 a,
 #sod-drawer-plugin h4 a,
 #sod-drawer-plugin h5 a,
 #sod-drawer-plugin h6 a, 
 #sod-drawer-plugin a, 
 #sod-drawer-plugin span a,
 #sod-drawer-plugin li a{
 	color:<?php echo $options['link_color'];?>;
 	font-family:Arial, HelveticaNeue, Helvetica, sans-serif;
 }

<?php
        exit;
    }
}
function sod_drawer_plugins_js_css(){
	wp_enqueue_script("jquery");
	wp_register_style('sod_drawer_css', plugin_dir_url(__FILE__) . 'css/style.css', false, '1.0.0' );
	wp_register_script('sod_drawer_js', plugin_dir_url(__FILE__) . 'js/sod_drawer.js');
	wp_enqueue_style( 'sod_drawer_css' );
	wp_enqueue_script("sod_drawer_js");

}
add_action('init','sod_drawer_plugin_columns');
add_action('wp_enqueue_scripts', 'sod_drawer_plugins_js_css');
// footer widgets display
function sod_drawer_plugin_columns(){
	include_once dirname(__FILE__) . '/options.php';
	$options = get_option('sod_drawer_options');
	$num_cols = $options['widget_areas'];	
	$i = 1;
    while($i <= $num_cols) {
        $widget_id = 'sod-drawer-'.$i;
        $info = array (
            'name' => 'Drawer Plugin Widget #'.$i,
            'id' => $widget_id,
            'before_widget' => '<div id="%1$s" class="sod-drawer-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>'
        );
        register_sidebar($info);
        $i++;
    }
}
// build footer widget display that will be called from footer.php - something like: footer_widget_display();
function sod_drawer_content(){
	$options = get_option('sod_drawer_options');
	$num_cols = $options['widget_areas'];
	$styles;
	if($options['position']=='right'||$options['position']=='left'){
		$handle_options = 'rotate';
		echo '<div class="sod-drawer '.$options['position'].'" id="sod-drawer-plugin" >';
		echo '	<div id="sod-drawer-handle" class="pull black '.$handle_options.'" style=""><div class="tag"><p>'.$options['handle_text'].'</p></div></div>';
		echo '	<div class="content" >';
		echo '	<div class="sod-drawer-inner">';
	} elseif($options['position']=='bottom'||$options['position']=='top'){
		$handle_options = $options['handle_position'];
		echo '<div class="sod-drawer '.$options['position'].'" id="sod-drawer-plugin">';
		echo '	<div id="sod-drawer-handle" class="pull black '.$handle_options.'"><div class="tag">'.$options['handle_text'].'</div></div>';
		echo '	<div class="content">';
		echo '	<div class="sod-drawer-inner">';
	}
	switch($num_cols) {
		case 1:
			$widget_class = 'full';
			break;
		case 2:
			$widget_class = 'half';
			break;
		case 3:
			$widget_class = 'third';
			break;
		case 4:
			$widget_class = 'quarter';
			break;
	}
	$i = 1;
	while($i <= $num_cols) {
		$widget_id = 'sod-drawer-'.$i;
		if ($i==$num_cols){
				$widget_class .= '';
		};	
		echo '<div class="'.$widget_class.'" id="'.$widget_id.'">';
				dynamic_sidebar($widget_id);
		echo '</div>';
		$i++;
	}
	echo '	</div>'; 
	echo '	</div>';
	echo '</div>'; 
}
add_action('wp_footer','sod_drawer_content');
?>