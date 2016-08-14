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
 */
function odwpdh_render_advanced_options_form( $wizard_slug, $display_description ) {
  ob_start();
?>
<tr>
  <th scope="row">
    <label for="plugin-advanced"><?php _e( 'Advanced', DevHelper::SLUG ); ?></label>
  </th>
  <td>
    <fieldset id="plugin-advanced">
      <label for="plugin-use_textdomain">
        <input type="checkbox" name="use_textdomain" id="plugin-use_textdomain">
        <?php _e( 'Use textdomain', DevHelper::SLUG ); ?>
        <input type="text" name="textdomain" id="plugin-textdomain" class="short-text" placeholder="<?php esc_html_e( 'Enter textdomain', DevHelper::SLUG ); ?>" disabled="disabled">
      </label>
      <?php if ( $display_description === true ): ?>
      <p id="use_textdomain_description" class="description">
        <?php _e( '<code>XXX</code> Add detail description (with screenshot)!', DevHelper::SLUG ); ?></p>
      <?php endif;?>
    </fieldset>
  </td>
</tr>
<?php
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
 */
function odwpdh_render_form_submit_buttons( $wizard_slug ) {
  ob_start();
?>
<!-- TODO Add spinner and make this works via AJAX (with safe-fall to plain POST and PHP) -->
<input type="submit" name="wizard-submit1" value="<?php _e( 'Generate', DevHelper::SLUG ); ?>" class="button-primary">
<input type="submit" name="wizard-submit2" value="<?php _e( 'Download', DevHelper::SLUG ); ?>" class="button">
<input type="submit" name="wizard-submit3" value="<?php _e( 'Test', DevHelper::SLUG ); ?>" class="button">
<?php
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
