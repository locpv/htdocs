<?php
  
  
  if(is_admin()){    
        add_action('admin_enqueue_scripts','wpdm_admin_enqueue_scripts');         
        add_action("init", 'wpdm_reorder_categories');
        add_action("init", 'wpdm_save_email_template');
        add_action("init", 'wpdm_export_emails');
        add_action("init", 'wpdm_delete_emails');                          
        add_action("admin_menu","fmmenu");    
        add_action('wp_ajax_wdm_settings','wdm_ajax_settings');    
        add_action('init','wdm_ajax_help');    
        add_action('init','wpdm_save_template');        
        add_action("admin_head","wpdm_adminjs");
        add_action('admin_head',"addusercolumn");   
        
        add_action('init','wpdm_save_new_package');
        //add_action('init','wpdm_update_package');
        
        add_action('wp_ajax_wpdm_create_category', 'wpdm_create_category');   
        add_action('wp_ajax_wpdm_update_category', 'wpdm_create_category');   
        add_action('wp_ajax_wpdm_category_dropdown', 'wpdm_print_cat_dropdown');   
        
        add_action('wp_ajax_dismiss-wpdm-pointer','wpdm_dismiss_pointer'); 
        add_action('wp_ajax_get_link_templates','wpdm_get_link_templates'); 
        add_action('wp_ajax_get_page_templates','wpdm_get_page_templates'); 
        add_action('wp_ajax_wpdm_generate_password','wpdm_generate_password');         
        add_action('wp_ajax_photo_gallery_upload', 'wpdm_check_upload');   
        add_action('wp_ajax_icon_upload', 'wpdm_upload_icon');           
        add_wdm_settings_tab("license","License",'wpdm_licnese');
        add_action('init','wpdm_delete_all_cats');
        add_action("admin_init","wpdm_import_csv_file");
        add_action("admin_init","wpdm_import_category_csv_file");
        add_filter("wpdm_export_custom_form_fields", 'wpdm_export_custom_form_fields');
        add_action("wpdm_custom_form_field", 'wpdm_ask_for_custom_data');   
        //Activate auto update
        add_action('init', 'wpdm_activate_au');
          
    }else{
        add_action('wp_enqueue_scripts','wpdm_enqueue_scripts');   
        add_action("init", 'wpdm_update_client_profile');    
        add_action("init","wpdm_DownloadNow");
        add_action("wp","wpdm_ajax_call_exec");
        add_shortcode('wpdm_direct_link','wpdm_direct_link');   
        add_shortcode("wpdm_package","wpdm_package_link");
        add_shortcode("wpdm_category","wpdm_category");
        add_shortcode("wpdm_frontend","wpdm_new_file_form_sc"); 
        add_shortcode('wpdm-email-2download','wpdm_email_2download');
        add_shortcode('wpdm-plus1-2download','wpdm_plus1_2download');
        add_shortcode('wpdm-like-2download','wpdm_like_2download');
        add_shortcode('wpdm-all-packages','wpdm_all_packages');
        if(get_option('_wpdm_custom_template')==0)
        add_filter( 'the_content', 'wpdm_downloadable',99999);
        else
        add_filter( 'the_content', 'wpdm_downloadable',0);                
        add_filter('widget_text', 'do_shortcode');  
        add_filter("wpdm_render_custom_form_fields", 'wpdm_render_custom_data');        
        add_action("wp", 'wpdm_load_data');        
        if(isset($_GET['mode'])&&$_GET['mode']=='popup')
        add_action("init","DownloadPageContent");
        add_action('init','delete_package_frontend');
        add_action('init','wpdm_check_invpass');
        add_filter( 'wp_footer', 'wpdm_facebook_like_footer');
        add_filter( 'wp_footer', 'wpdm_popup_link');
        
        add_action('wp','wpdm_do_logout');
        add_action('wp','wpdm_update_profile');
        add_action('wp_loaded','wpdm_do_login');
        add_action('wp_loaded','wpdm_do_register'); 

    }

    

    

    
    
    add_action("init","wpdm_common_actions");
    add_action("init","wpdm_upload_file");
    add_action('init','wpdm_save_new_package');
    add_action('init','wpdm_update_package');
    