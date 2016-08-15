<?php
/**
 * Some helper functions for rendering wizard forms.
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @package odwp-devhelper
 * @since 0.1.0
 */

if ( ! function_exists( 'odwpdh_render_advanced_options_form' ) ) :

/**
 * Render common advanced options.
 * @param string $wizard_slug
 * @param boolean $display_description
 * @return string
 * @since 0.1.0
 *
 * @todo Move the function self into {@see DevHelper_Screen_Prototype::render_advanced_options()}.
 */
function render_advanced_options_form( $wizard_slug, $display_description ) {
  ob_start();
  include( DevHelper::plugin_path( 'partials/wizard-advanced_options.phtml' ) );
  $output = ob_get_clean();

  /**
   * Filter wizard advanced options (HTML with part of form in <tr> element).
   *
   * Name of filter corresponds with slug of the particular wizard.
   * For example for `Custom Post Type wizard` is filter name
   * "devhelper_cpt_wizard_advanced_options_form".
   *
   * @since 0.1.0
   *
   * @param string $output Rendered HTML.
   */
  return apply_filters( "devhelper_{$wizard_slug}_advanced_options_form", $output );
}

endif;


if ( ! function_exists( 'odwpdh_render_form_submit_buttons' ) ) :

/**
 * Render wizard form submit buttons.
 * @param string $wizard_slug
 * @return string
 * @since 0.1.0
 *
 * @todo Move the function self into {@see DevHelper_Screen_Prototype::render_submit_buttons()}.
 */
function odwpdh_render_form_submit_buttons( $wizard_slug ) {
  ob_start();
  include( DevHelper::plugin_path( 'partials/wizard-submit_buttons.phtml' ) );
  $output = ob_get_clean();

  /**
   * Filter wizard form submit buttons.
   *
   * Name of filter corresponds with slug of the particular wizard.
   * For example for `Custom Post Type wizard` is filter name
   * "devhelper_cpt_wizard_form_submit_buttons".
   *
   * @since 0.1.0
   *
   * @param string $output Rendered HTML.
   */
  return apply_filters( "devhelper_{$wizard_slug}_form_submit_buttons", $output );
}

endif;
