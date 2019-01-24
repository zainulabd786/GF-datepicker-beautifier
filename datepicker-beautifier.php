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


function dpb_datepicker_styles($args){ ?>
	<div class="dpb-styles">
	<style>
		.ui-datepicker-week-end{
			color: red;
		}
		
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
			background-color: <?= $args['headerColor'] ?>
		}
		.ui-datepicker-header{
			border-width: 0px 0 0 !important;
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
			text-shadow: none !important;
		}
		.ui-datepicker tbody td, .ui-datepicker tbody tr, .ui-datepicker thead{
			border: none;
		}
		.ui-datepicker-calendar .ui-state-default{
			background: #fff;
			-webkit-box-shadow: none !important;
			box-shadow: none !important;
			text-shadow: none !important; 
		}
		 .ui-datepicker-footer{
			border-radius: 0 0 8px 8px;
		}
		.ui-datepicker{
			box-shadow: 0 0 32px 0 rgba(0, 0, 0, 0.1);
			/*-webkit-box-shadow: none !important;
			box-shadow: none !important;*/
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
			margin-top: -10px
			/*background-color: #F9F9F9;*/
		}
		.ui-datepicker-next-year, .ui-datepicker-prev-year{
			cursor: pointer;
			font-family: inherit;
			font-size: 16px;
			font-weight: bolder;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.ui-datepicker-next-year{
			float: right;
		}
		.ui-datepicker-prev-year{
			float: left;
		}
		.ui-datepicker-calendar .ui-state-active{
			border: none!important;
		}
	</style>
	</div><?php
}
add_action("wp_footer", "dpb_datepicker_styles");


add_action("wp_ajax_get_field_object", "get_field_object");
add_action("wp_ajax_nopriv_get_field_object", "get_field_object");
function get_field_object(){
	$form = GFAPI::get_form( $_POST['formID'] );
	echo json_encode($form);
	//echo "<pre>"; print_r($form); echo "</pre>";
	wp_die();
}

