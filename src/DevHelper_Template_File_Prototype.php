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

if( ! class_exists( 'DevHelper_Template_File_Prototype' ) ) :

/**
 * Abstract class that represents single template's file.
 * 
 * @author Ondřej Doněk, <ondrejd@gmail.com>
 * @since 0.1.0
 */
abstract class DevHelper_Template_File_Prototype {
    
    /**
     * @var string $filename
     * @since 0.1.0
     */
    public $filename;
    
    /**
     * @var string $filetype
     * @since 0.1.0
     */
    public $filetype;
    
    /**
     * @var array $values
     * @since 0.1.0
     */
    public $values = array();

    /**
     * Constructor.
     * 
     * @param string $filename
     * @param string $filetype
     * @param array $values Optional.
     * @return void
     * @since 0.1.0
     */
    public function __construct( $filename, $filetype, $values = array() ) {
        $this->filename = $filename;
        $this->filetype = $filetype;

        if( ! is_array( $values ) ) {
            $this->values = array();
        } else {
            $this->values = $values;
        }
    }

    /**
     * Render template file.
     * 
     * @param array $values
     * @return string
     * @since 0.1.0
     */
    abstract public function render( $values = array() );

    /**
     * @internal Return localizable string as localized or not based on values.
     * @param string $str
     * @param boolean $echo Optional.
     * @return string
     * @since 0.1.0
     */
    public function textdomainize( $str, $echo = true ) {
        $out = $str;

        if( $this->values[ 'use_textdomain'] ) {
            if( ! empty( $this->values['textdomain_php'] ) ) {
                $out = "__( '$str', {$this->values['textdomain_php']} )";
            }
            else {
                $out = "__( '$str', '{$this->values['textdomain']}' )";
            }
        } else {
            $out = "'$str'";
        }

        if( $echo === true ) {
            echo $out;
        }

        return $out;
    }

    /**
     * @internal Use this only when you know that template using textdomain!
     * @return string
     * @since 0.1.0
     */
    public function get_textdomain_as_str_arg() {
        
        if( ! empty( $this->values['textdomain_php'] ) ) {
            return $this->values['textdomain_php'];
        }
        elseif( ! empty( $this->values['textdomain'] ) ) {
            return "'" . $this->values['textdomain'] . "'";
        }

        return "''";
    }

}

endif;
