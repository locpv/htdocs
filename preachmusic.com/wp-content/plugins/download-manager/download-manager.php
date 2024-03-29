<?php 
/**
 * @package Download_Manager
 * @author Shaon
 * @version 3.3.5 RC1
 */
/*
Plugin Name: Download Manager
Plugin URI: http://www.wpdownloadmanager.com/
Description: Manage, Protect and Track File Downloads from your wordpress site
Author: Shaon
Version: 3.3.5 RC1
Author URI: http://www.wpdownloadmanager.com/
*/
        
include(dirname(__FILE__)."/functions.php");        
include(dirname(__FILE__)."/class.pack.php");
include(dirname(__FILE__)."/class.logs.php");
include(dirname(__FILE__)."/class.pagination.php");

define('WPDM_Version','3.3.4');
    
$d = str_replace('\\','/',WP_CONTENT_DIR);

define('WPDM_BASE_DIR',dirname(__FILE__).'/');  

define('UPLOAD_DIR',$d.'/uploads/download-manager-files/');  

define('WPDM_CACHE_DIR',dirname(__FILE__).'/cache/');  

define('_DEL_DIR',$d.'/uploads/download-manager-files');  

define('UPLOAD_BASE',$d.'/uploads/');  

ini_set('upload_tmp_dir',UPLOAD_DIR.'/cache/');    

load_plugin_textdomain('wpdmpro', WP_PLUGIN_URL."/download-manager/languages/",'download-manager/languages/');

if(!$_POST)    $_SESSION['download'] = 0;