//add_action( 'gperk_field_settings', 'dpb_calendar_appearance' ) ;
add_action( 'gform_field_appearance_settings', 'dpb_calendar_appearance', 10, 2 );
function dpb_calendar_appearance($placement, $form_id) {
	$form = GFAPI::get_form( $form_id );
	//echo "<pre>"; print_r($form); echo "</pre>";
	if( $placement == 500 ) {
    ?>
	<h3 class="dpb-calendar-appearance-setting">
		Datepicker Settings	
	</h3>
	<li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-calendar-size">
            <?php 
				_e( 'Calendar Size' );
			?>
        </label>
        <select id="dpbca-calendar-size"  onchange="SetFieldProperty( 'calendarSize', this.value);">
			<option value="sm" selected>Small</option>
			<option value="md">Medium</option>
			<option value="lg">large</option>
		</select>
    </li>
	<h4 class="dpb-calendar-appearance-setting">
		Header
	</h4>
    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-header-color">
            <?php 
				_e( 'Header Color' );
			?>
        </label>
        <input type="color" id="dpbca-header-color"  onchange="SetFieldProperty( 'headerColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-header-font-size">
            <?php 
				_e( 'Font Size' );
			?>
        </label>
        <input type="text" id="dpbca-header-font-size" onchange="SetFieldProperty( 'headerFontSize', this.value);" placeholder="in pixels">
    </li>

	<li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-header-arrows-color">
            <?php 
				_e( 'Header Arrows Color' );
			?>
        </label>
        <input type="color" id="dpbca-header-arrows-color" onchange="SetFieldProperty( 'headerArrowsColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-header-padding">
            <?php 
				_e( 'Header Padding' );
			?>
        </label>
        <input type="text" id="dpbca-header-padding" onchange="SetFieldProperty( 'headerPadding', this.value);">
    </li>
    
    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-header-arrow-size">
            <?php 
				_e( 'Header Arrow Size' );
			?>
        </label>
        <input type="text" id="dpbca-header-arrow-size" onchange="SetFieldProperty( 'headerArrowSize', this.value);">
    </li>
    <h4 class="dpb-calendar-appearance-setting">
		Week Strip
	</h4>
	<li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-weeks-strip-color">
            <?php 
				_e( 'Weeks Strip Background' );
			?>
        </label>
        <input type="color" id="dpbca-weeks-strip-color" onchange="SetFieldProperty( 'weekStripColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-week-strip-font-size">
            <?php 
				_e( 'Week Font Size' );
			?>
        </label>
        <input type="text" id="dpbca-week-strip-font-size" onchange="SetFieldProperty( 'weekStripFontSize', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-week-strip-font-color">
            <?php 
				_e( 'Week Font color' );
			?>
        </label>
        <input type="color" id="dpbca-week-strip-font-color" onchange="SetFieldProperty( 'weekStripFontColor', this.value);">
    </li>
	<h4 class="dpb-calendar-appearance-setting">
		Calendar Body
	</h4>
    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-date-font-size">
            <?php 
				_e( 'Date Font Size' );
			?>
        </label>
        <input type="text" id="dpbca-date-font-size" onchange="SetFieldProperty( 'dateFontSize', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-date-font-color">
            <?php 
				_e( 'Date Font Color' );
			?>
        </label>
        <input type="color" id="dpbca-date-font-color" onchange="SetFieldProperty( 'dateFontColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-date-padding">
            <?php 
				_e( 'Date Padding' );
			?>
        </label>
        <input type="text" id="dpbca-date-padding" onchange="SetFieldProperty( 'datePadding', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-date-background-color">
            <?php 
				_e( 'Date Background Color' );
			?>
        </label>
        <input type="color" id="dpbca-date-background-color" onchange="SetFieldProperty( 'dateBackgroundColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-highlighted-date-font-size">
            <?php 
				_e( 'Highlated Date Font Size' );
			?>
        </label>
        <input type="text" id="dpbca-highlighted-date-font-size" onchange="SetFieldProperty( 'highlatedDateFontSize', this.value);">
    </li>

	<li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-highlighted-date-line-height">
            <?php 
				_e( 'Highlighted Date Line Height' );
			?>
        </label>
        <input type="text" id="dpbca-highlighted-date-line-height" onchange="SetFieldProperty( 'highlatedDateLineHeight', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-highlighted-date-font-color">
            <?php 
				_e( 'Highlated Date Font Color' );
			?>
        </label>
        <input type="color" id="dpbca-highlighted-date-font-color" onchange="SetFieldProperty( 'highlatedDateFontColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-highlighted-date-background-color">
            <?php 
				_e( 'Highlated Date Background Color' );
			?>
        </label>
        <input type="color" id="dpbca-highlighted-date-background-color" onchange="SetFieldProperty( 'highlatedDateBackgroundColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-highlighted-date-border-radius">
            <?php 
				_e( 'Highlated Date Border Radius' );
			?>
        </label>
        <input type="text" id="dpbca-highlighted-date-border-radius" onchange="SetFieldProperty( 'highlatedDateBorderRadius', this.value);">
    </li>
	<li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-disabled-date-color">
            <?php 
				_e( 'Disabled Date Color' );
			?>
        </label>
        <input type="color" id="dpbca-disabled-date-color" onchange="SetFieldProperty( 'disableDateColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-disabled-date-background-color">
            <?php 
				_e( 'Disabled Date Background Color' );
			?>
        </label>
        <input type="color" id="dpbca-disabled-date-background-color" onchange="SetFieldProperty( 'disableDateBackgroundColor', this.value);">
    </li>
	<h4 class="dpb-calendar-appearance-setting">
		Footer
	</h4>
    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-footer-background-color">
            <?php 
				_e( 'Footer Background Color' );
			?>
        </label>
        <input type="color" id="dpbca-footer-background-color" onchange="SetFieldProperty( 'footerBackgroundColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-footer-font-color">
            <?php 
				_e( 'Footer Font Color' );
			?>
        </label>
        <input type="color" id="dpbca-footer-font-color" onchange="SetFieldProperty( 'footerFontColor', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-footer-arrow-color">
            <?php 
				_e( 'Footer Arrow Color' );
			?>
        </label>
        <input type="color" id="dpbca-footer-arrow-color" onchange="SetFieldProperty( 'footerArrowColor', this.value);">
    </li>

     <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-footer-arrow-size">
            <?php 
				_e( 'Footer Arrow Size' );
			?>
        </label>
        <input type="text" id="dpbca-footer-arrow-size" onchange="SetFieldProperty( 'footerArrowSize', this.value);">
    </li>

    <li class="dpb-calendar-appearance-setting field_setting">
        <label for="dpbca-footer-font-size">
            <?php 
				_e( 'Footer Font Size' );
			?>
        </label>
        <input type="text" id="dpbca-footer-font-size" onchange="SetFieldProperty( 'footerFontSize', this.value);">
    </li>    
    <?php
	}
}

