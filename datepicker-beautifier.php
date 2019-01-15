<?php
/*
    Plugin Name: DatePicker Beautifier
    Plugin URI: https://edensolutions.co.in
    Description: Plugin to beautify datepicker for PREMIER LISTER by Eden Solutions
    Author: Zainul Abideen
    Version: 1.0
    Author URI: https://edensolutions.co.in
*/

function dpb_enqueue_script() {   
    wp_enqueue_script( 'main-js', plugin_dir_url( __FILE__ ) . 'js/main.js' );
    wp_localize_script( 'main-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
}
add_action('wp_enqueue_scripts', 'dpb_enqueue_script');


function dpb_datepicker_styles(){ ?>
	<style>
		.ui-datepicker select {
			-webkit-appearance: none!important;
			-moz-appearance: none!important;
			text-indent: 1px!important;
			text-overflow: ''!important;
			border: none;
		}
		.ui-datepicker-title select{
			background-color: #FC4740!important;
			font-size: 18px!important;
			font-family: inherit;
			margin: 0!important;
			color: #fff!important;
		}
		.ui-datepicker-header{
			background-color: #FC4740
		}
		.ui-datepicker-prev span{
			color: #fff!important;
		}
		.ui-datepicker-next, .ui-datepicker-prev{
			line-height: 300%!important;
			font-size: 18px!important;
			background-image: url()!important;
			display: block!important;
			height: 48px!important;
			font-size: 18px!important;
			color: #fff!important;
		}
		.ui-datepicker, .ui-datepicker-header{
			border-radius: 8px 8px 0 0;
		}
		.ui-datepicker-calendar thead tr{
			background-color: #FC4740!important;
		}
		.ui-datepicker th{
			text-shadow: none;
			color: #fff;
		}
		.ui-datepicker a{
			border: none;
		}
		.ui-datepicker tbody td, .ui-datepicker tbody tr, .ui-datepicker thead{
			border: none;
		}
		.ui-datepicker-calendar .ui-state-default{
			background: #fff;
		}
		.ui-datepicker-today a{
			background: #FC4740!important;
			color: #fff!important;
			border-radius: 71px;
			text-shadow: none!important;
		}
		.ui-datepicker-calendar{
			background-color: #fff;
		}
		.ui-datepicker-year{
			padding: 0;
			font-family: inherit;
			width: auto!important;
			background-color: #F9F9F9;
		}
		.ui-datepicker-footer{
			padding: 20px;
			text-align: center;
			background-color: #F9F9F9;
		}
		.ui-datepicker-next-year, .ui-datepicker-prev-year{
			cursor: pointer;
			font-family: inherit;
			font-size: 16px;
		}
		.ui-datepicker-next-year{
			float: right;
		}
		.ui-datepicker-prev-year{
			float: left;
		}
	</style><?php
}
add_action("wp_footer", "dpb_datepicker_styles");







/*function my_function($placement, $form_id) {
    if( $placement == 500 ) {
		$form = GFAPI::get_form( $form_id ); ?>
		<script type="text/javascript">
			jQuery(document).on('gform_load_field_settings', function(event, field) {
				// custom JS code here
				if(field.type == "date"){
					
				}
			});
		</script><?php
    }
}
add_action( 'gform_field_appearance_settings', 'my_function', 10, 2 );*/



add_action( 'gperk_field_settings', 'dpb_calendar_appearance' ) ;
function dpb_calendar_appearance() {
    ?>

    <li class="dpb-calendar-appearance-setting field_setting">

        <input type="color" id="dpbca-header-color" onchange="SetFieldProperty( 'headerColor', this.value);">

        <label class="inline" for="dpbca-header-color">
            <?php 
				_e( 'Header Color' );
            	 gform_tooltip( 'dpbca-header-color-toolip' ); 
			?>
        </label>

    </li>

    <?php
}

add_action( 'gform_editor_js', 'field_settings_js' );
function field_settings_js() {
    ?>

<script type="text/javascript">
    (function($) {
        $(document).bind( 'gform_load_field_settings', function( event, field, form ) {
            // populates the stored value from the field back into the setting when the field settings are loaded
            $( '#dpbca-header-color' ).val(field['headerColor']);
            // if our desired condition is met, we show the field setting; otherwise, hide it
            if( GetInputType( field ) == 'date' ) {
                $( '.dpb-calendar-appearance-setting' ).show();
            } else {
                $( '.dpb-calendar-appearance-setting' ).hide();
            }
        } );
    })(jQuery);
</script>

<?php
}

add_filter( 'gform_input_mask_script', 'set_mask_script', 10, 4 );
function set_mask_script( $script, $form_id, $field_id, $mask ) {
    $script = "jQuery('#input_{$form_id}_{$field_id}').mask('" . esc_js( $mask ) . "',{placeholder:' '}).on('keypress', function(e){if(e.which == 13){jQuery(this).blur();} } );";
 
    return $script;
}

/*add_filter( 'gform_pre_form_settings_save', 'save_my_custom_form_setting' );
function save_my_custom_form_setting($form) {
    $form['my_custom_setting'] = rgpost( 'my_custom_setting' );
    return $form;
}*/