function wpdm_pro_Install(){
    global $wpdb;
      
      delete_option('wpdm_latest');  
      
      $sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ahm_files` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `description` text NOT NULL,
              `link_label` varchar(255) NOT NULL,
              `password` text NOT NULL,
              `quota` int(11) NOT NULL,
              `show_quota` tinyint(11) NOT NULL,
              `show_counter` tinyint(1) NOT NULL,
              `access` text NOT NULL,
              `template` varchar(100) NOT NULL,
              `category` text NOT NULL,
              `icon` varchar(255) NOT NULL,
              `preview` varchar(255) NOT NULL,
              `files` text NOT NULL,
              `sourceurl` text NOT NULL,
              `download_count` int(11) NOT NULL,
              `page_template` varchar(255) NOT NULL,
              `url_key` varchar(255) NOT NULL,
              `uid` INT NOT NULL,
              `create_date` INT NOT NULL,
              `update_date` INT NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

      $sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ahm_download_stats` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `pid` int(11) NOT NULL,
              `uid` int(11) NOT NULL,
              `oid` varchar(100) NOT NULL,
              `year` int(4) NOT NULL,
              `month` int(2) NOT NULL,
              `day` int(2) NOT NULL,
              `timestamp` int(11) NOT NULL,
              `ip` varchar(20) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
            
      $sqls[] = "CREATE TABLE `{$wpdb->prefix}ahm_filemeta` (
             `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
             `pid` INT NOT NULL ,
             `name` VARCHAR( 80 ) NOT NULL ,
             `value` TEXT NOT NULL,
             `uniq` BOOLEAN NOT NULL DEFAULT '0'
            ) ENGINE = MyISAM  DEFAULT CHARSET=utf8";
            
      $sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ahm_emails` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(255) NOT NULL,
              `pid` int(11) NOT NULL,
              `date` int(11) NOT NULL,
              `custom_data` text NOT NULL,
              PRIMARY KEY (`id`)
            )";
      //$sqls[] = "ALTER TABLE `{$wpdb->prefix}ahm_files` ADD `uid` INT NOT NULL";      
      //$sqls[] = "ALTER TABLE `{$wpdb->prefix}ahm_files` ADD `create_date` INT NOT NULL";
      //$sqls[] = "ALTER TABLE `{$wpdb->prefix}ahm_files` ADD `update_date` INT NOT NULL";
      //$sqls[] = "ALTER TABLE `{$wpdb->prefix}ahm_files` ADD `url_key` varchar(255) NOT NULL";
      //$sqls[] = "ALTER TABLE `{$wpdb->prefix}ahm_emails` ADD `custom_data` TEXT NOT NULL ";
      //$sqls[] = "ALTER TABLE `wp_ahm_files` ADD `version` VARCHAR( 100 ) NOT NULL";      
      
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      foreach($sqls as $sql){
      $wpdb->query($sql); 
      //dbDelta($sql); 
      }

   if(get_option('access_level',0)==0)              update_option('access_level','level_10');
   if(get_option('_wpdm_thumb_w',0)==0)             update_option('_wpdm_thumb_w','200');
   if(get_option('_wpdm_thumb_h',0)==0)             update_option('_wpdm_thumb_h','100');   
   if(get_option('_wpdm_pthumb_w',0)==0)            update_option('_wpdm_pthumb_w','400');   
   if(get_option('_wpdm_pthumb_h',0)==0)            update_option('_wpdm_pthumb_h','250');
   if(get_option('_wpdm_athumb_w',0)==0)            update_option('_wpdm_athumb_w','50');
   if(get_option('_wpdm_athumb_h',0)==0)            update_option('_wpdm_athumb_h','50');
   if(get_option('_wpdm_athumb_h',0)==0)            update_option('_wpdm_athumb_h','50');
   if(get_option('_wpdm_wthumb_h',0)==0)            update_option('_wpdm_wthumb_h','150');
   if(get_option('_wpdm_wthumb_h',0)==0)            update_option('_wpdm_wthumb_h','70');
   if(get_option('_wpdm_show_ct_bar',-1)==-1)       update_option('_wpdm_show_ct_bar','1');
   if(get_option('_wpdm_custom_template','')=='')   update_option('_wpdm_custom_template','page.php');
   
   update_option('wpdm_default_link_template',"[thumb_100x50]\r\n<br style='clear:both'/>\r\n<b>[popup_link]</b><br/>\r\n<b>[download_count]</b> downloads");
   update_option('wpdm_default_page_template',"[thumb_800x500]\r\n<br style='clear:both'/>\r\n[description]\r\n<fieldset class='pack_stats'>\r\n<legend><b>Package Statistics</b></legend>\r\n<table>\r\n<tr><td>Total Downloads:</td><td>[download_count]</td></tr>\r\n<tr><td>Stock Limit:</td><td>[quota]</td></tr>\r\n<tr><td>Total Files:</td><td>[file_count]</td></tr>\r\n</table>\r\n</fieldset><br>\r\n[download_link]");
    
   if(get_option('_wpdm_etpl')==''){
          update_option('_wpdm_etpl',array('title'=>'Your download link','body'=>file_get_contents(dirname(__FILE__).'/templates/wpdm-email-lock-template.html')));
   }
   
   if(!$wpdb->get_var("select post_name from {$wpdb->prefix}posts where post_type='wpdmpro'")){
   $my_post = array(
                  'post_title'    => 'wpdmpro',
                  'post_content'  => 'wpdmpro',
                  'post_status'   => 'publish',
                  'post_author'   => 1,
                  'post_type' => 'wpdmpro'
                );
               
   wp_insert_post( $my_post );
   }
   CreateDir();
       
}

include("wpdm.php");

function wdm_tinymce()
{
/*  wp_enqueue_script('common');
  wp_enqueue_script('jquery-color');
  wp_admin_css('thickbox');
  wp_print_scripts('post');
  wp_print_scripts('media-upload');
  wp_print_scripts('jquery');
  //wp_print_scripts('jquery-ui-core');
  //wp_print_scripts('jquery-ui-tabs');
  wp_print_scripts('tiny_mce');
  wp_print_scripts('editor');
  wp_print_scripts('editor-functions');
  add_thickbox();
  wp_tiny_mce();
  wp_admin_css();
  wp_enqueue_script('utils');
  do_action("admin_print_styles-post-php");
  do_action('admin_print_styles');
  remove_all_filters('mce_external_plugins'); */
}

//if($_GET['page']=='file-manager/add-new-package'||$_GET['page']=='file-manager'||$_GET['page']=='file-manager/templates')
//add_action('admin_head','wdm_tinymce');


register_activation_hook(__FILE__,'wpdm_pro_Install');
 
//if(!is_admin()){




/** native upload code **/
function plu_admin_enqueue() {     
    wp_enqueue_script('plupload-all');    
    wp_enqueue_style('plupload-all');    
}
if(isset($_GET['page'])&&in_array($_GET['page'],array('file-manager/add-new-package','file-manager')))
add_action( 'admin_enqueue_scripts', 'plu_admin_enqueue' );
if(isset($_GET['task'])&&in_array($_GET['task'],array('addnew','edit-package')))
add_action( 'wp_enqueue_scripts', 'plu_admin_enqueue' );



