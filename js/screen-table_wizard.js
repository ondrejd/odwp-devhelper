/**
 * JavaScripts for "Patterns Library -> jQuery UI Components" page.
 */

// TODO Translate strings!
jQuery( document ).on( 'ready', function() {
	console.log( "Hello from 'patterns-tables.js'!" );

	// Arguments
	jQuery( '#plugin-set_plural' ).prop( 'checked', false );
	jQuery( '#plugin-set_plural' ).on( 'change', function() {
		if ( jQuery( this ).prop( 'checked' ) ) {
			jQuery( '#plugin-plural' ).removeProp( 'disabled' );
		} else {
			jQuery( '#plugin-plural' ).prop( 'disabled', true );
		}
	});
	jQuery( '#plugin-set_singular' ).prop( 'checked', false );
	jQuery( '#plugin-set_singular' ).on( 'change', function() {
		if ( jQuery( this ).prop( 'checked' ) ) {
			jQuery( '#plugin-singular' ).removeProp( 'disabled' );
		} else {
			jQuery( '#plugin-singular' ).prop( 'disabled', true );
		}
	});
	jQuery( '#plugin-set_screen' ).prop( 'checked', false );
	jQuery( '#plugin-set_screen' ).on( 'change', function() {
		if ( jQuery( this ).prop( 'checked' ) ) {
			jQuery( '#plugin-screen' ).removeProp( 'disabled' );
		} else {
			jQuery( '#plugin-screen' ).prop( 'disabled', true );
		}
	});

	// Views
	jQuery( '#plugin-use_views' ).prop( 'checked', false );
	jQuery( '#use_views_area' ).hide();
	jQuery( '#use_views_description' ).show();
	jQuery( '#plugin-use_views' ).on( 'change', function() {
		if ( jQuery( this ).prop( 'checked' ) ) {
			jQuery( '#use_views_description' ).hide();
			jQuery( '#use_views_area' ).show();
		} else {
			jQuery( '#use_views_area' ).hide();
			jQuery( '#use_views_description' ).show();
		}
	});

	// Bulk actions
	jQuery( '#plugin-use_bulkactions' ).prop( 'checked', false );
	jQuery( '#use_bulkactions_area' ).hide();
	jQuery( '#use_bulkactions_description' ).show();
	jQuery( '#plugin-use_bulkactions' ).on( 'change', function() {
		if ( jQuery( this ).prop( 'checked' ) ) {
			jQuery( '#use_bulkactions_description' ).hide();
			jQuery( '#use_bulkactions_area' ).show();
		} else {
			jQuery( '#use_bulkactions_area' ).hide();
			jQuery( '#use_bulkactions_description' ).show();
		}
	} );

	// Data sources
	function ds_fieldset_disable() {
		jQuery( '#plugin-ds_php_source' ).prop( 'checked', false );
		jQuery( '#ds_php_source-import' ).prop( 'checked', false );
		jQuery( '#ds_php_source-array' ).prop( 'checked', false );
		jQuery( '#plugin-ds_wp_data' ).prop( 'checked', false );
		jQuery( '[name="ds_wp_data-radio"]' ).prop( 'checked', false );
		jQuery( '#plugin-ds_db_table' ).prop( 'checked', false );
		jQuery( '#plugin-ds_ext_uri' ).prop( 'checked', false );
		jQuery( '#plugin-ds_fieldset input' ).prop( 'disabled', true );
		jQuery( '#plugin-ds_fieldset textarea' ).prop( 'disabled', true );
		jQuery( '#plugin-ds_php_source' ).prop( 'checked', false );
		jQuery( '#plugin-ds_wp_data' ).removeProp( 'disabled' );
		jQuery( '#plugin-ds_db_table' ).removeProp( 'disabled' );
		jQuery( '#plugin-ds_ext_uri' ).removeProp( 'disabled' );
	}
	function ds_fieldset_update() {
		ds_fieldset_disable();
		if ( jQuery( '#plugin-ds_php_source' ).prop( 'checked' ) ) {
			jQuery( '#ds_php_source-area input[type="radio"]' ).removeProp( 'disabled' );
			jQuery( '#ds_db_table-textarea' ).prop( 'disabled', true );
			jQuery( '[name="ds_php_source-radio"]').prop( 'disabled', true );
		}
		if ( jQuery( '#plugin-ds_wp_data' ).prop( 'checked' ) ) {
			jQuery( '[name="ds_php_source-radio"]').removeProp( 'disabled' );
			jQuery( '#ds_db_table-textarea' ).prop( 'disabled', true );
			jQuery( '#ds_php_source-area input' ).prop( 'disabled', true );
			jQuery( '#ds_php_source-area textarea' ).prop( 'disabled', true );
		}
		if ( jQuery( '#plugin-ds_db_table' ).prop( 'checked' ) ) {
			jQuery( '#ds_db_table-textarea' ).removeProp( 'disabled' );
			jQuery( '[name="ds_php_source-radio"]').prop( 'disabled', true );
			jQuery( '#ds_php_source-area input' ).prop( 'disabled', true );
			jQuery( '#ds_php_source-area textarea' ).prop( 'disabled', true );
		}
		if ( jQuery( '#ds_php_source-import' ).prop( 'checked' ) ) {
			jQuery( '#ds_php_source-import_csv' ).removeProp( 'disabled' );
			jQuery( '#ds_php_source-import_php' ).removeProp( 'disabled' );
			jQuery( '#ds_php_source-textarea' ).prop( 'disabled', true );
			jQuery( '#ds_php_source-array_parse' ).prop( 'disabled', true );
		}
		if ( jQuery( '#ds_php_source-array' ).prop( 'checked' ) ) {
			jQuery( '#ds_php_source-textarea' ).removeProp( 'disabled' );
			jQuery( '#ds_php_source-array_parse' ).removeProp( 'disabled' );
			jQuery( '#ds_php_source-import_csv' ).prop( 'disabled', true );
			jQuery( '#ds_php_source-import_php' ).prop( 'disabled', true );
		}
		// ...
	}
	jQuery( '#plugin-ds_fieldset input[type="radio"]' ).on( 'change', ds_fieldset_update );

	ds_fieldset_disable();
	ds_fieldset_update();
	// ...
	
	
	jQuery( '#plugin-ds_ext_uri' ).on( 'change', function() {
		// ...
	});

	// Textdomain
	jQuery( '#plugin-use_textdomain' ).on( 'change', function() {
		if ( jQuery( this ).prop( 'checked' ) ) {
			jQuery( '#plugin-textdomain' ).removeProp( 'disabled' );
		} else {
			jQuery( '#plugin-textdomain' ).prop( 'disabled', true );
		}
	} );
});