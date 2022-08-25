<?php

/* Enqueue required files */
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    if(is_page('contact-form')){
        /* Enqueue stylesheets */
        wp_enqueue_style('font-style', get_stylesheet_directory_uri(). '/fonts/icomoon/style.css',array(),'1.0.0');
        wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri(). '/css/bootstrap.min.css',array(),'1.0.0');
        wp_enqueue_style('main-style', get_stylesheet_directory_uri(). '/css/style.css',array(),'1.0.0');
        wp_enqueue_style('font-api', 'https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap');

        /* Enqueue scripts */
        wp_enqueue_script('jquery-main',get_stylesheet_directory_uri(). '/js/jquery-3.3.1.min.js',array(),'1.0.0',true);
        wp_enqueue_script('popper-js',get_stylesheet_directory_uri(). '/js/popper.min.js',array(),'1.0.0',true);
        wp_enqueue_script('bootstrap-js',get_stylesheet_directory_uri(). '/js/bootstrap.min.js',array(),'1.0.0',true);
        wp_enqueue_script('validate-jquery',get_stylesheet_directory_uri(). '/js/jquery.validate.min.js',array(),'1.0.0',true);
        wp_enqueue_script('main-js',get_stylesheet_directory_uri(). '/js/main.js',array(),'1.0.0',true);
        wp_localize_script(
            'main-js',
            'myLink',
            array(
                'ajax_link' => admin_url('admin-ajax.php'),
                'nonce'     => wp_create_nonce('user-registration-nonce')
            )
        );
    }
}

/* Ajax callback for getting form data */
add_action('wp_ajax_user_hook','get_form_data');
// add_action('wp_ajax_nopriv_form_submit','get_form_data');
function get_form_data(){
    if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'user-registration-nonce')) {
        $name    = $_POST['name'];
        $email   = $_post['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
    }
}

?>