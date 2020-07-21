<?php

class Imager_Media
{
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
     * @return Imager_Media An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Fetch the media files for gallery
     *
     * @return array
     */
    public function get_media_files() {
        return glob( Imager_Config()->config( 'root_dir' ).'/gallery/*');
    }

    /**
     * Upload image functinality
     *
     * @return string
     */
    public function upload() {
        $target_dir = "./gallery/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $data = [
            'success' => false,
            'msg' => ''
        ];

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);

            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        // Check if $uploadOk is set to 0 by an error
        if ( !$uploadOk ) {

            $data = [
                'success' => false,
                'msg' => 'Sorry, your file was not uploaded.'
            ];

        } else {

            if ( move_uploaded_file( $_FILES["image"]["tmp_name"], $target_file)) {

                $data = [
                    'success' => true,
                    'msg' => "The file ". basename( $_FILES["image"]["name"]). " has been uploaded."
                ];
            } else {

                $data = [
                    'success' => false,
                    'msg' => "Sorry, there was an error uploading your file."
                ];
            }
        }

        return json_encode( $data );
    }

    /**
     * Return  the images stored in
     * gallery folder with image data
     *
     * @return string
     */
    public function get_images() {
        //get images
        $images = [];

        foreach( glob(Imager_Config()->config('root_dir').'/gallery/*.*') as $k => $filename ) {
            $images[] = [
                'url' => Imager_Config()->config( 'root_url' ).Imager_Config()->config( 'gallery' ).pathinfo( $filename )['basename'],
                'name' => pathinfo( $filename )['basename']
            ];
        }

        //get image data
        $enc_data = file_get_contents( Imager_Config()->config('root_dir').'/data.txt' );
        $enc_data = explode("\n", $enc_data );
        $image_data = [];

        foreach ( $enc_data as $k => $each_line ) {
            if( !$each_line ) continue;
            $each_line = explode( '|', $each_line );
            if( count( $each_line ) < 2 ) continue;
            $image_data[$each_line[0]] = json_decode( base64_decode($each_line[1]) );
        }

        return json_encode([
            'images' => $images,
            'image_data' => $image_data
        ]);
    }

    /**
     * Save the image
     * with modification
     */
    public function save_image() {
        //create file to save applied modification
        $imagename = json_decode( $_POST['imgObj'], true )['name'];
        $applied_data = base64_encode( $_POST['applied_data'] );
        $file = 'data.txt';
        $current = explode( "\n", file_get_contents($file));

        //check if the image already have style
        $existing = null;
        foreach ( $current as $k => $img_data ) {
            if ( strstr( $img_data, $imagename ) ) {
                $img_data = explode('|', $img_data );
                $img_data[1] = $applied_data;
                $current[$k] = $img_data[0].'|'.$img_data[1];
                $existing = 1;
                break;
            }
        }

        if( !$existing ) {
            $current[] = $imagename.'|'.$applied_data;
        }

        $current = implode( "\n", $current );
        file_put_contents($file, $current);
        return true;
    }
}

function Imager_Media() {
    return Imager_Media::instance();
}

Imager_Media();
