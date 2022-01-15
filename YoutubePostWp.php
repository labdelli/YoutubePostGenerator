<?php
/**
 * YoutubePostWp
 *
 * @package           YoutubePostWp
 * @author            Lotfi Abdelli
 * @copyright         2021 GYBO
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       YoutubePostWp
 * Plugin URI:        https://getyourbusiness.ca
 * Description:       Auto post youtube videos on your blog.
 * Version:           1.0.0
 * Requires at least: 5.2
 * YoutubePostWp is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
YoutubePostWp is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with YoutubePostWp. If not, see {URI to Plugin License}.


**/

//constants


define ("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
define ("PLUGIN_URL",plugins_url()) ;
define ("PLUGIN_VERSION","1.0") ;
 
 class YoutubePostWp {
     function __construct(){
     
    add_action( 'admin_menu', array($this,'FormadminPage') ); 
    add_action( 'admin_menu1', array($this,'DeleteTbDb') );
    add_action( 'admin_menu2', array($this,'buildtbdb') );
 } 
  function FormadminPage() {
    add_menu_page( 
        'Youtube Post Creator ',//page title
        'Youtube Post Creator',//menu title
        'manage_options',//admin level
        'Post-Creator',//page slug - Parent slug
        'PostCreator',//callback function
        'dashicons-youtube
',//icon
        6
        
        ); //position
    
    
  add_submenu_page( 
       'Post-Creator', // Parent slug
        'Post Creator',//page title
        'Post Creator',//menu title
        'manage_options',//admin level
        'Post-Creator', //menu slug
        'PostCreator'
        
        ); 
         add_submenu_page( 
       'Post-Creator', // Parent slug
        'Post View',//page title
        'Post View',//menu title
        'manage_options',//admin level
        'Post-View', //menu slug
        'PostView'
        
        ); 
function PostCreator() {
    
 
include_once  PLUGIN_DIR_PATH."/views/Form-View.php" ; 
}

 function PostView() {
    
 
include_once  PLUGIN_DIR_PATH."/views/Post-View.php" ; 
}  
}
}
/**
 * Enqueue my scripts and assets.
 *
 * @param $hook
 */
$YoutubePostWp = new YoutubePostWp;  

//table generating code
 
register_activation_hook( __FILE__, 'DbCreation' );
 

function DbCreation() { 
    
 
  global $wpdb;
  
      $table_name = $wpdb->prefix . 'ytpg_plugin'; 
      $charset = $wpdb->get_charset_collate();
   
  
  
  
       $QueryYt = "CREATE TABLE $table_name 
  (
 `id` int(11) NOT NULL AUTO_INCREMENT, 
 `campaign_name` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
 `category_id` tinyint(3) NOT NULL,
 `channel_id` varchar(24) COLLATE utf8mb4_unicode_520_ci NOT NULL,
 `post_qty` tinyint(3) NOT NULL,
 PRIMARY KEY (`id`)
) $charset";
    
    
    require_once (ABSPATH.'wp-admin/includes/upgrade.php');

    dbDelta($QueryYt);
    
    
   

}

register_deactivation_hook( __FILE__, 'DeleteTbDb' ); 

function DeleteTbDb() { 
    
global $wpdb;
  
$wpdb->query("DROP TABLE IF EXISTS wpxf_ytpg_plugin");
  
     

}


function ajax_form_scripts() {
	$translation_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    );
    wp_localize_script( 'main', 'cpm_object', $translation_array );
}

add_action( 'wp_enqueue_scripts', 'ajax_form_scripts' );


// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_set_form2', 'set_form2' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_set_form2', 'set_form2'); //execute when logged out

function set_form2(){

     global $wpdb;

$all_channels = $wpdb->get_results("SELECT id,category_id,post_qty,campaign_name,channel_id FROM wpxf_ytpg_plugin");
    
    
    
  
   
    foreach ( $all_channels as $all_channel) 
    {
        $all_channel->campaign_name;
        $all_channel->channel_id;
        $all_channel->category_id;
        $all_channel->id;
        $all_channel->post_qty;
        
    }
      
    echo json_encode( $all_channels);
    

 die;   
 

   }

// POST CREATION BLOCK

// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_set_form4', 'set_form4' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_set_form4', 'set_form4'); //execute when logged out

// API CALL and FORM DATA TRANSFER 
 function set_form4(){
    
    {
        $apikey = 'AIzaSyBB8KTM0tbb9fvq1coAjvC0ZZ41hciAJPA'; 
        
        $date ='date';
        $channelid ="UCvgfXK4nTYKudb0rFR6noLA";
        
       
       // publish after endpoint to get latest
       
     
      $name = $_POST['name'];
      $email = $_POST['email'];
      $message = $_POST['message'];
      $yt_api_url = 'https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=' .$name. '&maxResults=' .$message. '&order=' .$date. '&key=' . $apikey;
      $yt_json = file_get_contents($yt_api_url);
      $yt_arr = json_decode($yt_json);
       
    
 
// API CALL LOOP DATA MAPPING to VARIABLES    
    foreach ($yt_arr->items as $item) {
           // echo "<pre>"; print_r($item->id->videoId); echo "</pre>";
    $title = $item->snippet->title;
    $description = $item->snippet->description;
    $videoId = $item->id->videoId;
    $thumbnail = $item->snippet->thumbnails->high->url;
    $htmlcode = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$videoId.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
    </iframe></br>' .$description. '' ;
   
    
    
    
    
    
    // WP POST CREATION 
       $url     = $thumbnail;

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');





// Post form content:
     $post_id = wp_insert_post(
			array(
				//'comment_status'	=>	'open',
				//'ping_status'		=>	'closed',
				//'post_author'		=>	$user_id,
				//'post_name'		    =>	$slug,
				'post_title'		=>	$title,
				'post_status'		=>	'publish',
				'post_type'		    =>	'post',
                'post_content'		=>  $htmlcode,
                'post_category' => array($email),
                
                
			)
		);

 $image = media_sideload_image( $url, $post_id,$title,'id');

 set_post_thumbnail( $post_id, $image );

var_dump($image) ;
    
    
    
     
    
  
    
    
      
     }
      
    }
    
}


// CAMPAIGN DB INSERT

// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_set_form3', 'set_form3' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_set_form3', 'set_form3'); //execute when logged out
 function set_form3(){
    $campaign = $_POST['campaign'];
    $name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$admin =get_option('admin_email');
	// wp_mail($email,$name,$message);  main sent to admin and the user
	if(wp_mail($email, $name, $message)  &&  wp_mail($admin, $name, $message) )
       {
           echo "mail sent";
   } else {
          echo "mail not sent";
   }
    global $wpdb;
    
        $wpdb->insert("wpxf_ytpg_plugin" , array(
    "campaign_name"=>$_POST['campaign'],
    "channel_id"=>$_POST['name'],
    "category_id"=>$_POST['email'],
    "post_qty"=>$_POST['message']

    ) );
    die();

}
// FORM FIELD POPULATION

// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_form_populate', 'form_populate' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_form_populate', 'form_populate'); //execute when logged out

function form_populate()
{
//Grab Channels from DB
global $wpdb;

  $all_cats = $wpdb->get_results
    
    ("SELECT id,channel_name,yt_channel_id,cat_name,wp_category_id FROM wpxf_ytpg_channels"); 
     
  

foreach ( $all_cats as $all_cat) 
    {
        $all_cat->channel_name;
        $all_cat->yt_channel_id;
        $all_cat->cat_name;
        $all_cat->wp_category_id;
        
    }   
      
    echo json_encode( $all_cats);
    
  
   die(); 
 }
?>