// handle uploaded file here
function wpdm_check_upload(){
  check_ajax_referer('photo-upload');
  if(file_exists(UPLOAD_DIR.$_FILES['async-upload']['name']))
  $filename = time().'wpdm_'.$_FILES['async-upload']['name'];  
  else
  $filename = $_FILES['async-upload']['name'];  
  move_uploaded_file($_FILES['async-upload']['tmp_name'],UPLOAD_DIR.$filename);
  @unlink($status['file']);
  echo $filename;
  exit;
}

function wpdm_upload_icon(){
  check_ajax_referer('icon-upload');
  if(file_exists(dirname(__FILE__).'/file-type-icons/'.$_FILES['icon-async-upload']['name']))
  $filename = time().'wpdm_'.$_FILES['icon-async-upload']['name'];  
  else
  $filename = $_FILES['icon-async-upload']['name'];  
  move_uploaded_file($_FILES['icon-async-upload']['tmp_name'],dirname(__FILE__).'/file-type-icons/'.$filename);   
  $data = array('rpath'=>"download-manager/file-type-icons/$filename",'fid'=>md5("download-manager/file-type-icons/$filename"),'url'=>plugins_url("download-manager/file-type-icons/$filename"));
  header('HTTP/1.0 200 OK');
  header("Content-type: application/json");    
  echo json_encode($data);
  exit;
}

function fmmenu(){   
    global $current_user, $add_new_page;        
    get_currentuserinfo();
    $admins = explode(",",get_option('__wpdm_custom_admin',''));                     
    $access_level = wpdm_multi_user()?get_option('access_level'):'administrator';        
    if(wpdm_is_custom_admin())  $access_level = 'level_0';    
    $special_access = 'administrator';
    if(wpdm_is_custom_admin()) $special_access = 'level_0';    
    if($access_level=='administrator'&&!$current_user->caps['administrator']) return;         
    add_menu_page(__("Download Manager","wpdmpro"),__("Downloads","wpdmpro"),$access_level,'file-manager','AdminOptions',plugins_url().'/download-manager/images/download-manager-16.png',6);         
    add_submenu_page( 'file-manager', __('Download Manager',"wpdmpro"), __('Manage Packages',"wpdmpro"), $access_level, 'file-manager', 'AdminOptions',plugins_url().'/download-manager/images/download-manager-16.png');    
    add_submenu_page( 'file-manager', __('Add New &lsaquo; Download Manager',"wpdmpro"), __('Add New',"wpdmpro"), $access_level, 'file-manager/add-new-package', 'AddNewFile');    
    add_submenu_page( 'file-manager', __('Bulk Import &lsaquo; Download Manager',"wpdmpro"), __('Bulk Import',"wpdmpro"), $special_access, 'file-manager/importable-files', 'ImportFiles');    
    add_submenu_page( 'file-manager', __('Categories &lsaquo; Download Manager',"wpdmpro"), __('Categories',"wpdmpro"), $special_access, 'file-manager/categories', 'wpdm_Categories');    
    add_submenu_page( 'file-manager', __('Templates &lsaquo; Download Manager',"wpdmpro"), __('Templates',"wpdmpro"), $special_access, 'file-manager/templates', 'LinkTemplates');    
    add_submenu_page( 'file-manager', __('Subscribers &lsaquo; Download Manager',"wpdmpro"), __('Subscribers',"wpdmpro"), $access_level, 'file-manager/emails', 'wpdm_emails');        
    add_submenu_page( 'file-manager', __('Stats &lsaquo; Download Manager',"wpdmpro"), __('Stats',"wpdmpro"), $access_level, 'file-manager/stats', 'Stats');        
    add_submenu_page( 'file-manager', __('Settings &lsaquo; Download Manager',"wpdmpro"), __('Settings',"wpdmpro"), $special_access, 'file-manager/settings', 'FMSettings');    
     
    
    add_action("load-toplevel_page_file-manager", 'wpdm_add_help_tab');
    add_action("load-download-manager_page_file-manager/add-new-package", 'wpdm_add_help_tab');
    add_action("load-download-manager_page_file-manager/settings", 'wpdm_add_help_tab');
     
    }




