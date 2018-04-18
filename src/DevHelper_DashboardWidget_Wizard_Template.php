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

if( ! class_exists( 'DevHelper_DashboardWidget_Wizard_Template' ) ):

/**
 * Class describing template for dashboard widget wizard.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
class DevHelper_DashboardWidget_Wizard_Template extends DevHelper_Template_Prototype {

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
            array(
                'filename' => 'class-my_dashboard_widget.php',
                'filetype' => 'php',
            )
        );

		// Default template values
        $defaults = array(
            // Widget's own options
            //...
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
?>
// ...
<?php
    }

}

endif;