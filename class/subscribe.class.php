<?php
$subs = new subscribe() ;
//$subs->subscribe_func();
//$subs->show_mail();
class  subscribe {
  
  function __construct() {
		//Add shortcode
    add_shortcode( 'subscribe_field', array($this,'subscribe_func') );
		//Enqueu scripts
    add_action( 'wp_enqueue_scripts', array($this,'my_scripts_method') );
		//Hook send mail function with Ajax
    add_action('wp_ajax_send_email', array($this,'send_email'));
    add_action('wp_ajax_nopriv_send_email', array($this,'send_email'));
		//Create a poste type Subscribe field
    add_action( 'init', array($this,'create_post_type'));
		//Hook insert_subscribe_field function with Ajax
		add_action('wp_ajax_insert_subscribe_field', array($this,'insert_subscribe_field'));
    add_action('wp_ajax_nopriv_insert_subscribe_field', array($this,'insert_subscribe_field'));
  }
  
  // [bartag foo="foo-value"]
public function subscribe_func( $atts=null) {
     $a = shortcode_atts( array(
        'email' => 'admin@abdelhadidev.com',
        'bar' => 'something else',
    ), $atts );

    $shortcode = "<input type='text' name='subscribe-phone' id='subscribe-phone' />
                  <input type='hidden' name='admin-ajax' id='admin-ajax' value='".admin_url( 'admin-ajax.php' )."'/>
                  <input type='hidden' name='email_sender' id='email_sender' value='".$a['email']."'/>
                  <button name='subscribe-btn' id='subscribe-btn'>Subscribe</button>";

    return $shortcode;//"foo = {$a['foo']}";
}

//Email sending
public function send_email(){

 	$emailto		 = trim($_POST['email_sender']) ;
	$phone 			 = trim($_POST['phone']);
	$subject		 = "New subscriber";
	$messages		 = "Phone : $phone <br>";	
	$Reply			 = $emailto;
  
	// Let's send the email.
			
		$mail = mail($emailto,$subject,$messages,"from: $emailto <$Reply>\nReply-To: $Reply \nContent-type: text/html");	
	
		if($mail) {
			echo 'success : '.$emailto;
		}
	 else {
		echo "error : ".$emailto ;
	}
   die();
 }

 //Create custom post
public function create_post_type() {
  register_post_type( 'subscribe_field',
    array(
      'labels' => array(
        'name' => __( 'Subscribe field' ),
        'singular_name' => __( 'Subscribe field adev' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
  
//Enqueu scripts
function my_scripts_method() {
    wp_enqueue_script( 'my_script', plugins_url().'/subscribe-phone/js/script.js', array( 'jquery' ) );
}

//Insert post on subscribe_field
// Create post object
public function insert_subscribe_field (){
	
		$my_post = array(
			'post_type' 		=> 'subscribe_field',
			'post_title'    => wp_strip_all_tags( $_POST['phone'] ),
			'post_status'   => 'publish'
		);

		// Insert the post into the database
		echo 'Insert done with : '.wp_insert_post( $my_post ) ;
	die();
  
	}
}
	