<?php

include_once 'config.php';

class Imager {

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * @var null|string
     */
    private $url = null;

    private $action = null;
    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Imager An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct(){

        if( isset( $_REQUEST['action'] ) ) {
            $this->action = $_REQUEST['action'];
        }

        $this->url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->includes();
        $content = $this->routing();
        if( $content ) {
            echo $content;
        }
    }

    public function includes() {
        foreach ( glob( Imager_Config()->config('root_dir').'/inc/*' ) as $k => $filename ) {
            include_once $filename;
        }
    }

    public function routing() {
        switch ( $this->action ) {
            case 'upload':
                return Imager_Media()->upload();
                break;
            case 'get-images':
                return Imager_Media()->get_images();
                break;
            case 'save-image':
                return Imager_Media()->save_image();
                break;
            default:
                include_once Imager_Config()->config('root_dir').'/templates/media-library.php';
                break;
        }
        return;
    }
}

function Imager() {
    return Imager::instance();
}

Imager();
