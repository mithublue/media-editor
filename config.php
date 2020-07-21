<?php
/**
 * Defines the config data here
 */

class Imager_Config {

    protected $config = [

        /*
         * Defines the root directory
         * of the app
         */
        'root_dir' => __DIR__,

        /*
         * Defines if the app is in development, default is true
         */
        'development' => true,

        /*
         * Defines the app root url, it should be  url of the root
         * where the app is places, change it accordingly
         */
        'root_url' => 'http://localhost/interview/joomshaper/task/',

        /*
         * Defines the name of the folder where
         * the images will be saved
         */
        'gallery' => 'gallery/'
    ];

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
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Imager_Config An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function config( $name ) {
        if( isset( $this->config[$name] ) ) return $this->config[$name];
        return false;
    }
}

function Imager_Config() {
    return Imager_Config::instance();
}

Imager_Config();