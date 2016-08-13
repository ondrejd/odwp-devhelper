<?php
/**
 * Screen options form (for all screens is the same).
 *
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @package odwp-devhelper
 * @since 0.0.1
 */
?><div id="screen-options-wrap" class="hidden" aria-label="<?php esc_html_e( 'Screen Options Tab', DevHelper::SLUG ); ?>">
    <form name="<?php echo $slug; ?>-form" method="post">
        <?php echo wp_nonce_field( -1, $slug . '-nonce', true, false); ?>
        <input type="hidden" name="screen_name" value="<?php echo $screen->id; ?>">
        <fieldset>
          <legend><?php esc_html_e( 'Display detail description', DevHelper::SLUG ); ?></legend>
          <label for="<?php echo $slug; ?>-checkbox1" title="<?php esc_html_e( 'Show detail description by default.', DevHelper::SLUG ); ?>">
            <input type="checkbox" name="<?php echo $slug; ?>-checkbox1" id="<?php echo $slug; ?>-checkbox1" <?php checked( $display_description ); ?>>
            <?php esc_html_e( 'Check if you want see detailed description.', DevHelper::SLUG ); ?>
          </label>
        </fieldset>
        <fieldset>
            <legend><?php esc_html_e( 'Select source code template' ); ?></legend>
            <label for="<?php echo $slug; ?>-select1" title="<?php esc_html_e( 'Select source code template', DevHelper::SLUG ); ?>"><?php esc_html_e( 'Used template:', DevHelper::SLUG ); ?></label>
            <select name="<?php echo $slug; ?>-select1" id="<?php echo $slug; ?>-select1">
              <?php foreach ( $templates as $tpl_key => $tpl_lbl ) : ?>
              <option value="<?php echo $tpl_key; ?>"<?php selected( $used_template, $tpl_key ); ?>><?php echo $tpl_lbl; ?></option>
              <?php endforeach; ?>
            </select>
        </fieldset>
        <p class="submit">
          <input type="submit" name="<?php echo $slug; ?>-submit" value="<?php esc_html_e( 'Apply', DevHelper::SLUG ); ?>" class="button button-primary">
        </p>
    </form>
</div>