add_action( 'gform_editor_js', 'field_settings_js' );
function field_settings_js() { ?>
	<script type="text/javascript">
	    (function($) {
	        $(document).bind( 'gform_load_field_settings', function( event, field, form ) {
	            // populates the stored value from the field back into the setting when the field settings are loaded
	            $( '#dpbca-calendar-size' ).val(field['calendarSize']);
	            $( '#dpbca-header-color' ).val(field['headerColor']);
				$( '#dpbca-header-font-size' ).val(field['headerFontSize']);
				$( '#dpbca-header-arrows-color' ).val(field['headerArrowsColor']);
				$( '#dpbca-header-padding' ).val(field['headerPadding']);
				$( '#dpbca-header-arrow-size' ).val(field['headerArrowSize']);
				$( '#dpbca-weeks-strip-color' ).val(field['weekStripColor']);
				$( '#dpbca-week-strip-font-size' ).val(field['weekStripFontSize']);
				$( '#dpbca-week-strip-font-color' ).val(field['weekStripFontColor']);
				$( '#dpbca-date-font-size' ).val(field['dateFontSize']);
				$( '#dpbca-date-font-color' ).val(field['dateFontColor']);
				$( '#dpbca-date-padding' ).val(field['datePadding']);
				$( '#dpbca-date-background-color' ).val(field['dateBackgroundColor']);
				$( '#dpbca-highlighted-date-font-size' ).val(field['highlatedDateFontSize']);
				$( '#dpbca-highlighted-date-line-height' ).val(field['highlatedDateLineHeight']);
				$( '#dpbca-highlighted-date-font-color' ).val(field['highlatedDateFontColor']);
				$( '#dpbca-highlighted-date-background-color' ).val(field['highlatedDateBackgroundColor']);
				$( '#dpbca-highlighted-date-border-radius' ).val(field['highlatedDateBorderRadius']);
				$( '#dpbca-disabled-date-color' ).val(field['disableDateColor']);
				$( '#dpbca-disabled-date-background-color' ).val(field['disableDateBackgroundColor']);
				$( '#dpbca-footer-background-color' ).val(field['footerBackgroundColor']);
				$( '#dpbca-footer-font-color' ).val(field['footerFontColor']);
				$( '#dpbca-footer-arrow-color' ).val(field['footerArrowColor']);
				$( '#dpbca-footer-arrow-size' ).val(field['footerArrowSize']);
				$( '#dpbca-footer-font-size' ).val(field['footerFontSize']);
	            // if our desired condition is met, we show the field setting; otherwise, hide it
	            if( GetInputType( field ) == 'date' ) {
	                $( '.dpb-calendar-appearance-setting' ).show();
	            } else {
	                $( '.dpb-calendar-appearance-setting' ).hide();
	            }
	        } );
	    })(jQuery);
	</script> <?php
}
