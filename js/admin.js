jQuery(document).ready(function() {

  	var starting_value = jQuery('#position').attr('value');
		switch(starting_value){
   			case 'left':
   				jQuery('#drawer-width').show();
   				jQuery('#vertical-handle-position').show();
   				jQuery('#drawer-content-width').hide();
   				jQuery('#horizontal-handle-position').hide();
   				break;
   			case 'right':
   				jQuery('#vertical-handle-position').show();
   				jQuery('#drawer-content-width').hide();
   				jQuery('#drawer-width').show();
   				jQuery('#horizontal-handle-position').hide();
   				break;
			case 'bottom':
				jQuery('#drawer-width').hide();
				jQuery('#drawer-content-width').show();
				jQuery('#vertical-handle-position').hide();
   				jQuery('#horizontal-handle-position').show();
   				break;
			case 'top':
				jQuery('#drawer-width').hide();
				jQuery('#drawer-content-width').show();
				jQuery('#vertical-handle-position').hide();
   				jQuery('#horizontal-handle-position').show();
   				break;
   		}
	jQuery('#position').change(function(){
   		var value = jQuery(this).attr('value');
   		switch(value){
   			case 'left':
   				jQuery('#drawer-width').fadeIn();
   				jQuery('#drawer-content-width').fadeOut();
   				jQuery('#vertical-handle-position').fadeIn();
   				jQuery('#horizontal-handle-position').fadeOut();
   				break;
   			case 'right':
   				jQuery('#drawer-width').fadeIn();
   				jQuery('#drawer-content-width').fadeOut();
   				jQuery('#vertical-handle-position').fadeIn();
   				jQuery('#horizontal-handle-position').fadeOut();
   				break;
			case 'bottom':
				jQuery('#drawer-width').fadeOut();
				jQuery('#drawer-content-width').fadeIn();
				jQuery('#vertical-handle-position').fadeOut();
   				jQuery('#horizontal-handle-position').fadeIn();
				break;
			case 'top':
				jQuery('#drawer-width').fadeOut();
				jQuery('#drawer-content-width').fadeIn();
				jQuery('#vertical-handle-position').fadeOut();
   				jQuery('#horizontal-handle-position').fadeIn();
				break;
   		}
	});
});