<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/odwp-devhelper for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package odwp-devhelper
 * @since 0.1.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'DevHelper_Template_Prototype' ) ) {
    include DH_PATH . 'src/DevHelper_Template_Prototype.php';
}

if( ! class_exists( 'DevHelper_Widget_Wizard_Template_File' ) ) {
	include DH_PATH . 'src/DevHelper_Widget_Wizard_Template_File.php';
}

if( ! class_exists( 'DevHelper_Widget_Wizard_Template' ) ):

/**
 * Class describing template for widget wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_Widget_Wizard_Template extends DevHelper_Template_Prototype {

    /**
     * Constructor.
     * 
     * @param array $files Optional.
     * @param array $values Optional.
     * @return void
     * @since 0.1.0
     */
    public function __construct( $files = array(), $defaults = array(), $values = array() ) {

		// Files which will be generated
        $files = array(
			0 => new DevHelper_Widget_Wizard_Template_File( 'class-my_widget.php', 'php' )
        );

		// Default template values
        $defaults = array(
            // Widget's own options
            'classname'      => __( 'My_Widget', DH_SLUG ),
            'title'          => __( 'My Widget', DH_SLUG ),
            'description'    => __( 'My awesome widget', DH_SLUG ),
            'has_options'    => false,
            // These are from `wizard-advanced_options.phtml`
            'use_textdomain' => true,
            'textdomain'     => 'textdomain',
            'textdomain_php' => null,
		);

		// Submitted (or default) values
		$values = $defaults;

		// Finalize class construction
		parent::__construct( $files, $defaults, $values );
    }

    /**
     * Render template preview.
     *
     * @param array $args Optional.
     * @since 0.1.0
     * @return void
     */
    public function preview( $args = array() ) {
		$values = array_merge( $this->values, $args );

?>
	<p class="description"><?php _e( 'Below are generated files that are required to get working WordPress plugin with new widget. You can copy source codes to clipboard or download it as a ZIP package.<br>You can also test these source files before using them.', DH_SLUG ); ?></p>
<?php

		foreach( $this->files as $file ) {
?>
	<h3><code><?php echo $file->filename?></code></h3>
	<pre><code class="language-<?php echo $file->filetype?>">&lt;?php
<?php $file->render( $values )?>
</code></pre>
<?php
		}
    }

}

endif;