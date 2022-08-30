<?php

/* Enqueue required files */
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    if(is_page('contact-form')){
        /* Enqueue stylesheets */
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
add_action('wp_ajax_nopriv_user_hook','get_form_data');
function get_form_data(){
    if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'user-registration-nonce')) {
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $subject  = $_POST['subject'];
        $message  = $_POST['message'];
        $curl     = curl_init();
        $group_id = "GROUP_ID";
        $mailerlite_api_key = "API_KEY";

        $post_fields = wp_json_encode([
            'email'  => $email,
            'name'   => $name,
            'fields' => [
                'subject' => $subject,
                'message' => $message
            ]
        ]);
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.mailerlite.com/api/v2/groups/".$group_id."/subscribers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $post_fields,
            CURLOPT_HTTPHEADER     => [
              "Accept: application/json",
              "Content-Type: application/json",
              "X-MailerLite-ApiKey:".$mailerlite_api_key,
            ],
        ]);
          
        $response = curl_exec($curl);
        $err      = curl_error($curl);
          
        curl_close($curl);
          
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {  
            echo $response;
        }

    }
}

?>
