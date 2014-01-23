<?php
global $wpdm_message, $wpdm_category, $wpdm_query, $wpdm_packages, $wpdm_package;

$wpdm_download_button_class = 'btn btn-success';
$wpdm_download_button_class_lt = '';
$wpdm_download_button_class_ct = '';
$wpdm_download_icon = '';

    /**
    * add new package meta
    * 
    * @param mixed $pid
    * @param mixed $name
    * @param mixed $value
    */
    function add_wpdm_meta($pid, $name, $value, $uniq = false){
        global $wpdb;
        $value = is_array($value)?serialize($value):$value;
        $uniq = $uniq?1:0;
        $duplicate = $wpdb->get_var("select pid from {$wpdb->prefix}ahm_filemeta where pid='$pid' and `name`='$name' and uniq=1");
        if($duplicate&&$uniq) return false;        
        $wpdb->insert("{$wpdb->prefix}ahm_filemeta",array('pid'=>$pid, 'name'=>$name, 'value'=>$value, 'uniq'=>$uniq));                             
        return true;
    }                                                         
    /**
    * update package meta
    * 
    * @param mixed $pid
    * @param mixed $name
    * @param mixed $value
    * @param mixed $uniq
    */
    function update_wpdm_meta($pid, $name, $value, $uniq = false){
        global $wpdb;
        //$wpdb->show_errors();
        unset($_SESSION["{$name}_{$pid}"]);
        $uniq = $uniq?1:0;         
        delete_wpdm_meta($pid, $name);
        $value = is_array($value)?serialize($value):$value;        
        add_wpdm_meta($pid, $name, $value, $uniq);
    }
    
    
    /**
    * delete all meta for a package
    * 
    * @param mixed $pid
    * @param mixed $name
    */
    function deleteall_wpdm_meta($pid){
        global $wpdb;
        if($pid<=0) return;
        $wpdb->query("delete from {$wpdb->prefix}ahm_filemeta where pid='$pid'");
    }
    
    /**
    * delete package meta
    * 
    * @param mixed $pid
    * @param mixed $name
    */
    function delete_wpdm_meta($pid, $name=''){
        global $wpdb;
        if($name=='') return;
        //$wpdb->query("delete from {$wpdb->prefix}ahm_filemeta where pid='$pid'");
        //else
        unset($_SESSION["{$name}_{$pid}"]);
        $wpdb->query("delete from {$wpdb->prefix}ahm_filemeta where pid='$pid' and `name`='$name'");         
    }
    
    /**
    * get package meta
    * 
    * @param mixed $pid
    * @param mixed $name
    * @param mixed $single
    */
    function get_wpdm_meta($pid, $name, $single = true, $default = ''){
        global $wpdb;
        if(!is_admin()&&$_SESSION["{$name}_{$pid}"]!='')
        $data = $_SESSION["{$name}_{$pid}"];
        else
        $data = $wpdb->get_results("select * from {$wpdb->prefix}ahm_filemeta where pid='$pid' and `name`='$name'");
        if(!is_admin())
        $_SESSION["{$name}_{$pid}"] = $data;
        if($single==true){
        $single_val = maybe_unserialize($data[0]->value);        
        return $single_val?$single_val:$default;
        }
        foreach($data as $d){
            $d->value = maybe_unserialize($d->value);
            $metas[$d->name] = $d->value;
        }
        
        return $metas?$metas:$default;
    }
    
    function the_wpdm_thumbnail($size = array(), $attr = array()){
        global $wpdm_package;
        $thumb = $wpdm_package['preview'];         
        if($thumb=='') $thumb = $attr['src'];
        echo "<img alt='".the_wpdm_title(1)."' title='".the_wpdm_title(1)."' class='{$attr[cssclass]}' src='".plugins_url("/download-manager/")."timthumb.php?src={$thumb}&w={$size[0]}&h={$size[1]}&zc=1' />";
    }
    
    function the_wpdm_permalink(){
        global $wpdm_package;
        $wpdm_package = wpdm_flat_url($wpdm_package);
        echo $wpdm_package['page_url'];
    }
    
    function wpdm_category_url($category = '', $page = ''){
        global $wpdm_category;
        $category = $category?$category:$wpdm_category['id'];    
        if(get_option('permalink_structure')){
        $url = site_url("/".get_option('__wpdm_curl_base','downloads')."/".$category."/");
        if($page) $url .= "?cp=$page";
        }
        else {
        $url = site_url("/?".get_option('__wpdm_curl_base','downloads')."=".$category);
        if($page) $url .= "&cp=$page";
        }
        return $url;
    }
    
    function the_wpdm_title($return = 0){
        global $wpdm_package;
        if($return)
        return stripcslashes($wpdm_package['title']);
        echo stripcslashes($wpdm_package['title']);
    }
    
    function get_wpdm_ID(){
        global $wpdm_package;
        return $wpdm_package['id'];
    }
    
    function the_wpdm_content(){
        global $wpdm_package;
        echo format_to_post(apply_filters('the_content',stripslashes($wpdm_package['description'])));
    }
    
    
    function wpdm_package_info($name){
        global $wpdm_package;  
        if(isset($wpdm_package[$name])) return $wpdm_package[$name];
        return stripslashes(get_wpdm_meta($wpdm_package['id'],$name));
    } 
    
    function wpdm_print_cat_dropdown(){        
        echo "<option value=''>".__('Top Level Category','wpdmpro')."</option>";
        wpdm_cat_dropdown_tree('',0,'');
        die();
    }
    
    function wpdm_common_actions(){
             $labels = array(
                'name' => _x('Downloads', 'post type general name'),
                'singular_name' => _x('Pacakge', 'post type singular name'),
                'add_new' => _x('Add New', 'downloads'),
                'add_new_item' => __('Add New'),
                'edit_item' => __('Edit'),
                'new_item' => __('New File'),
                'all_items' => __('All Files'),
                'view_item' => __('View Files'),
                'search_items' => __('Search Files'),
                'not_found' =>  __('No File Found'),
                'not_found_in_trash' => __('No Files found in Trash'), 
                'parent_item_colon' => '',
                'menu_name' => 'Downloads'

              );
              $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => false, 
                'show_in_menu' => false, 
                'show_in_nav_menus' => false,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'wpdmpro' ,'with_front'=>true), //get_option('__wpdm_purl_base','download')
                'capability_type' => 'post',
                'has_archive' => true, 
                'hierarchical' => false,
                'menu_position' => null,
                'menu_icon' => plugins_url('/download-manager/images/download-manager-16.png'),
                'supports' => array('title','editor','custom-fields','thumbnail')
                
              ); 
              register_post_type('wpdmpro',$args);
              
              flush_rewrite_rules();
    }
    
     
 
    function wpdm_download_data($filename, $content){
        @ob_end_clean();
        header("Content-Description: File Transfer");
        header("Content-Type: text/plain");  
        header("Content-disposition: attachment;filename=\"$filename\"");
        header("Content-Transfer-Encoding: text/plain");
        header("Content-Length: " . strlen($content));
        echo $content;
    }
    
    
    /**
    * Cache remote file to local directory and return local file path
    * @param mixed $url
    * @param mixed $filename
    * @return string $path
    */
    function wpdm_cache_remote_file($url, $filename=''){
        $filename = $filename?$filename:end($tmp = explode('/', $url));
        $path = WPDM_CACHE_DIR.$filename;
        $fp = fopen($path, 'w');     
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);     
        $data = curl_exec($ch);     
        curl_close($ch);
        fclose($fp);
        return $path;
    }
    
    function wpdm_download_file($filepath, $filename, $speed = 0, $resume_support = 1, $extras = array()){        
        $mime_types = array("323" => "text/h323",
                        "acx" => "application/internet-property-stream",
                        "ai" => "application/postscript",
                        "aif" => "audio/x-aiff",
                        "aifc" => "audio/x-aiff",
                        "aiff" => "audio/x-aiff",
                        "asf" => "video/x-ms-asf",
                        "asr" => "video/x-ms-asf",
                        "asx" => "video/x-ms-asf",
                        "au" => "audio/basic",
                        "avi" => "video/x-msvideo",
                        "axs" => "application/olescript",
                        "bas" => "text/plain",
                        "bcpio" => "application/x-bcpio",
                        "bin" => "application/octet-stream",
                        "bmp" => "image/bmp",
                        "c" => "text/plain",
                        "cat" => "application/vnd.ms-pkiseccat",
                        "cdf" => "application/x-cdf",
                        "cer" => "application/x-x509-ca-cert",
                        "class" => "application/octet-stream",
                        "clp" => "application/x-msclip",
                        "cmx" => "image/x-cmx",
                        "cod" => "image/cis-cod",
                        "cpio" => "application/x-cpio",
                        "crd" => "application/x-mscardfile",
                        "crl" => "application/pkix-crl",
                        "crt" => "application/x-x509-ca-cert",
                        "csh" => "application/x-csh",
                        "css" => "text/css",
                        "dcr" => "application/x-director",
                        "der" => "application/x-x509-ca-cert",
                        "dir" => "application/x-director",
                        "dll" => "application/x-msdownload",
                        "dms" => "application/octet-stream",
                        "doc" => "application/msword",
                        "dot" => "application/msword",
                        "dvi" => "application/x-dvi",
                        "dxr" => "application/x-director",
                        "eps" => "application/postscript",
                        "etx" => "text/x-setext",
                        "evy" => "application/envoy",
                        "exe" => "application/octet-stream",
                        "fif" => "application/fractals",
                        "flr" => "x-world/x-vrml",
                        "gif" => "image/gif",
                        "gtar" => "application/x-gtar",
                        "gz" => "application/x-gzip",
                        "h" => "text/plain",
                        "hdf" => "application/x-hdf",
                        "hlp" => "application/winhlp",
                        "hqx" => "application/mac-binhex40",
                        "hta" => "application/hta",
                        "htc" => "text/x-component",
                        "htm" => "text/html",
                        "html" => "text/html",
                        "htt" => "text/webviewhtml",
                        "ico" => "image/x-icon",
                        "ief" => "image/ief",
                        "iii" => "application/x-iphone",
                        "ins" => "application/x-internet-signup",
                        "isp" => "application/x-internet-signup",
                        "jfif" => "image/pipeg",
                        "jpe" => "image/jpeg",
                        "jpeg" => "image/jpeg",
                        "jpg" => "image/jpeg",
                        "js" => "application/x-javascript",
                        "latex" => "application/x-latex",
                        "lha" => "application/octet-stream",
                        "lsf" => "video/x-la-asf",
                        "lsx" => "video/x-la-asf",
                        "lzh" => "application/octet-stream",
                        "m13" => "application/x-msmediaview",
                        "m14" => "application/x-msmediaview",
                        "m3u" => "audio/x-mpegurl",
                        "man" => "application/x-troff-man",
                        "mdb" => "application/x-msaccess",
                        "me" => "application/x-troff-me",
                        "mht" => "message/rfc822",
                        "mhtml" => "message/rfc822",
                        "mid" => "audio/mid",
                        "mny" => "application/x-msmoney",
                        "mov" => "video/quicktime",
                        "movie" => "video/x-sgi-movie",
                        "mp2" => "video/mpeg",
                        "mp3" => "audio/mpeg",
                        "mpa" => "video/mpeg",
                        "mpe" => "video/mpeg",
                        "mpeg" => "video/mpeg",
                        "mpg" => "video/mpeg",
                        "mpp" => "application/vnd.ms-project",
                        "mpv2" => "video/mpeg",
                        "ms" => "application/x-troff-ms",
                        "mvb" => "application/x-msmediaview",
                        "nws" => "message/rfc822",
                        "oda" => "application/oda",
                        "p10" => "application/pkcs10",
                        "p12" => "application/x-pkcs12",
                        "p7b" => "application/x-pkcs7-certificates",
                        "p7c" => "application/x-pkcs7-mime",
                        "p7m" => "application/x-pkcs7-mime",
                        "p7r" => "application/x-pkcs7-certreqresp",
                        "p7s" => "application/x-pkcs7-signature",
                        "pbm" => "image/x-portable-bitmap",
                        "pdf" => "application/pdf",
                        "pfx" => "application/x-pkcs12",
                        "pgm" => "image/x-portable-graymap",
                        "pko" => "application/ynd.ms-pkipko",
                        "pma" => "application/x-perfmon",
                        "pmc" => "application/x-perfmon",
                        "pml" => "application/x-perfmon",
                        "pmr" => "application/x-perfmon",
                        "pmw" => "application/x-perfmon",
                        "pnm" => "image/x-portable-anymap",
                        "pot" => "application/vnd.ms-powerpoint",
                        "ppm" => "image/x-portable-pixmap",
                        "pps" => "application/vnd.ms-powerpoint",
                        "ppt" => "application/vnd.ms-powerpoint",
                        "prf" => "application/pics-rules",
                        "ps" => "application/postscript",
                        "pub" => "application/x-mspublisher",
                        "qt" => "video/quicktime",
                        "ra" => "audio/x-pn-realaudio",
                        "ram" => "audio/x-pn-realaudio",
                        "ras" => "image/x-cmu-raster",
                        "rgb" => "image/x-rgb",
                        "rmi" => "audio/mid",
                        "roff" => "application/x-troff",
                        "rtf" => "application/rtf",
                        "rtx" => "text/richtext",
                        "scd" => "application/x-msschedule",
                        "sct" => "text/scriptlet",
                        "setpay" => "application/set-payment-initiation",
                        "setreg" => "application/set-registration-initiation",
                        "sh" => "application/x-sh",
                        "shar" => "application/x-shar",
                        "sit" => "application/x-stuffit",
                        "snd" => "audio/basic",
                        "spc" => "application/x-pkcs7-certificates",
                        "spl" => "application/futuresplash",
                        "src" => "application/x-wais-source",
                        "sst" => "application/vnd.ms-pkicertstore",
                        "stl" => "application/vnd.ms-pkistl",
                        "stm" => "text/html",
                        "svg" => "image/svg+xml",
                        "sv4cpio" => "application/x-sv4cpio",
                        "sv4crc" => "application/x-sv4crc",
                        "t" => "application/x-troff",
                        "tar" => "application/x-tar",
                        "tcl" => "application/x-tcl",
                        "tex" => "application/x-tex",
                        "texi" => "application/x-texinfo",
                        "texinfo" => "application/x-texinfo",
                        "tgz" => "application/x-compressed",
                        "tif" => "image/tiff",
                        "tiff" => "image/tiff",
                        "tr" => "application/x-troff",
                        "trm" => "application/x-msterminal",
                        "tsv" => "text/tab-separated-values",
                        "txt" => "text/plain",
                        "uls" => "text/iuls",
                        "ustar" => "application/x-ustar",
                        "vcf" => "text/x-vcard",
                        "vrml" => "x-world/x-vrml",
                        "wav" => "audio/x-wav",
                        "wcm" => "application/vnd.ms-works",
                        "wdb" => "application/vnd.ms-works",
                        "wks" => "application/vnd.ms-works",
                        "wmf" => "application/x-msmetafile",
                        "wps" => "application/vnd.ms-works",
                        "wri" => "application/x-mswrite",
                        "wrl" => "x-world/x-vrml",
                        "wrz" => "x-world/x-vrml",
                        "xaf" => "x-world/x-vrml",
                        "xbm" => "image/x-xbitmap",
                        "xla" => "application/vnd.ms-excel",
                        "xlc" => "application/vnd.ms-excel",
                        "xlm" => "application/vnd.ms-excel",
                        "xls" => "application/vnd.ms-excel",
                        "xlt" => "application/vnd.ms-excel",
                        "xlw" => "application/vnd.ms-excel",
                        "xof" => "x-world/x-vrml",
                        "xpm" => "image/x-xpixmap",
                        "xwd" => "image/x-xwindowdump",
                        "z" => "application/x-compress",
                        "zip" => "application/zip");        
        if(isset($extras['package']))
        $package = $extras['package'];
        $content_type = $mime_types[end($fnp=explode('.',$filename))];
        $buffer = 1024;
        $bandwidth = 0;        
        @ini_set('zlib.output_compression', 'Off');
        @set_time_limit(0);        
        @session_cache_limiter('none');        
        @set_magic_quotes_runtime(0);
        @ob_end_clean();
        @session_write_close();
        
        if(strpos($filepath, '://'))
        $filepath = wpdm_cache_remote_file($filepath, $filename);        
        
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Robots: none");
        header("Content-type: $content_type");    
        $fsize = filesize($filepath);            
        header("Content-disposition: attachment;filename=\"{$filename}\"");
        header("Content-Transfer-Encoding: binary");    
        
        $file = @fopen($filepath,"rb");           
            
        //check if http_range is sent by browser (or download manager)
        if(isset($_SERVER['HTTP_RANGE']) && $fsize>0) {  
            list($bytes, $http_range) = explode("=",$_SERVER['HTTP_RANGE']);
            $set_pointer = intval(array_shift($tmp = explode('-', $http_range)));  
            
            $new_length = $fsize - $set_pointer;
             
            header("Accept-Ranges: bytes");
            header("HTTP/1.1 206 Partial Content");

            header("Content-Length: $new_length");
            header("Content-Range: bytes $http_range$fsize/$fsize");            
            
            fseek($file,$set_pointer);
                        
        } else{
            header("Content-Length: " . $fsize); 
        } 
        $packet = 1;  
        
        if ($file) {
           while (!(connection_aborted() || connection_status() == 1) && $fsize>0) {
                if($fsize>$buffer)
                echo fread($file, $buffer);
                else
                echo fread($file, $fsize);                
                ob_flush();
                flush();
                $fsize -= $buffer;
                $bandwidth += $buffer;
                if ($speed > 0 && ($bandwidth > $speed*$packet*1024))
                {
                    sleep(1);
                    $packet++;
                }
                
                
            }
          $package['downloaded_file_size'] = $fsize;
          add_action('wpdm_download_completed', $package);
          @fclose($file);         
        }
    }
    
  
    
    /**
    * check if multi-user ebabled
    * 
    * @param mixed $cond
    */
    
    function wpdm_multi_user($cond=''){
        global $wpdb, $current_user;
        get_currentuserinfo(); 
        $ismu = get_option('wpdm_multi_user')==1&&!$current_user->caps['administrator']?true:false;
        return $ismu&&$cond?$cond:$ismu;
    }
    
    /**
    * generate downlad link
    * 
    * @param mixed $package
    */
    
    function DownloadLink($package, $embed = 0, $extras = array()){   
          
        global $wpdb, $current_user;
        extract($extras);
        get_currentuserinfo();     
        $package['link_url'] = home_url('/?download=1&');                
        $link_label = $package['link_label']?$package['link_label']:__('Download','wpdmpro');
        $package['download_url'] = wpdm_download_url($package);
        if(wpdm_is_download_limit_exceed($package['id'])){
          $package['download_url'] = '#';
          $package['link_label'] = __msg('DOWNLOAD_LIMIT_EXCEED');
        }
        
        $package['access'] =  @maybe_unserialize($package['access']);
        $categories = maybe_unserialize(get_option("_fm_categories"));
        $cats = @maybe_unserialize($package['category']);
        $access = array();
        if(is_array($cats)){
        foreach($cats as $c){
            if(!is_array($categories[$c]['access'])) $categories[$c]['access'] = array();
            foreach($categories[$c]['access'] as $ac){
                $access[] = $ac;
            }
        }}
        if(count($access)>0){
            foreach($access as $role){
                if(!in_array($role, $package['access']))
                $package['access'][] = $role;
            }
        }        
        $package['download_link'] = "<a class='wpdm-download-link wpdm-download-locked {$btnclass}' rel='noindex nofollow' href='{$package[download_url]}'><i class='$wpdm_download_icon'></i>{$link_label}</a>";
        $role = array_shift(array_keys($current_user->caps));      
        $skiplink = 0;
        if(is_user_logged_in()&&!@in_array($role, @maybe_unserialize($package['access']))&&!@in_array('guest', @maybe_unserialize($package['access']))){        
            $package['download_url'] = "#";
            $package['download_link'] = stripslashes(get_option('wpdm_permission_msg'));
            $package = apply_filters('download_link',$package);
            return $package['download_link'];
        }
        if(!@in_array('guest', @maybe_unserialize($package['access']))&&!is_user_logged_in()){       
            
            $loginform = wp_login_form(array('echo'=>0));
            
            $loginform = '<a class="wpdm-download-link wpdm-download-login '.$btnclass.'" href="#wpdm-login-form" data-toggle="modal"><i class=\''.$wpdm_login_icon.'\'></i>'.__('Login','wpdmpro').'</a><div id="wpdm-login-form" class="modal fade">'.$loginform."</div>";
            $package['download_url'] = home_url('/wp-login.php?redirect_to='.urlencode($_SERVER['REQUEST_URI']));
            $package['download_link'] = stripcslashes(str_replace("[loginform]",$loginform,get_option('wpdm_login_msg'))); 
            return get_option('__wpdm_login_form',0)==1?$loginform:$package['download_link'];
            
        }
                  
        $package = apply_filters('download_link',$package);
        
        $unqid = uniqid(); 
        if(($package['quota']>0&&$package['quota']>$package['download_count'])||$package['quota']==0){
        $lock = 0;    
        if($package['password']!=''&&get_wpdm_meta($package['id'],'password_lock')=='1')    {
        $lock = 1;
        $data = '
         
        <div id="msg_'.$package['id'].'" style="display:none;">processing...</div>
        <form id="wpdmdlf_'.$unqid.'_'.$package['id'].'" method=post action="'.home_url('/').'">
        <input type=hidden name="id" value="'.$package['id'].'" />
        <input type=hidden name="dataType" value="json" />
        <input type=hidden name="execute" value="getlink" />
        <input type=hidden name="action" value="wpdm_ajax_call" />
        ';
        
        $data .= '
        <div class="input-append input-prepend">
        <span class="add-on"><i class="icon icon-lock"></i></span><input type="password" style="margin:0px;padding:4px;" class="span9" placeholder="Enter Password" size="10" id="password_'.$unqid.'_'.$package['id'].'" name="password" /><input id="wpdm_submit_'.$unqid.'_'.$package['id'].'" style="padding:6px 10px;font-size:10pt" class="wpdm_submit btn btn-warning" type="submit" value="'.__('Submit','wpdmpro').'" />
        </div> 
        </form>        
        
        <script type="text/javascript">
        jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").submit(function(){
            var paramObj = {};        
            jQuery("#msg_'.$package['id'].'").html("processing...").show(); 
            jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").hide();    
            jQuery.each(jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").serializeArray(), function(_, kv) {
              paramObj[kv.name] = kv.value;
            });

            jQuery(this).removeClass("wpdm_submit").addClass("wpdm_submit_wait");
            jQuery.post("'. home_url('/') .'",paramObj,function(res){        
                jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").hide();            
                jQuery("#msg_'.$package['id'].'").html("verifying...").css("cursor","pointer").show().click(function(){ jQuery(this).hide();jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").show(); });            
                if(res.downloadurl!=""&&res.downloadurl!=undefined) {
                location.href=res.downloadurl;
                jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").html("<a style=\'color:#ffffff !important\' class=\'btn btn-success\' href=\'"+res.downloadurl+"\'>Download</a>");
                jQuery("#msg_'.$package['id'].'").html("processing...").hide(); 
                jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").show();    
                } else {             
                    jQuery("#msg_'.$package['id'].'").html(""+res.error);
                    //setTimeout("jQuery(\'#wpdm_submit_error_'.$unqid.'_'.$package['id'].'\').fadeOut()",4000);
                } 
        });
        return false;
        });
        </script>
         
        ';
        }
        
         
        //if(get_wpdm_meta($package['id'],'email_lock')=='1'&&$data!='')   $data .= '<div style="margin:5px 0px;border-bottom:1px solid #eee"></div>';
 
        if(get_wpdm_meta($package['id'],'email_lock')=='1'){
        $data .= wpdm_email_lock_form($package);        
        $lock = 1;
        }
        
        if(get_wpdm_meta($package['id'],'gplusone_lock')=='1')     {
        $lock = 1;  
        //if($data!='')   $data .= '<div style="margin:5px 0px;border-bottom:1px solid #eee"></div>';
        $data .=  '<div class="input-append input-prepend">
        <span class="add-on"><i class="icon-plus"></i></span><div class="add-on">'.wpdm_plus1st_google_plus_one($package).'</div></div>';
            
        }
        
        if(get_wpdm_meta($package['id'],'tweet_lock')=='1')     {
        $lock = 1;  
        //if($data!='')   $data .= '<div style="margin:5px 0px;border-bottom:1px solid #eee"></div>';
        $data .=  '<div class="input-append input-prepend">
        <span class="add-on"><i class="icon-edit"></i></span><div class="add-on">'.wpdm_tweet_button($package).'</div></div>';
            
        }
        
        if(get_wpdm_meta($package['id'],'facebooklike_lock')=='1')    {
        $lock = 1;    
        
        //if($data!='')   $data .= '<div style="margin:5px 0px;border-bottom:1px solid #eee"></div>';
        $data .= '<div class="input-append input-prepend">
        <span class="add-on"><i class="icon-heart"></i></span><div class="add-on">'.wpdm_facebook_like_button($package).'</div></div>';
         
        }
        
         
        
        if($lock==1) {      
         
            if($embed==1)  
            $data = "<strong>".__('Please take any of following action to start download:')."</strong><table class='table all-locks-table' style='border:0px'><tr><td style='padding:5px 0px;border:0px;'>".$data."</td></tr></table>";
            else
            $data = '                     
                    <a href="#pkg_'.$package['id'].'" data-toggle="modal" class="wpdm-download-link wpdm-download-locked '.$btnclass.'"><i class=\''.$wpdm_download_lock_icon.'\'></i>'.$package['link_label'].'</a> 
                    <div class="wpdmpro"><div class="modal hide fade" id="pkg_'.$package['id'].'"> <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><strong style="margin:0px;font-size:12pt">'.__('Download').' '.$package['title'].'</strong></div><div class="wpdmpro modal-body"><div class="row-fluid all-locks">'.$data.'</div></div><div class="wpdmpro modal-footer">'.__('Please take any of the actions above to start download').'</div></div></div>';
            //$data = '<div id="pkg_'.$package['id'].'"> <div class="modal-header"><strong style="margin:0px;font-size:12pt">'.__('Download').'</strong></div><div class="modal-body">'.$data.'</div><div class="modal-footer">'.__('Please take any of the actions above to start download').'</div></div>';
            
             
        }
        if($lock==0) {
         
        $data = $package['download_link'];    
        
         
            
        }} else{
         $data = "Download limit exceeded!";   
        }         
        return $data;
    
    }
    
global $gp1c;

 
function wpdm_email_lock_form($package){
    
    if(get_wpdm_meta($package['id'],'email_lock')=='1')    {
        $lock = 1;        
        $unqid = uniqid();          
        $data .= '                 
        <div id="emsg_'.$package['id'].'" style="display:none;">processing...</div>
        <form id="wpdmdlf_'.$unqid.'_'.$package['id'].'" method=post action="'.home_url('/').'" style="font-weight:normal;font-size:12px;padding:0px;margin:0px">
        <input type=hidden name="id" value="'.$package['id'].'" />
        <input type=hidden name="dataType" value="json" />
        <input type=hidden name="execute" value="getlink" />
        <input type=hidden name="verify" value="email" />
        <input type=hidden name="action" value="wpdm_ajax_call" />
        ';
        $data .= apply_filters('wpdm_render_custom_form_fields', $package[id]);
        $data .= '
        <div class="input-append input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span><input type="text" class="span9" placeholder="Enter Email" size="20" id="email_'.$unqid.'_'.$package['id'].'" name="email" /><input id="wpdm_submit_'.$unqid.'_'.$package['id'].'" class="wpdm_submit  btn btn-warning"  style="padding:6px 10px;font-size:10pt" type=submit value=Submit />
        </div>
        </form>        
        
        <script type="text/javascript">
        jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").submit(function(){
            var paramObj = {};        
            jQuery("#emsg_'.$package['id'].'").html("processing...").show(); 
            jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").hide();    
            jQuery.each(jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").serializeArray(), function(_, kv) {
              paramObj[kv.name] = kv.value;
            });

            jQuery(this).removeClass("wpdm_submit").addClass("wpdm_submit_wait");
            jQuery.post("'. home_url('/') .'",paramObj,function(res){        
                jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").hide();            
                jQuery("#emsg_'.$package['id'].'").html("verifying...").css("cursor","pointer").show().click(function(){ jQuery(this).hide();jQuery("#wpdmdlf_'.$unqid.'_'.$package['id'].'").show(); });            
                if(res.downloadurl!=""&&res.downloadurl!=undefined) {
                location.href=res.downloadurl;
                jQuery("#pkg_'.$package['id'].'").html("<a style=\'color:#222222 !important\' href=\'"+res.downloadurl+"\'>Download</a>");
                } else {             
                    jQuery("#emsg_'.$package['id'].'").html(""+res.error);                     
                } 
        });
        return false;
        });
        </script>
         
        ';
        }
        return $data;
}
    
global $tbc;    
 
function wpdm_tweet_button($package){
   global $tbc; 
   
   $tbc++;
   $var = md5('tl_visitor.'.$_SERVER['REMOTE_ADDR'].'.'.$tbc.'.'.md5(get_permalink(get_the_ID())));
   
   $tweet_message = get_wpdm_meta($package['id'],'tweet_message',true);
   
   //$href = $href?$href:get_permalink(get_the_ID());
   
   //update_post_meta(get_the_ID(),$var,$package['download_url']);
   $force = rtrim(base64_encode("unlocked|".date("Ymdh")),'=');
   if($_COOKIE[$var]==1)   
   return $package['download_url'];
   else
   $data = '<div id="tweet_content_'.$package['id'].'" class="locked_ct"><a href="https://twitter.com/share?text='.$tweet_message.'" class="twitter-share-button" data-via="webmaniac">Tweet</a> to unlock the download link</div>';
   $req = home_url('/?pid='.get_the_ID().'&var='.$var);
   $home = home_url('/');
   $html =<<<DATA
                  
                   
                <div id="tl_$tbc" style="max-width:300px;overflow:hidden">
                $data
                </div>
               
               
                <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
                <script type="text/javascript">
                //All event bindings must be wrapped within callback function
                twttr.ready(function (twttr) {
                   
                    twttr.events.bind('tweet', function(event) {
                       
                        /*
                        To make locked items little more private, let's send our base64 encoded session key
                        which will work as key in send_resources.php to acquire locked items.
                        */
                        var data = {unlock_key : '<?php echo base64_encode(session_id());?>'};
                        //Load data from the server using a HTTP POST request.
                        jQuery.cookie('unlocked_{$package[id]}',1); 
                        jQuery.post("{$home}",{id:{$package[id]},dataType:'json',execute:'getlink',force:'$force',action:'wpdm_ajax_call'},function(res){                                                                
                            if(res.downloadurl!=""&&res.downloadurl!=undefined) {
                            location.href=res.downloadurl;
                            jQuery('#pkg_{$package[id]}').html('<a style="color:#000" href="'+res.downloadurl+'">Download</a>');
                            } else {             
                                jQuery("#msg_{$package[id]}").html(""+res.error);                                
                            } 
                    }, "json").error(function(xhr, ajaxOptions, thrownError) {
                            //Output any errors from server.
                            alert( thrownError);
                        });
                    });
                   
                });
                 
                </script>
                
                

DATA;
 
return $html;
}

 
 
function wpdm_plus1st_google_plus_one($package){
   global $gp1c; 
   
   $gp1c++;
   $var = md5('visitor.'.$_SERVER['REMOTE_ADDR'].'.'.$gp1c.'.'.md5(get_permalink(get_the_ID())));
   
   $href = get_wpdm_meta($package['id'],'google_plus_1',true);
   
   $href = $href?$href:get_permalink(get_the_ID());
   
   //update_post_meta(get_the_ID(),$var,$package['download_url']);
   $force = str_replace("=","",base64_encode("unlocked|".date("Ymdh")));
   if($_COOKIE[$var]==1)   
   return $package['download_url'];
   else
   $data = '<strong>'.$plus1_msg.'</strong><g:plusone href="'.$href.'" size="medium" annotation="inline" callback="wpdm_plus1st_unlock_'.$gp1c.'"></g:plusone>';
   $req = home_url('/?pid='.get_the_ID().'&var='.$var);
   $home = home_url('/');
   $html =<<<DATA
                
                   
                <div id="plus_$gp1c" style="max-width:300px;overflow:hidden">
                $data
                </div>
               
               
                <script type="text/javascript">
                  (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  })();
                  
                  function wpdm_plus1st_unlock_$gp1c(plusone){
                        if(plusone.state!='on') { jQuery.cookie('unlocked_{$package[id]}',null); return; }
                        jQuery.cookie('unlocked_{$package[id]}',1); 
                        jQuery.post("{$home}",{id:{$package[id]},dataType:'json',execute:'getlink',force:'$force',action:'wpdm_ajax_call'},function(res){                                                                
                            if(res.downloadurl!=""&&res.downloadurl!=undefined) {
                            location.href=res.downloadurl;
                            jQuery('#pkg_{$package[id]}').html('<a style="color:#000" href="'+res.downloadurl+'">Download</a>');
                            } else {             
                                jQuery("#msg_{$package[id]}").html(""+res.error);                                
                            } 
                    }, "json");
                      
                  
                  }
                  
                </script>
                
                

DATA;
 
return $html;
}

 

 function wpdm_facebook_like_footer(){     
     $force = str_replace("=","",base64_encode("unlocked|".date("Ymdh")));
     //echo '<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.wpdownloadmanager.com%2F%3Faffid%3Dw3xperts&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=80&amp;appId=200909553297304" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>';
     echo "<div id=\"fb-root\"></div>
            <!--script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = \"//connect.facebook.net/en_US/all.js#xfbml=1&appId=".get_option('_wpdm_facebook_app_id')."\";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script--> 
<script type='text/javascript'>
jQuery(document).ready(function() {  

//(function() {
 var e = document.createElement('script');
 e.type = 'text/javascript';
 e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
 e.async = true;
 document.getElementById('fb-root').appendChild(e);  
 
 //}());  
  
window.fbAsyncInit = function() {
    try{ FB.init({appId: ".get_option('_wpdm_facebook_app_id').", status: true, cookie: true, xfbml: true});  } catch(err){}
  
    FB.Event.subscribe('edge.create', function(href, widget) {
      var hash = href.split('#');
      var pkgid = hash[1]; 
       
      jQuery.cookie('unlocked_'+pkgid,1); 
      jQuery.post('".home_url('/')."',{id:pkgid,dataType:'json',execute:'getlink',force:'{$force}',action:'wpdm_ajax_call'},function(res){                                                                
                            if(res.downloadurl!=''&&res.downloadurl!='undefined'&&res!='undefined') {
                            location.href=res.downloadurl;
                            jQuery('#pkg_'+pkgid).html('<a style=\"color:#000\" href=\"'+res.downloadurl+'\">Download</a>');
                            } else {             
                                jQuery('#msg_'+pkgid).html(''+res.error);                                
                            } 
                    });
      return false;
 });
 
 
 
};
   
});
    
    </script>
    
   <style>.fb_edge_widget_with_comment span.fb_edge_comment_widget { display: none !important; }</style> 
    
    ";
 }
 
 function wpdm_facebook_like_button($package){
     $url = get_wpdm_meta($package['id'],'facebook_like',true);
     $url = $url?$url:get_permalink();              
     return '<div class="fb-like" data-href="'.$url.'#'.$package['id'].'" data-send="false" data-width="300" data-show-faces="false" data-font="arial"></div>';
     //return '<iframe src="//www.facebook.com/plugins/like.php?href='.$url.'#'.$package['id'].'&amp;send=false&amp;layout=standard&amp;width=350&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35&amp;appId=200909553297304" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:350px; height:35px;" allowTransparency="true"></iframe>';
 }

 
 function wpdm_email_button($package,$icononly=false){
     $label  = $icononly?"":"Email Link";
     $data = '
                    <a href="#" class="btn" onclick="jQuery(\'#epkg_'.$package['id'].'\').slideToggle();return false;"><i class="icon icon-email"></i>'.$label.'</a> 
                    <div class="download_page download_link"  style="z-index:99999;display:none;position:absolute;" id="epkg_'.$package['id'].'">'.wpdm_email_lock_form($package).'</div>';
    return $data; 
 }
 
 
 //Direct Download button
 function wpdm_ddl_button($package, $icononly=false){
     global $wpdb, $current_user;        
     $label  = $icononly?"":"Download Now";
     //print_r($package);     
     $download_url = home_url("/?file={$package[id]}");
     return "<a class='wpdm-gh-button wpdm-gh-icon arrowdown wpdm-gh-big' href='$download_url'>$label</a>";
     
 }
  
 
 
 

    
    /**
    * return download link after verifying password
    * data format: json
    */
    function getlink(){
        global $wpdb;
        $id = (int)$_POST[id];
        $password = addslashes($_POST['password']);
        $file = $wpdb->get_row("select * from {$wpdb->prefix}ahm_files where id='$id'",ARRAY_A);
        $file1 = $file;
        // and( password='$password' or password like '%[$password]%')
        $plock = get_wpdm_meta($file['id'],'password_lock',true);
        
        $data = array('error'=>'','downloadurl'=>'');           
        if($_POST['verify']=='email'&&get_wpdm_meta($file['id'],'email_lock')==1){
            if(is_email($_POST['email'])){
            $subject = "Your Download Link";
            $site = get_option('blogname');
            $key = uniqid();
            update_wpdm_meta($file['id'],$key,3);
            //file_put_contents(WPDM_CACHE_DIR.'wpdm_'.$key,"3");
            $download_url = wpdm_download_url($file,"_wpdmkey={$key}");
            $wpdb->insert("{$wpdb->prefix}ahm_emails",array('email'=>$_POST['email'],'pid'=>$file['id'],'date'=>time(),'custom_data'=>serialize($_POST['custom_form_field'])));
            $eml = get_option('_wpdm_etpl');
            $headers = 'From: '.$eml['fromname'].' <'.$eml['frommail'].'>' . "\r\nContent-type: text/html\r\n";
            $file = wpdm_setup_package_data($file);
            foreach($file as $key=>$value){
                $keys[] = "[$key]";
                $values[] = $value;
            }
            $keys[] = "[site_url]";
            $values[] = home_url('/');
            $keys[] = "[site_name]";
            $values[] = get_bloginfo('sitename');
            $keys[] = "[download_url]";
            $values[] = $download_url;
            $keys[] = "unsaved:///";
            $values[] = "";
            $keys[] = "[date]";
            $values[] = date(get_option('date_format'),time());            
            $message = str_replace($keys, $values, stripcslashes($eml['body']));             
            $message ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title></head><body>'.stripslashes($message).'</body></html>';
            mail( $_POST['email'], $eml['subject'], stripcslashes($message), $headers, $attachments );
            $data['downloadurl'] = "";   
            $data['error'] = 'Download link sent to your email!';    
            header('HTTP/1.0 200 OK');
            header("Content-type: application/json");    
            echo json_encode($data);
            die();
            } else{
            $data['downloadurl'] = "";   
            $data['error'] = 'Invalid Email Address!';    
            header("Content-type: application/json");    
            echo json_encode($data);
            die();    
            }
        }
        
        if($_POST['force']!=''){
            $vr = explode('|',base64_decode($_POST['force']));
            if($vr[0]=='unlocked'){
                $key = uniqid();
                update_wpdm_meta($file['id'],$key,3);
                $data['downloadurl'] = wpdm_download_url($file,"_wpdmkey={$key}");
                $adata = apply_filters("wpdmgetlink",$data, $file);
                $data = is_array($adata)?$adata:$data;
                header("Content-type: application/json");    
                die(json_encode($data));
            }
            
        }
        
        if($plock==1&&$password!=$file['password']&&!strpos("__".$file['password'],"[$password]")){
            $data['error'] = 'Wrong Password!';    
            $file = array();
        }
        if($plock==1&&$password==''){
            $data['error'] = 'Wrong Password!';    
            $file = array();
        }
        $ux = "";
        if($plock==1){            
            $key = uniqid();
            update_wpdm_meta($file['id'],$key,3);
        }
        
        if($file['id']!=''){
            $pu = get_wpdm_meta($file['id'],'password_usage',true);
            $pul = get_wpdm_meta($file['id'],'password_usage_limit',true);
            
            if($pu[$password]>=$pul&&$pul>0)
            $data['error'] = __msg('PASSWORD_LIMIT_EXCEED');
            else{
                $pu[$password]++;
                update_wpdm_meta($file['id'],'password_usage',$pu);
            }
        } 
        if($_COOKIE['unlocked_'.$file['id']]==1){
           $data['error'] = '';    
           $file = $file1; 
        }   
                                                                                                              
        if($data['error']=='') $data['downloadurl'] = wpdm_download_url($file, "_wpdmkey={$key}");// home_url('/?downloadkey='.md5($file['files']).'&file='.$id.$ux);            
        $adata = apply_filters("wpdmgetlink",$data, $file);
        $data = is_array($adata)?$adata:$data;
        header("Content-type: application/json");    
        die(json_encode($data));
    }
    
    /**
    * callback function for shortcode [wpdm_package id=pid]
    * 
    * @param mixed $params
    * @return mixed
    */
    function wpdm_package_link($params){       
        global $wpdb,$current_user;
        extract($params);
        $postlink = site_url('/');
        if($pagetemplate==1)
        return DownloadPageContent($id);
        $data =  $wpdb->get_row("select * from {$wpdb->prefix}ahm_files where id='$id'",ARRAY_A);        
        if($data['id']=='') return '';        
        $data = apply_filters('wdm_pre_render_link', $data);            
        $role = @array_shift(@array_keys($current_user->caps));      
        $templates = maybe_unserialize(get_option("_fm_link_templates",true));
         
        $template = $params['template']&&file_exists(dirname(__FILE__).'/templates/link-template-'.$params['template'].'.php')?'link-template-'.$params['template'].'.php':'';    
        if(!$template)
        $template = $params['template']&&file_exists(dirname(__FILE__).'/templates/'.$params['template'].'.php')?$params['template'].'.php':'';
        if(!$template) $template = $data['template'];
        
         
        if(file_exists(dirname(__FILE__).'/templates/'.$template))         
        $template = file_get_contents(dirname(__FILE__).'/templates/'.$template);                 
        else
        $template = $templates[$data['template']]['content'] ;
        return FetchTemplate($template, $data, 'link');
    }
    
    /**
    * Parse shortcode
    * 
    * @param mixed $content
    * @return mixed
    */
    function wpdm_downloadable($content){           
        global $wpdb, $current_user, $post, $wp_query, $wpdm_package;                          
        if($wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]!='')
        return wpdm_embed_category(array("id"=>$wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]));
        $postlink = site_url('/');
        get_currentuserinfo();
        $permission_msg = get_option('wpdm_permission_msg')?stripslashes(get_option('wpdm_permission_msg')):"<div  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;color:#800000\">Sorry! You don't have suffient permission to download this file!</div>";
        $login_msg = get_option('wpdm_login_msg')?stripcslashes(get_option('wpdm_login_msg')):"<a href='".get_option('siteurl')."/wp-login.php'  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;\">Please login to access downloadables</a>";
        $user = new WP_User(null);
        if($_GET[get_option('__wpdm_purl_base','download')]!=''&&$wp_query->query_vars[get_option('__wpdm_purl_base','download')]=='') 
        $wp_query->query_vars[get_option('__wpdm_purl_base','download')] = $_GET[get_option('__wpdm_purl_base','download')];
        $wp_query->query_vars[get_option('__wpdm_purl_base','download')] = urldecode($wp_query->query_vars[get_option('__wpdm_purl_base','download')]);
         
        if($wp_query->query_vars[get_option('__wpdm_purl_base','download')]!=''){            
         if(get_option('_wpdm_custom_template')==1)   return $content;          
         return DownloadPageContent();         
        }
       
        return $content;
        
        
    }
        
    function wpdm_new_file_form_sc(){    
        global $wpdb, $current_user;    
        get_currentuserinfo(); 
        $cond_uid = wpdm_multi_user("and uid='{$current_user->ID}'");
        $id = $_GET['id'];
        $table_name = "{$wpdb->prefix}ahm_files";        
        if($id>0)
        $file = $wpdb->get_row("SELECT * FROM {$table_name} WHERE `id` = {$id} $cond_uid", ARRAY_A);
        $tabs = array( 
                        //'sales' => array('label'=>'Sales','callback'=>'wpdm_sales_report')
                    );
        $tabs = apply_filters('wpdm_frontend',$tabs);
        ob_start();
        ?>
        <div class="wpdmpro">
        <ul id="tabs" class="nav nav-tabs" style="margin: 0px !important;padding: 0px;" >
        <?php if(is_user_logged_in()){ ?>
        <li <?php if($_GET['task']==''||$_GET['task']=='edit-package') { ?>class="active"<?php } ?> ><a href="?">All Packages</a></li>
        <li <?php if($_GET['task']=='addnew') { ?>class="active"<?php } ?> ><a href="?task=addnew">Create New Package</a></li>
        <?php foreach($tabs as $tid=>$tab): ?>
        <li <?php if($_GET['task']==$tid) { ?>class="active"<?php } ?> ><a href="?task=<?php echo $tid; ?>"><?php echo $tab['label']; ?></a></li>
        <?php endforeach; ?>        
        <li <?php if($_GET['task']=='editprofile') { ?>class="active"<?php } ?> ><a href="?task=editprofile">Edit Profile</a></li>        
        <li><a href="?task=logout">Logout</a></li>
        <?php } else { ?>
        <li class="active"><a href="?">Signup or Signin</a></li>         
        <?php } ?>
        </ul><br/>                 
        <?php
        
        if(is_user_logged_in()){   
         
        if($_GET['task']=='addnew'||$_GET['task']=='edit-package')
        include('add-new-file-front.php');
        else if($_GET['task']=='editprofile')
        include('wpdm-edit-user-profile.php');
        else if($tabs[$_GET['task']]['callback']!='')
        call_user_func($tabs[$_GET['task']]['callback']);
        else if($tabs[$_GET['task']]['shortcode']!='')
        do_shortcode($tabs[$_GET['task']]['shortcode']);
        else
        include('list-files-front.php');
        } else {
         
        include('wpdm-be-member.php');
        }
        echo '</div>';
        $data = ob_get_contents();
        ob_clean();
        return $data;
    }
    
    function wpdm_do_login(){
        global $wp_query, $post, $wpdb;      
        if(!$_POST['login']) return;
        unset($_SESSION['login_error']);
        the_post();
        $creds = array();
        $creds['user_login'] = $_POST['login']['log'];
        $creds['user_password'] = $_POST['login']['pwd'];
        $creds['remember'] = $_POST['rememberme'];
        $user = wp_signon( $creds, false );
        if ( is_wp_error($user) ){                
           $_SESSION['login_error'] = $user->get_error_message();
           header("location: ".site_url('/members/'));
           die();
        } else {
           do_action('wp_login', $creds['user_login'] );
           if($_POST['invoice']!='')  
           $wpdb->update("{$wpdb->prefix}ahm_orders",array('uid'=>$user->ID),array('order_id'=>$_POST['invoice']));   
           header("location: ".$_POST['permalink']); 
           die();
        }
    }

    function wpdm_do_register(){
        global $wp_query, $wpdb;
        if(!$_POST['reg']) return;
        extract($_POST['reg']);
        $_SESSION['tmp_reg_info'] = $_POST['reg'];    
        $user_id = username_exists( $user_login );
        if($user_login==''){
            $_SESSION['reg_error'] =  __('Username is Empty!');        
            header("location: ".$_POST['permalink']);
            die();
        }
        if($user_email==''||!is_email($user_email)){
            $_SESSION['reg_error'] =  __('Invalid Email Address!');        
            header("location: ".$_POST['permalink']);
            die();
        }
        if ( !$user_id ) {
            $user_id = email_exists( $user_email );
            if ( !$user_id ) {
            //$random_password = wp_generate_password( 12, false );
            $user_id = wp_create_user( $user_login, $user_pass, $user_email );
            $headers = "From: WordPress Download Manager <no-reply@wpdownloadmanager.com>\r\nContent-type: text/html";
            $message = file_get_contents(dirname(__FILE__).'/wpmp-new-user.html');
            $loginurl = home_url('/members/');      
            $message = str_replace(array("[#loginurl#]","[#name#]","[#username#]","[#password#]","[#date#]"), array($loginurl,$display_name, $user_login, $user_pass, date("M d, Y")), $message);
            $invoice = $_POST['invoice'];        
            if($user_id){
            wp_mail($user_email,"Welcome to wpdownloadmanager.com",$message,$headers);     
            if($invoice!=''){  
            $r = $wpdb->get_row("select * from {$wpdb->prefix}ahm_orders where order_id='{$invoice}'");   
            if($r->uid==''&&$r->order_id!=''){
            $wpdb->update("{$wpdb->prefix}ahm_orders",array('uid'=>$user_id),array('order_id'=>$invoice));   
            wp_signon(array('user_login'=>$user_login,'user_password'=>$user_pass, 'remember'=>true), false);
            header("location: ".$loginurl); 
            die();
            }else{
            $_SESSION['reg_warning'] =  __('Invalid Invoice ID. No such order found! However your account has been created successfully and login info sent to your mail address.');        
            //header("location: ".$loginurl);
            //die();
            }}
            }
            unset($_SESSION['guest_order']);
            unset($_SESSION['login_error']); 
            unset($_SESSION['tmp_reg_info']); 
            if(!isset($_SESSION['reg_warning']))
            $_SESSION['sccs_msg'] = "Your account created successfully and login info sent to your mail address.";
            header("location: ".$loginurl); 
            die();
            } else {
                $_SESSION['reg_error'] =  __('Email already exists.');        
                $plink = $_POST['permalink']?$_POST['permalink']:$_SERVER['HTTP_REFERER'];
                header("location: ".$loginurl);
                die();
            }
        } else {
            $_SESSION['reg_error'] =  __('User already exists.');        
            $plink = $_POST['permalink']?$_POST['permalink']:$_SERVER['HTTP_REFERER'];
            header("location: ".$loginurl);
            die();
        }
    }
    
    function wpdm_update_profile(){
        global $wp_query, $wpdb, $current_user;
        get_currentuserinfo();     
        if($_REQUEST['task']=='editprofile'&&$_POST['profile']){
            extract($_POST);
            $error = 0;
                         
            if($password!=$cpassword){
            $_SESSION['member_error'][] = 'Password not matched';
            $error = 1;
            }
            if(!$error){     
                $profile['ID'] = $current_user->ID;
                if($password!='')
                $profile['user_pass'] = $password;                        
                wp_update_user($profile);             
                get_currentuserinfo();
                update_user_meta($current_user->ID,'logo',$logo);
                update_user_meta($current_user->ID,'company_name',$company_name);
                update_user_meta($current_user->ID,'payment_method',$payment_method);
                update_user_meta($current_user->ID,'payment_account',$payment_account);
                update_user_meta($current_user->ID,'phone',$phone);
                $_SESSION['member_success'] = 'Profile data updated successfully.';
            }
            header("location: ".$_SERVER['HTTP_REFERER']);
            die();
        }     
    }

    function wpdm_remind_password(){
        global $wpdb;
        if($_POST['minimaxtask']!='remindpass') return;    
        $reminder = sanitize_text_field($_POST['user_login']);
        $userdata = $wpdb->get_row("select * from {$wpdb->prefix}users where user_login='$reminder' or user_email='$reminder'");
        
        if($userdata->ID>0){
          $pid = 'wpmp'.md5(uniqid());  
          update_user_meta($userdata->ID,'remind_pass_sk',$pid);
          $message = file_get_contents(dirname(__FILE__).'/wpmp-remind-password.html');
          $npurl = home_url('/members/new-password/?u='.$reminder.'&sk='.$pid);      
          $message = str_replace(array("[#npurl#]","[#date#]"), array($npurl,date("M d, Y")), $message);
          $headers = 'From: WP Marketplace Plugin <no-reply@wpmarketplaceplugin.com>' . "\r\nContent-type: text/html\r\n";
          add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
          wp_mail( $userdata->user_email, 'WP Marketplace Plugin: New Password', $message, $headers );
          setcookie('global_success','Password reset email sent. Please check your inbox.');
          header('location: '.home_url('/members/?reseted'));
          die();
        }
        die();
        
    }

    function wpdm_validate_newpass_sk(){
        global $wp_query, $wpdb;
        if($wp_query->query_vars['minimaxtask']!='new-password') return false;    
        $reminder = sanitize_text_field($_REQUEST['u']);
        $userdata = $wpdb->get_row("select * from {$wpdb->prefix}users where user_login='$reminder' or user_email='$reminder'");              
        $usk = get_user_meta($userdata->ID,'remind_pass_sk',true);       
        if($usk!=$_REQUEST['sk']) return false;
        return true;    
    }

    function wpdm_update_password(){
         global $wpdb;
         if(!isset($_POST['user_pass'])) return;    
         $reminder = sanitize_text_field($_REQUEST['u']);
         $userdata = $wpdb->get_row("select * from {$wpdb->prefix}users where user_login='$reminder' or user_email='$reminder'");              
         $usk = get_user_meta($userdata->ID,'remind_pass_sk',true);       
         if($usk!=$_REQUEST['sk']) return;    
         $pid = uniqid();          
         update_user_meta($userdata->ID,'remind_pass_sk',$pid);
         wp_update_user(array('ID'=>$userdata->ID,'user_pass'=>$_POST['user_pass']));
         header("location: ".home_url('/members/'));
         die();
    }

    function wpdm_do_logout(){
        global $wp_query; 
        if($_GET['task']=='logout'){
         wp_logout();
         header("location: ".home_url('/'));
         die();
        }
    }

    
    function wpdm_category($params){
        include('embed-category.php');  
        $params['order_field'] = $params['order_by'];
        unset($params['order_by']);
        if(isset($params['item_per_page'])&&!isset($params['items_per_page'])) $params['items_per_page'] = $params['item_per_page'];
        unset($params['item_per_page']);
        return wpdm_embed_category($params);  
        
    }
    
    function wpdm_delete_emails(){  
        global $wpdb;   
        $task = isset($_GET['task'])?$_GET['task']:'';                     
        $page = isset($_GET['page'])?$_GET['page']:'';                     
       if($task=='delete'&&$page=='file-manager/emails'){                  
           $ids = implode(",",$_POST['id']);
           $wpdb->query("delete from {$wpdb->prefix}ahm_emails where id in ($ids)");
           header("location: admin.php?page=file-manager/emails");
           die();
       }
    }
    
    function wpdm_export_emails(){       
         global $wpdb;                   
         $task = isset($_GET['task'])?$_GET['task']:'';
        if($task=='export'&&$_GET['page']=='file-manager/emails'){                 
            $custom_fields = array();
            $custom_fields = apply_filters('wpdm_export_custom_form_fields',$custom_fields);
            $res = $wpdb->get_results("select e.* from {$wpdb->prefix}ahm_emails e where 1 $cond $group order by id desc",ARRAY_A);
            if($_GET['uniq']==1)
            $res = $wpdb->get_results("select email,custom_data from {$wpdb->prefix}ahm_emails group by email",ARRAY_A);
            $csv.= "\"email\", \"".implode("\", \"",$custom_fields)."\", \"date\"\r\n";            
            foreach($res as $row){
                $data = array();
                $data['email'] = $row['email'];
                $cf_data = unserialize($row['custom_data']);
                foreach($custom_fields as $c){
                $data[$c] = $cf_data[$c];  
                }
                $data['date'] = date("Y-m-d H:i",$row['date']);
                $csv.= '"'.@implode('","',$data).'"'."\r\n";
            }
            header("Content-Description: File Transfer");
            header("Content-Type: text/csv; charset=UTF-8");
            header("Content-Disposition: attachment; filename=\"emails.csv\"");
            header("Content-Transfer-Encoding: binary");        
            header("Content-Length: " . strlen($csv));    
            echo $csv;
            die();
        }
    }
    
    function wpdm_save_email_template(){
        if(isset($_POST['task'])&&$_POST['task']=='save-etpl'){
            update_option('_wpdm_etpl',$_POST['et']);
            header("location: admin.php?page=file-manager/emails&task=template");
            die();
        }
        
    }
    
    function wpdm_emails(){          
        if($_GET['task']=='template')
        include("wpdm-emails-template.php");
        else
        include("wpdm-emails.php");
    }
    
    /**
    * Query wpdm packages
    * 
    * @param mixed $args    
    */
    function wpdm_get_packages($args = array()){
        global $wpdm_query, $wpdm_packages, $wp_query, $wpdb;        
        extract($args);
        $order_field = isset($order_field)?$order_field:'create_date';
        $order = isset($order)?$order:'desc';
        $page = isset($page) ? $page : 1;        
        $items_per_page = $items_per_page?$items_per_page:9;         
        $start = ($page-1)*$items_per_page;
        $wpdm_query['wpdm_category'] = $wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]?$wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]:$args['wpdm_category'];
        if(!is_array($wpdm_query))  $wpdm_query = array();
        $wpdm_query = $wpdm_query + $args;
        $qry[] = 1;
       
        if($wpdm_query['wpdm_category']!='') $qry[] = "category like '%\"{$wpdm_query[wpdm_category]}\"%'";
        if($wpdm_query['search']!='') $qry[] = "title like '%{$wpdm_query[search]}%' or description like '%{$wpdm_query[search]}%'";        
        $qry = implode(" and ", $qry);
        $wpdm_packages = $wpdb->get_results("select * from {$wpdb->prefix}ahm_files where $qry order by $order_field $order limit $start,$items_per_page",ARRAY_A);         
        for($index = 0; $index <count($wpdm_packages); $index++){
            $wpdm_packages[$index]['files'] = unserialize($wpdm_packages[$index]['files']);
            $wpdm_packages[$index]['access'] = unserialize($wpdm_packages[$index]['access']);
            $wpdm_packages[$index]['category'] = unserialize($wpdm_packages[$index]['category']);
            $wpdm_packages[$index] = apply_filters('wpdm_data_init',$wpdm_packages[$index]);    
            $wpdm_packages[$index] = wpdm_setup_package_data($wpdm_packages[$index]);     
             
        }
        return $wpdm_packages;        
    }
    
    function wpdm_count_packages($args = array()){
        global $wpdm_query, $wpdm_packages, $wp_query, $wpdb;        
        extract($args);
        $order_field = isset($order_field)?$order_field:'create_date';
        $order = isset($order)?$order:'desc';
        $start = isset($start)?$start:0;
        $items_per_page = $items_per_page?$items_per_page:9;
        $wpdm_query['wpdm_category'] = $wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]?$wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]:$args['wpdm_category'];
        if(!is_array($wpdm_query))  $wpdm_query = array();
        $wpdm_query = $wpdm_query + $args;
        $qry[] = 1;
       
        if($wpdm_query['wpdm_category']!='') $qry[] = "category like '%\"{$wpdm_query[wpdm_category]}\"%'";
        if($wpdm_query['search']!='') $qry[] = "title like '%{$wpdm_query[search]}%' or description like '%{$wpdm_query[search]}%'";        
        $qry = implode(" and ", $qry);
        return $wpdb->get_var("select count(*) from {$wpdb->prefix}ahm_files where $qry");        
    }
  
        
    function wpdm_search_result($args = array()){
        $total = wpdm_count_packages($args);
        $item_per_page =  10;    
        $pages = ceil($total/$item_per_page);
        $page = $_GET['cp']?$_GET['cp']:1;
        $start = ($page-1)*$item_per_page;
        $pag = new wpdm_pagination();             
        $pag->changeClass('wpdm-ap-pag');
        $pag->items($total);
        $pag->limit($item_per_page);
        $pag->currentPage($page);
        $url = strpos($_SERVER['REQUEST_URI'],'?')?$_SERVER['REQUEST_URI'].'&':$_SERVER['REQUEST_URI'].'?';
        $url = preg_replace("/\&cp=[0-9]+/","",$url);
        $pag->urlTemplate($url."cp=[%PAGENO%]"); 
        $packages = wpdm_get_packages($args);
       
        foreach($packages as $package){
            if($package['preview']=='')
            $package['preview'] = "download-manager/preview/noimage.gif";
            $package['thumb'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_thumb_w').'&h='.get_option('_wpdm_thumb_h').'&zc=1&src='.$package[preview]."'/>";
            $package['thumb_page'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_pthumb_w').'&h='.get_option('_wpdm_pthumb_h').'&zc=1&src='.$package[preview]."'/>";
            $package['thumb_gallery'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_athumb_w').'&h='.get_option('_wpdm_athumb_h').'&zc=1&src='.$package[preview]."'/>";
            $package['thumb_widget'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_wthumb_w').'&h='.get_option('_wpdm_wthumb_h').'&zc=1&src='.$package[preview]."'/>";
            if($package['icon']!='')
            $package['icon'] = "<img class='wpdm_icon' align='left' src='".plugins_url()."/{$package[icon]}' />";            
            $package['download_url'] = wpdm_download_url($package);
            $package = apply_filters('wdm_pre_render_link', $package);            
            echo FetchTemplate("link-template-search-result.php",$package,'link');
        }
    } 
    
    
    function wpdm_page_links($urltemplate, $total, $page = 1, $items_per_page = 10){
            if($items_per_page<=0) $items_per_page = 10; 
            $page = $page?$page:1;           
            $pages = ceil($total/$items_per_page);            
            $start = ($page-1)*$items_per_page;            
            $pag = new wpdm_pagination();             
            $pag->items($total);
            $pag->nextLabel(' <i class="icon icon-forward"></i> ');
            $pag->prevLabel(' <i class="icon icon-backward"></i> ');
            $pag->limit($items_per_page);
            $pag->urlTemplate($urltemplate);             
            $pag->currentPage($page);
            return $pag->show();            
    }
    
    function wpdm_get_preview_templates($type='link'){
        if(!defined('WPDM_DEV_MODE')||WPDM_DEV_MODE==0) return "";
                  $ctpls = scandir(WPDM_BASE_DIR.'/templates/');
                  array_shift($ctpls);
                  array_shift($ctpls);
                  $type = $type?$type:'link';
                  $ptpls = $ctpls;

            ob_start();
        ?>
            <form action="" method="get" id="frm" class="alert alert-success">
            <strong>&nbsp;&nbsp;&nbsp;Dev Mode Enabled:</strong>
            <table style="margin: 0px;border:0px" cellpadding="5"><tr style="border: 0px"><td style="border: 0px">&nbsp;&nbsp;&nbsp;Select Template For Preview:</td><td style="border: 0px">
            <select name="wpdm_<?php echo $type; ?>_template" id="pge_tpl" onchange="jQuery('#frm').submit();"> 
            <option value="<?php echo $type; ?>-template-default.php">Select</option>
            <?php
                               
                                  $pattern = $type=='link'?"/WPDM[\s]+Link[\s]+Template[\s]*:([^\-\->]+)/":"/WPDM[\s]+Template[\s]*:([^\-\->]+)/";
                                  foreach($ptpls as $ctpl){
                                  $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                                  if(preg_match($pattern,$tmpdata, $matches)){       
                
            ?>
            <option value="<?php echo $ctpl; ?>"  <?php echo $_GET['wpdm_'.$type.'_template']==$ctpl?'selected=selected':''; ?>><?php echo $matches[1]; ?></option>
            <?php    
            }  
            } 

            if($templates = unserialize(get_option("_fm_{$type}_templates",true))){ 
              foreach($templates as $id=>$template) {  
            ?>
            <option value="<?php echo $id; ?>"  <?php echo ( $file['page_template']==$id )?' selected=selected ':'';  ?>><?php echo $template['title']; ?></option>
            <?php } } ?>
            </select>
            </td></tr></table>
            </form>
        <?php
           $data = ob_get_contents();
           ob_clean();
           return $data;
    }
        
    
    function wpdm_embed_category($params = array('id'=>'', 'items_per_page'=>10,'title'=> false, 'desc'=> false, 'order_field'=> 'create_date', 'order'=>'desc','paging'=>false,'toolbar'=>1,'template'=>'')){    
            extract($params);    
            $id = trim($id,", ");
            $cids = explode(",",$id);
            if(defined('WPDM_DEV_MODE')&&WPDM_DEV_MODE==1){                 
                $template = $_GET['wpdm_link_template']?$_GET['wpdm_link_template']:$category['link_temnplate'];
            }         
            global $wpdb, $current_user, $post, $wp_query;             
            $postlink = get_permalink($post->ID);
            get_currentuserinfo();     
            $user = new WP_User(null);
            $categories = maybe_unserialize(get_option("_fm_categories"));
            $actas = array();
            foreach($cids as $id){
            $categories = maybe_unserialize(get_option("_fm_categories"));    
            $category = $categories[trim($id)];
            $current_user_role = is_user_logged_in()?$current_user->roles[0]:'guest';             
            $category['access'] = !isset($category['access'])||!is_array($category['access'])?array('guest'):$category['access'];            
            //check if current user is allowed to access to this category                         
            if(!@in_array($current_user_role, $category['access'])&&count($category['access'])>0&&$category['access'][0]!='guest') {}
            else $acats[] = $id;
           
            }       
            
            if(count($acats)==0)
            return "<div class='wpdmpro'><div class='alert alert-danger'>".get_option('__wpdm_category_access_blocked',__('You are not allowed to access this category!','wpdmpro'))."</div></div>";
            foreach($acats as $cid){
                $qcids[] = "category like  '%\"".trim($cid)."\"%'"; 
            }   
            if(isset($_GET['src'])&&$_GET['src']!=''){
                $aqcids  = " and ( title like  '%".trim($_GET['src'])."%' or description like  '%".trim($_GET['src'])."%' )";                  
            }
            $qcids = implode(" or ", $qcids);
            if(!$qcids) return "Category id missing!";
            
            $total = $wpdb->get_var("select count(*) from {$wpdb->prefix}ahm_files where ($qcids) $aqcids");            
             
            if($items_per_page<=0) $items_per_page = 10;            
            $pages = ceil($total/$items_per_page);
            $page = $_GET['cp']?$_GET['cp']:1;
            $start = ($page-1)*$items_per_page;
            if(!isset($paging)||$paging==1){
            $pag = new wpdm_pagination();             
            $pag->items($total);
            $pag->nextLabel(' &#9658; ');
            $pag->prevLabel(' &#9668; ');
            $pag->limit($items_per_page);
            $pag->currentPage($page);
            }
                        
            $order_field = $order_field?$order_field:'id';
            $order_field = isset($_GET['orderby'])?$_GET['orderby']:$order_field;
            $order = $order?$order:'desc';
            $order =  isset($_GET['order'])?$_GET['order']:$order;
                         
            $url = strpos($_SERVER['REQUEST_URI'],'?')?$_SERVER['REQUEST_URI'].'&':$_SERVER['REQUEST_URI'].'?';
            $url = preg_replace("/[\&]*cp=[0-9]+[\&]*/","",$url);
            $url = strpos($url,'?')?$url.'&':$url.'?';
            if(!isset($paging)||$paging==1)
            $pag->urlTemplate($url."cp=[%PAGENO%]");
            
            $ndata = $wpdb->get_results("select * from {$wpdb->prefix}ahm_files where ($qcids) $aqcids order by $order_field $order limit $start,$items_per_page",ARRAY_A);                                      
             
            $sap = count($_GET)>0?'&':'?';
            $html = '';
            $templates = maybe_unserialize(get_option("_fm_link_templates",true));
            $lnktpl = $category['link_template'];
            
            if(defined('WPDM_DEV_MODE')&&WPDM_DEV_MODE==1){                 
                $category['link_temnplate'] = $_GET['wpdm_link_template']?$_GET['wpdm_link_template']:$category['link_temnplate'];
            }
            
             
            if(file_exists(WPDM_BASE_DIR.'/templates/'.$category['link_template'])) $category['link_template'] = @file_get_contents(WPDM_BASE_DIR.'/templates/'.$category['link_template']);
            else $category['link_template'] = $templates[$category['link_template']]['content'];             
            $link_temnplate = $category['link_template']==''?$category['template_repeater']:$category['link_template'];            
             
            if(isset($template)&&$template) $link_temnplate = $template;
            if(isset($template)&&$templates[$template]['content']!='') $link_temnplate = $templates[$template]['content'];
            
                        
            foreach($ndata as $data){
   
            $link_label = $data['title']?$data['title']:'Download';  
            $data['title'] = stripcslashes($data['title']);
            $data['description'] = stripcslashes($data['description']);
            //$data['popup_link'] = "<a href='#' onclick='javascript:window.open(\"{$_SERVER[REQUEST_URI]}{$sap}download={$data[id]}\",\"Window1\",\"menubar=no,width=400,height=200,toolbar=no, left=\"+((screen.width/2)-200)+\", top=\"+((screen.height/2)-100));return false;' style=\"background:url('".plugins_url()."/download-manager/images/icons/download.png') left center no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;\">$link_label</a>";    
            //$data['popup_link'] = "<a href='#' onclick='javascript:window.open(\"{$_SERVER[REQUEST_URI]}{$sap}wpdm_page={$data[id]}&mode=popup\",\"Window1\",\"menubar=no,width=500,height=350,toolbar=no, left=\"+((screen.width/2)-200)+\", top=\"+((screen.height/2)-100));return false;' >$link_label</a>";    
            //$data['page_link'] = "<a href='".wpdm_flat_url($data)."'>$link_label</a>";             
            if($data[preview]!='')  {
                $data['thumb'] = "<img class='wpdm_icon' align='left' src='".plugins_url()."/{$data[preview]}' />";
                $data['thumb_page'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_pthumb_w').'&h='.get_option('_wpdm_pthumb_h').'&zc=1&src='.$data[preview]."'/>";
                $data['thumb_gallery'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_athumb_w').'&h='.get_option('_wpdm_athumb_h').'&zc=1&src='.$data[preview]."'/>";
                $data['thumb_widget'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_wthumb_w').'&h='.get_option('_wpdm_wthumb_h').'&zc=1&src='.$data[preview]."'/>";
            }
            else {
                $data['thumb'] = '';
            }
            if($data[icon]!='')
            $data['icon'] = "<img class='wpdm_icon' align='left' src='".plugins_url()."/{$data[icon]}' />";
            else
            $data['icon'] = '<img  src="'. plugins_url('download-manager/file-type-icons/'). (count(unserialize($data['files']))<=1?end(explode('.',end(unserialize($data['files'])))):'zip').'.png" onError=\'this.src="'.plugins_url('download-manager/file-type-icons/_blank.png').'";\' />';
            
            //$data = apply_filters('wdm_pre_render_link', $data);        
            
            $role = array_shift(array_keys($current_user->caps));      
            /*if(is_user_logged_in()&&!@in_array($role, maybe_unserialize($data['access']))&&!@in_array('guest', maybe_unserialize($data['access']))){
            //$html .= "<div  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;color:#800000\">Permisson denied!</div>";   
            }
            else if(!@in_array('guest', maybe_unserialize($data['access']))&&!is_user_logged_in()){
            //$html .= "<a href='".get_option('siteurl')."/wp-login.php'  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;\">Please login to access downloadables</a>";    
            } else if(@in_array('guest', maybe_unserialize($data['access']))||@in_array($role, maybe_unserialize($data['access']))){
                //     editing link template
                */
                        
                
                //$templates = $templates[$data['template']] ;
                
               
                    if($data[preview]=='')
                    $data[preview] = "download-manager/preview/noimage.gif";
                    $thumb = plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_thumb_w').'&h='.get_option('_wpdm_thumb_h').'&zc=1&src='.$data['preview'];
                    $data['thumb'] = "<img class='package_preview_thumb' src='{$thumb}' />";
                    $data['thumb_page'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_pthumb_w').'&h='.get_option('_wpdm_pthumb_h').'&zc=1&src='.$data[preview]."'/>";
                    $data['thumb_gallery'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_athumb_w').'&h='.get_option('_wpdm_athumb_h').'&zc=1&src='.$data[preview]."'/>";
                    $data['thumb_widget'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_wthumb_w').'&h='.get_option('_wpdm_wthumb_h').'&zc=1&src='.$data[preview]."'/>";
                    $data['files'] = unserialize($data['files']);
                    if($data['show_counter']==1){
                        $counter = "{$data[download_count]} downloads<br/>";
                    }
                    $data = apply_filters('wdm_pre_render_link', $data);                                              
                    $repeater = FetchTemplate($link_temnplate, $data);   
                    
                    $html .= "".$repeater;
                     
                  
                    
                
                
                //}   
                
         
                
        }
         
        switch($lnktpl)    {
                case 'link-template-bsthumnail.php':                 
                    $html = "<ul class='thumbnails' style='list-style:none;margin:0px;padding:0px;'>$html</ul>";
                break;
        }                              
                    
         
        $category['title'] = stripcslashes($category['title']);
        $category['content'] = stripcslashes($category['content']);
         
        if($title==1&&count($cids)==1) $title = "<h3>$category[title]</h3>";         
        if($desc==1&&count($cids)==1) $desc = "<p>$category[content]<p>";
         

        $subcats = '';
        if(function_exists('wpdm_ap_categories')&&$subcats==1) {
        $schtml = wpdm_ap_categories(array('parent'=>$id));    
        if($schtml!=''){
          
        $subcats = "<fieldset class='cat-page-tilte'><legend>Sub-Categories</legend>".$schtml."<div style='clear:both'></div></fieldset>"."<fieldset class='cat-page-tilte'><legend>Downloads</legend>";
        $efs = '</fieldset>';
        }}

        if(!isset($paging)||$paging==1)
        $pgn = "<div style='clear:both'></div>".$pag->show()."<div style='clear:both'></div>";        
        else 
        $pgn = "";
        global $post;
        $burl = wpdm_canonical_url(get_permalink());        
        $sap = get_option('permalink_structure')?'?':'&';         
        $burl = $burl.$sap;
        if($_GET['p']!='') $burl .= 'p='.$_GET['p'].'&';
        if($_GET['src']!='') $burl .= 'src='.$_GET['src'].'&';
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:'create_date';         
        $order = ucfirst($order);
        $order_field = " ". ucwords(str_replace("_"," ",$order_field));
        if($toolbar||get_option('_wpdm_show_ct_bar'))        
        $toolbar =<<<TBR
                  
                <div class="navbar navbar-inverse">
                <div class="navbar-inner">
                <div class="container">                 
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </a>
                
                <a class="brand" href="#" style="font-size:11pt;font-weight:bold;line-height:normal">{$title}</a>
                <div class="nav-collapse collapse">                  
                 <ul class="nav">                       
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Order By {$order_field} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                         <li><a href="{$burl}orderby=title&order=asc">Title</a></li>
                         <li><a href="{$burl}orderby=download_count&order=desc">Downloads</a></li>
                         <li><a href="{$burl}orderby=create_date&order=desc">Create Date</a></li>
                         <li><a href="{$burl}orderby=update_date&order=desc">Update Date</a></li>
                        </ul>
                     </li>
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">$order <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                         <li><a href="{$burl}orderby={$orderby}&order=asc">Asc</a></li>
                         <li><a href="{$burl}orderby={$orderby}&order=desc">Desc</a></li>
                        </ul>
                     </li>  
                     
                 </ul> 
                                 
                    <form class="navbar-search pull-right">
                    <input type="text" name="src" class="search-query" placeholder="Search">
                    </form> 
                </div>
                 
                </div>
                </div>
                </div>
TBR;
        else
        $toolbar = '';
        return "<div class='wpdmpro'>".$toolbar.$desc.$subcats.wpdm_get_preview_templates('link').$html.$efs.$pgn."<div style='clear:both'></div></div>";
        }  
        
    function wpdm_pacakge_file_list($file){
        $file['files'] = maybe_unserialize($file['files']);
        $idvdl = get_wpdm_meta($file['id'],'individual_download');
        if(count($file['files'])>0) {
        $fileinfo = get_wpdm_meta($file['id'],'fileinfo');    
        $pwdlock = get_wpdm_meta($file['id'],'password_lock',true);
        if($pwdlock) $pwdcol = "<th>Password</th>";
        if($idvdl) $pwdcol = "<th align=center>Download</th>";
        $fhtml = "<table class='wpdm-filelist table table-hover'><tr><th>File</th>{$pwdcol}{$dlcol}</tr>";         
        foreach($file['files'] as $ind=>$sfile){    
        if(!is_array($fileinfo[$sfile])) $fileinfo[$value] = array();        
        if($idvdl==1) {
            if($fileinfo[$sfile]['password']==''&&$pwdlock) $fileinfo[$sfile]['password'] = $file['password'];
            $ttl = $fileinfo[$sfile][title]?$fileinfo[$sfile][title]:preg_replace("/([0-9]+)_/","",$sfile);
            $fhtml .= "<tr><td>{$ttl}</td>";            
            if($fileinfo[$sfile]['password']!='')
            $fhtml .= "<td width='110' align=right><input style='padding:3px;font-size:9pt;margin:0px;' onkeypress='jQuery(this).removeClass(\"error\");' size=10 type='text' value='Password' id='pass_{$file[id]}_{$ind}' onfocus='this.select()' onblur='if(this.value==\"\") this.value=\"Password\"' name='pass' class='input input-small inddlps' /></td>";                
            if($fileinfo[$sfile]['password']!='')
            $fhtml .= "<td width=150><button class='inddl btn btn-small' file='{$sfile}' rel='".wpdm_download_url($file)."&ind=".$ind."' pass='#pass_{$file[id]}_{$ind}'><i class='icon icon-download'></i>&nbsp;Download</button></td></tr>";
            else
            $fhtml .= "<td width=150 align=center><a class='btn btn-mini' href='".wpdm_download_url($file)."&ind=".$ind."'><i style='opacity:0.5;margin-top:0px' class='icon icon-download-alt'></i>&nbsp;Download</a></td></tr>";
            }
            else {
            $ttl = $fileinfo[$sfile][title]?$fileinfo[$sfile][title]:preg_replace("/([0-9]+)wpdm_/","",$sfile);
            $fhtml .= "<tr><td>{$ttl}</td></tr>";
            }
        }
            $fhtml .= "</table>";
        }
                 

        return  $fhtml;
        
    }
    
    function wpdm_setup_package_data($vars) {
        if(isset($vars['formatted'])) return $vars;
         
        global $wp_query;
        $vars['title'] = stripcslashes($vars['title']);
        $vars['description'] = stripcslashes($vars['description']);
        $vars['description'] = wpautop(stripslashes($vars['description']));
        //$vars['description'] = apply_filters('the_content',stripslashes($wpdm_package['description']));
        $vars['files'] = is_array($vars['files'])?$vars['files']:unserialize($vars['files']);
        $vars['file_count'] = count(maybe_unserialize($vars['files']));
        $vars['file_list'] = wpdm_pacakge_file_list($vars);
        $package['link_label'] = $package['link_label']?$package['link_label']:__('Download','wpdmpro');
        $size = 0;
        if(is_array($vars['files'])){
        foreach($vars['files'] as $f){
            if(file_exists($f))
            $size += @filesize($f);
            else
            $size += @filesize(UPLOAD_DIR.$f);
        }}
        $vars['file_size'] = $size/1024;
        if($vars['file_size']>1024) $vars['file_size'] = number_format($vars['file_size']/1024,2).' MB';
        else $vars['file_size'] = number_format($vars['file_size'],2).' KB';
        $vars['create_date'] = $vars['create_date']?@date(get_option('date_format'),$vars['create_date']):@date(get_option('date_format'),get_wpdm_meta($vars['id'],'create_date'));
        $vars['update_date'] = $vars['update_date']?@date(get_option('date_format'),$vars['update_date']):@date(get_option('date_format'),get_wpdm_meta($vars['id'],'update_date'));        
        $vars['version'] = get_wpdm_meta($vars['id'],'version');
        $type = ($wp_query->query_vars['post_type']!='wpdmpro'||$wp_query->query_vars[get_option('__wpdm_purl_base','download')]=='')?'link':'page';
        $vars['audio_player'] = wpdm_audio_preview($vars,$type);        
        $vars['quick_download'] = wpdm_ddl_button($vars,$type=='link');
        $vars['email_download'] = wpdm_email_button($vars,$type=='link');  
                 
        if($vars['icon']=='')
        $vars['icon'] = '<img  src="'. plugins_url('download-manager/file-type-icons/'). (@count($vars['files'])<=1?@end(@explode('.',@end($vars['files']))):'zip').'.png" onError=\'this.src="'.plugins_url('download-manager/file-type-icons/_blank.png').'";\' />';
        else if(!strpos($vars['icon'],'://'))
        $vars['icon'] = '<img  src="'. plugins_url($vars['icon']).'";\' />';
        else
        $vars['icon'] = '<img  src="'. $vars['icon'].'";\' />';
        
        if($vars[preview]!=''){
        $vars['thumb'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_thumb_w').'&h='.get_option('_wpdm_thumb_h').'&zc=1&src='.$vars[preview]."'/>";
        $vars['thumb_page'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_pthumb_w').'&h='.get_option('_wpdm_pthumb_h').'&zc=1&src='.$vars[preview]."'/>";
        $vars['thumb_gallery'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_athumb_w').'&h='.get_option('_wpdm_athumb_h').'&zc=1&src='.$vars[preview]."'/>";
        $vars['thumb_widget'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_wthumb_w').'&h='.get_option('_wpdm_wthumb_h').'&zc=1&src='.$vars[preview]."'/>";
        }
        else
        $vars['thumb'] = $vars['thumb_page'] = $vars['thumb_gallery'] = $vars['thumb_widget'] = "";
        
        $k = 1;
        $file['additional_previews'] = get_wpdm_meta($file[id],'more_previews');         
        $img = "<img id='more_previews_{$k}' title='' class='more_previews' src='".plugins_url()."/download-manager/timthumb.php?w=575&h=170&zc=1&src={$file[preview]}'/>\n";
        $tmb = "<a href='#more_previews_{$k}' class='spt'><img title='' src='".plugins_url()."/download-manager/timthumb.php?w=100&h=45&zc=1&src={$file[preview]}'/></a>\n";
        if($file['additional_previews']){
            foreach($file['additional_previews'] as $p){
                ++$k;
                $img .= "<img style='display:none;position:absolute' id='more_previews_{$k}' class='more_previews' title='' src='".plugins_url().'/download-manager/timthumb.php?w=575&h=170&zc=1&src=wp-content/plugins/download-manager/preview/'.$p."'/>\n";
                $tmb .= "<a href='#more_previews_{$k}' class='spt'><img id='more_previews_{$k}' title='' src='".plugins_url().'/download-manager/timthumb.php?w=100&h=45&zc=1&src=wp-content/plugins/download-manager/preview/'.$p."'/></a>\n";
            }}
        $file['slider-previews'] = "<div class='slider' style='height:180px;'>".$img."</div><div class='tmbs'>$tmb</div>";
        $file['all-previews'] = "<div class='slider' style='height:180px;'>".$img."</div><div class='tmbs'>$tmb</div>";


        //WPMS fix
        global $blog_id;        
        if(defined('MULTISITE'))  {
        $vars['thumb'] = str_replace(home_url('/files'),ABSPATH.'wp-content/blogs.dir/'.$blog_id.'/files',$vars['thumb']);
        $vars['thumb_page'] = str_replace(home_url('/files'),ABSPATH.'wp-content/blogs.dir/'.$blog_id.'/files',$vars['thumb_page']);
        $vars['thumb_gallery'] = str_replace(home_url('/files'),ABSPATH.'wp-content/blogs.dir/'.$blog_id.'/files',$vars['thumb_gallery']);
        $vars['thumb_widget'] = str_replace(home_url('/files'),ABSPATH.'wp-content/blogs.dir/'.$blog_id.'/files',$vars['thumb_widget']);
        }
        
        //$vars['popup_link'] = "<a href='{$postlink}{$sap}wpdm_page={$id}&mode=popup' class='popup-link' >$vars[title]</a>";    
        //$vars['page_link'] = "<a href='{$postlink}{$sap}wpdm_page={$id}'>$vars[title]</a>";
        
        //$emb = (isset($wp_query->query_vars[get_option('__wpdm_purl_base','download')])&&$wp_query->query_vars[get_option('__wpdm_purl_base','download')]>0)?1:0;             
        if(!isset($vars['download_link_called'])){          
        $vars['download_link'] = DownloadLink($vars,0, array('btnclass'=>'[btnclass]'));            
        $vars['download_link_extended'] = DownloadLink($vars,1);   
        $vars['download_link_called'] = 1;         
        }
        
        $vars = apply_filters("wdm_before_fetch_template", $vars);                 
        
        ++$vars['formatted'];
        return $vars;
    }
    
    
   
    function FetchTemplate($template, $vars, $type='link'){         
        if($vars['id']=='') return '';
           
       
        $default['link'] = file_get_contents(dirname(__FILE__).'/templates/link-template-default.php');    
        $default['popup'] = file_get_contents(dirname(__FILE__).'/templates/page-template-default.php');              
        $default['page'] =file_get_contents(dirname(__FILE__).'/templates/page-template-default.php');
                 
          
        $vars = wpdm_setup_package_data($vars);
         
        if($template=='')
        $template = $default[$type];
                 
           
        if(file_exists(TEMPLATEPATH.'/'.$template)) $template = file_get_contents(TEMPLATEPATH.'/'.$template);
        else if(file_exists(dirname(__FILE__).'/templates/'.$template)) $template = file_get_contents(dirname(__FILE__).'/templates/'.$template);         
        
        preg_match_all("/\[thumb_([0-9]+)x([0-9]+)\]/",$template, $matches);
        preg_match_all("/\[thumb_url_([0-9]+)x([0-9]+)\]/",$template, $umatches);
        preg_match_all("/\[thumb_gallery_([0-9]+)x([0-9]+)\]/",$template, $gmatches);
        preg_match_all("/\[excerpt_([0-9]+)\]/",$template, $xmatches);
        preg_match_all("/\[download_link ([^\]]+)\]/",$template, $cmatches);
        
        foreach($matches[0] as $nd=>$scode){
            $keys[] = $scode;
            $values[] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.$matches[1][$nd].'&h='.$matches[2][$nd].'&zc=1&src='.$vars[preview]."'/>";    
        }
             
        foreach($umatches[0] as $nd=>$scode){
            $keys[] = $scode;
            $values[] = plugins_url().'/download-manager/timthumb.php?w='.$umatches[1][$nd].'&h='.$umatches[2][$nd].'&zc=1&src='.$vars[preview];    
        }
        
        foreach($gmatches[0] as $nd=>$scode){
            $keys[] = $scode;             
            $values[] = wpdm_get_additional_preview_images($vars, $gmatches[1][$nd], $gmatches[2][$nd]);
        }
        
        foreach($cmatches[0] as $nd=>$scode){
            $keys[] = $scode;             
            $values[] = str_replace('[btnclass]',$cmatches[1][$nd], $vars['download_link']);
        }
                 
        foreach($xmatches[0] as $nd=>$scode){
            $keys[] = $scode;             
            $ss = substr(strip_tags($vars['description']), 0, intval($xmatches[1][$nd]));
            $bw = array_shift($tmp = explode(" ", substr(strip_tags($vars['description']), intval($xmatches[1][$nd]))));
            $ss .=$bw;            
            $values[] = $ss.'...';
        }

        foreach($vars as $key=>$value){
            $keys[] = "[$key]";
            $values[] = $value;
        }    
        if($type=='page'&&current_user_can('manage_options')){
        $editlink = "<br /><a class='btn btn-warning' href='".admin_url()."admin.php?page=file-manager&task=EditPackage&id={$vars[id]}'><i class='icon icon-white icon-edit'></i> Edit Package</a>";
        }        
       
        return str_replace($keys, $values, stripcslashes($template)).$editlink;
    }
    
    function wpdm_show_notice(){
        global $wpdm_message;
        ?>
        <style type="text/css">
                .wpdm-message
                {
                        -webkit-background-size: 40px 40px;
                        -moz-background-size: 40px 40px;
                        background-size: 40px 40px;            
                        background-image: -webkit-gradient(linear, left top, right bottom,
                                                color-stop(.25, rgba(255, 255, 255, .05)), color-stop(.25, transparent),
                                                color-stop(.5, transparent), color-stop(.5, rgba(255, 255, 255, .05)),
                                                color-stop(.75, rgba(255, 255, 255, .05)), color-stop(.75, transparent),
                                                to(transparent));
                        background-image: -webkit-linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                                            transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                                            transparent 75%, transparent);
                        background-image: -moz-linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                                            transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                                            transparent 75%, transparent);
                        background-image: -ms-linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                                            transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                                            transparent 75%, transparent);
                        background-image: -o-linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                                            transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                                            transparent 75%, transparent);
                        background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                                            transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                                            transparent 75%, transparent);
                                                
                         -moz-box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);
                         -webkit-box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);        
                         box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);
                         width: 100%;
                         border: 1px solid;
                         color: #fff;                         
                         padding: 10px 20px;
                         top:0px;
                         left:0px;
                         z-index: 999999;
                         position: fixed;
                         _position: absolute;
                         text-shadow: 0 1px 0 rgba(0,0,0,.5);
                         -webkit-animation: animate-bg 5s linear infinite;
                         -moz-animation: animate-bg 5s linear infinite;
                         font-family: 'Segoe UI',Verdana;                                                  
                         font-size: 14pt;
                }

                

                .wpdm-error
                {
                         background-color: #de4343;
                         border-color: #c43d3d;
                         text-align: center;
                         
                }
                         
                

                .wpdm-message b
                {        font-size:14pt;
                         font-weight: bold;
                         margin: 0 0 0px 0;  
                         padding: 0px; 
                         font-family: 'Segoe UI',Verdana;                                                  
                         
                         margin-right: 20px;
                }

                .wpdm-message p
                {
                         margin: 0;                                                     
                }

                @-webkit-keyframes animate-bg
                {
                    from {
                        background-position: 0 0;
                    }
                    to {
                       background-position: -80px 0;
                    }
                }


                @-moz-keyframes animate-bg 
                {
                    from {
                        background-position: 0 0;
                    }
                    to {
                       background-position: -80px 0;
                    }
                }

        </style>
        <div class="wpdm-error wpdm-message">
         
         <p><b>Error!</b> <?php echo $wpdm_message;; ?></p>

</div>
        <?php
    }
    
    /***
    * Show notice
    * 
    * @param mixed $msg
    */
    function wpdm_notice($msg){
        global $wpdm_message;
        $wpdm_message = $msg;
        add_action('wp_footer','wpdm_show_notice');
    }
    
    /**
    * Process Download Request
    * 
    */

    function wpdm_downloadnow(){    
        
        global $wpdb, $current_user, $wp_query;        
        get_currentuserinfo();        
        $id = isset($_GET['wpdmdl'])?(int)$_GET['wpdmdl']:(int)$wp_query->query_vars['wpdmdl'];             
        if($id=='') return;
        $key = isset($_GET['wpdmdl'])?$_GET['_wpdmkey']:$wp_query->query_vars['_wpdmkey'];    
        $key = preg_replace("/[^a-z|A-Z|0-9]/i","", $key);         
        $package = $wpdb->get_row("select * from {$wpdb->prefix}ahm_files where id='$id'",ARRAY_A);
        if(is_array($package)){   
        $role = @array_shift(@array_keys($current_user->caps));      
        $cpackage = apply_filters('before_download', $package);                                   
        $package = $cpackage?$cpackage:$package;           
        if(get_wpdm_meta($package['id'],'email_lock')==1) $lock = 1;
        if(get_wpdm_meta($package['id'],'password_lock')==1) $lock = 1;
        if(get_wpdm_meta($package['id'],'gplusone_lock')==1) $lock = 1;
        if(get_wpdm_meta($package['id'],'facebooklike_lock')==1) $lock = 1;
        $limit = (int)trim(get_wpdm_meta($package['id'],$key));             
        if($limit<=0&&$key!='') delete_wpdm_meta($package['id'],$key);
        else if($key!='')
        update_wpdm_meta($package['id'],$key, $limit-1);         
        if(($id!=''&&is_user_logged_in()&&!@in_array($role, @unserialize($package['access']))&&!@in_array('guest', @unserialize($package['access'])))||(!is_user_logged_in()&&!@in_array('guest', @unserialize($package['access']))&&$id!='')){
        wpdm_download_data("permission-denaed.txt","You don't have permision to download this file");
        die();
        }
        else {  
        if($lock==1&&$limit<=0){
            wpdm_download_data("link-expired.txt","Download link expired. Please get new download link.");
            die();
        } else    
        if($package['id']>0)
        include("process.php");
        
        }}
        else
        wpdm_notice("Invalid download link.");
    }
    
    /*function wpdm_mail_download_link($id){
        global $wpdb, $current_user;        
        get_currentuserinfo();
        $id = (int)$_GET[file];    
        $package = $wpdb->get_row("select * from {$wpdb->prefix}ahm_files where id='$id'",ARRAY_A);
        $dkey = is_array($package['files'])?md5(serialize($package['files'])):md5($package['files']);
        $download_url = home_url("/?file={$package[id]}&downloadkey=".$dkey);
        file_get_contents();
        
    } */


      
    
    
    
 
    
    function wpdm_is_ajax(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        return true;
        return false;
    }
    
    /**
    * function for hiding wp pointer
    * added from v3.2.0
    * 
    */
    function wpdm_dismiss_pointer(){
        update_option($_POST['pointer'],1);
    }
    
    /**
    * Mp3 player
    * 
    * @param mixed $package
    */
    function wpdm_audio_preview($package, $type='link'){
        $player_url = plugins_url('download-manager/ext/player/player_mp3_maxi.swf');
        if(strtolower(end(explode('.',$package['files'][0])))!='mp3') return '';                 
        if(!$type) $type = 'link';
        if($package['sourceurl']!='')
        $song_url = $package['sourceurl'];
        $c = 0;
        $dicon = plugins_url("download-manager/images/download.png");
        $fileinfo = get_wpdm_meta($package['id'],'fileinfo');    
        foreach($package['files'] as $mp3) {
        if(end(explode(".",strtolower($mp3)))=='mp3'){
        $song_dl =  wpdm_download_url($package)."&ind={$c}";
        $song =  urlencode($song_dl.'&nostat=1');
        if($song_url=='') $song_url = $song;
        else $song_url = urlencode($song_url.'&nostat=1');
        $c++;            
        $songtitle = preg_replace("/[0-9]+\_/","",$mp3);
        $songtitle = str_replace(array("-",'_','.mp3'),' ',$songtitle);                
        $songtitle = $fileinfo[$mp3]['title']?$fileinfo[$mp3]['title']:$songtitle;
        $html['page'] .=<<<Player
              <tr><td valign="middle" width="30px" title="Play" style="line-height:normal;vertical-align:middle">
                <object type="application/x-shockwave-flash" data="{$player_url}" width="25" height="25"  style="float:left;margin:0px;">
                <param name="movie" value="{$player_url}" />
                <param name="bgcolor" value="transparent" />
                <param name="wmode" value="transparent" />
                <param name="FlashVars" value="mp3={$song}&amp;width=25&amp;height=25&amp;showstop=0&amp;showinfo=0&amp;showslider=0&amp;showvolume=0&amp;volume=200&amp;bgcolor1=0073ff&amp;bgcolor2=0073ff" />
            </object></td><td style="line-height:normal;vertical-align:middle"><a title="Download" class="qdb" href="$song_dl" >&#9660;</a></td><td style="line-height:normal;vertical-align:middle">{$songtitle}</td></tr>
Player;
        }} 
        $html['page'] = "<table class='dtable table'>{$html[page]}</table>";
        $html['popup'] = $html['page'];
        $html['link'] =<<<Player
            <object type="application/x-shockwave-flash" data="{$player_url}" width="50" height="50">
                <param name="movie" value="{$player_url}" />
                <param name="bgcolor" value="transparent" />
                <param name="wmode" value="transparent" />
                <param name="FlashVars" value="mp3={$song_url}&amp;width=50&amp;height=50&amp;showslider=0&amp;buttonwidth=50&amp;loadingcolor=008000&amp;bgcolor=ffffbd&amp;bgcolor1=0073ff&amp;bgcolor2=0073ff&amp;buttoncolor=cccccc&amp;buttonovercolor=ffffff" />
            </object>
Player;
        return $html[$type];
    }
        
    
    
    
    /**
    * Get template list options
    * 
    * @param mixed $type
    * @param mixed $tpl
    */
    function wpdm_get_templates($type,$tpl=''){
        ?>
        <option value="">Select</option>
        <?php
        if($templates = unserialize(get_option("_fm_{$type}_templates",true))){ 
          foreach($templates as $id=>$template) {  
        ?>
        <option value="<?php echo $id; ?>"  <?php echo ( $tpl==$id )?' selected=selected ':'';  ?>><?php echo $template['title']; ?></option>
        <?php } } 
    }
    
    function wpdm_get_page_templates(){
        wpdm_get_templates('page',$_REQUEST['tpl']);
        die();
    }
    
    function wpdm_get_link_templates(){
        wpdm_get_templates('link',$_REQUEST['tpl']);
        die();
    }

    
    function __msg($key){
        include("messages.php");
        return $msgs[$key]?$msgs[$key]:$key;
    }
    
    function delete_package_frontend(){
        global $wpdb, $current_user;
        if($_GET['task']=='delete-package'&&$_GET['id']!=''){
            $id = (int)$_GET['id'];
            $uid = $current_user->ID;
            if($uid=='') die('Error! You are not logged in.');
             
            $wpdb->query("delete from {$wpdb->prefix}ahm_files where id='{$id}' and uid='$uid'");
            header('location: '. $_SERVER['HTTP_REFERER']);
            die();
        }
    }
    
    /**
    * function to list all packages
    * 
    */
    function wpdm_all_packages(){    
     global $wpdb, $current_user;     
     $files = $wpdb->get_results("select * from {$wpdb->prefix}ahm_files order by create_date desc",ARRAY_A);
     foreach($files as $file){
     $users = explode(',',get_option("wpdm_package_selected_members_only_".$file['id']));         
     //$roles = unserialize($file['access']);
     //$myrole = $current_user->roles[0];
     //if(@in_array($current_user->user_login,$users)||@in_array($myrole, $roles))
        $myfiles[] = $file;
     }
     ob_start();
     include("wpdm-all-downloads.php");
     $data = ob_get_contents();
     ob_clean();  
     return $data;
}
/**
* Check if loggen in user is authorise admin
*     
*/
function wpdm_is_custom_admin()    {
    global $current_user, $add_new_page;
    $admins = explode(",",get_option('__wpdm_custom_admin',''));  
    return in_array($current_user->user_login, $admins)?true:false;                           
}

 

    

    
    
    function wpdm_add_help_tab () {
    global $add_new_page;
    $screen = get_current_screen();
   
    $page = array_shift(explode('/',$_GET['page']));
    if($page!='file-manager') return;
    // Add my_help_tab if current screen is My Admin Page
    $screen->add_help_tab( array(
        'id'    => 'my_help_tab_0',
        'title'    => __('Legends'),
        'content'    => '<p>' . "<img align=left src='".plugins_url('/download-manager/images/add-image.gif')."' hspace=10 />".__(" Click on the icon to launch media manager to select or upload preview images")."<br/><img align=left src='".plugins_url('/download-manager/images/reload.png')."' hspace=10 />".__(" Reload link or page templates." ) . '</p>',
    ) );
    
    $screen->add_help_tab( array(
        'id'    => 'my_help_tab_1',
        'title'    => __('Package Settings'),
        'content'    => '<p>' . __( "<b>Link Label:</b> Label to show with download link, like: download now, get it now<br/>
                                    <b>Password:</b> You can set single or multiple password for a package. In case of multiple password, each password have to be inside `[]`, like: [1234][456][789sf] and user will be able to download package using any one of them<br/>
                                    <b>PW Usage Limit:</b> When you are using multiple password, then you may want set a limit, how many time user will be able to use a password, you can set the numaric value here, suppose `n`. So each password will expire after it used for `n` times.<br/>
                                    <b>Stock Limit:</b> Should be a numeric value, suppose `9`. After package dowloaded for `9` times, the no one will able to download it anymore, will show 'out of stock' message<br/>
                                    <b>Download Limit/user:</b> Set a numeric value here if you want to block user after a certain times of download for this package.<br/>
                                    <b>Access</b>: Check the user roles, you want to enable to download this package, `All Visitors` will enable every one to download this package<br/>
                                    <b>Link Template:</b> Sortcode will be rendered based on select link template.<br/>
                                    <b>Page Template:</b> Package details page will be rendered based on selected page temaplte<br/>
                                " ) . '</p>',
    ) );
    
}

function wpdm_get_package($id){
    global $wpdb, $wpdm_package;
    $id = (int)$id;
    if($id<=0) return false;
    if($id==$wpdm_package['id']) return $wpdm_package;
    $data = $wpdb->get_row("select * from {$wpdb->prefix}ahm_files where id='$id'",ARRAY_A);
    $data['files'] = unserialize($data['files']);
    $data['access'] = unserialize($data['access']);
    $data['category'] = unserialize($data['category']);
    $data = apply_filters('wpdm_data_init',$data);                 
    $data = wpdm_setup_package_data($data);         
    return $data;
}

function wpdm_check_invpass(){
    if($_POST['actioninddlpvr']!=''){
    $data = get_wpdm_meta($_POST['wpdmfileid'],'fileinfo',true);     
    $data = $data?$data:array();
    $package = wpdm_get_package($_POST['wpdmfileid']);  
    $data[$_POST['wpdmfile']]['password'] = $data[$_POST['wpdmfile']]['password'] != ""?$data[$_POST['wpdmfile']]['password']:$package['password'];
    if($data[$_POST['wpdmfile']]['password']==$_POST['actioninddlpvr']||strpos($data[$_POST['wpdmfile']]['password'],"[".$_POST['actioninddlpvr']."]")!==FALSE){
    $id = uniqid();        
    update_wpdm_meta((int)$_POST['wpdmfileid'],$id,3);    
    die("|ok|$id|");}
    else
    die('|error|');
    }
}

function wpdm_generate_password(){
    include('wpdm-generate-password.php');
    die();

}

function wpdm_email_2download($params){
    $package = wpdm_get_package($params['id']);
    $html = wpdm_email_lock_form($package);
    $html = "<div class='wpdm-email2dl  drop-shadow lifted'><div class='wcon'><strong>$params[title]</strong><br/>{$params[msg]}<br clear='all' />$html</div></div>";
    return $html;
}
function wpdm_plus1_2download($params){
    $package = wpdm_get_package($params['id']);
    $html = wpdm_plus1st_google_plus_one($package);
    $html = "<div class='wpdm-email2dl  drop-shadow lifted'><div class='wcon'><strong>$params[title]</strong><br/>{$params[msg]}<br clear='all' />$html</div></div>";
    return $html;
}
  
function wpdm_like_2download($params){
    $package = wpdm_get_package($params['id']);
    $html = wpdm_facebook_like_button($package);
    $html = "<div class='wpdm-email2dl  drop-shadow lifted'><div class='wcon'><strong>$params[title]</strong><br/>{$params[msg]}<br clear='all' />$html</div></div>";
    return $html;
}


//add custom fields with csv file
function wpdm_export_custom_form_fields($custom_fields){
    $custom_fields[] = 'name';
    $custom_fields[] = 'company';
    $custom_fields[] = 'title';
    return $custom_fields;
}

//add cuistom fields option html to show in admin
function wpdm_ask_for_custom_data($pid){
    $cff = get_wpdm_meta($pid,'custom_form_field');
    ?>
   <table>
<tr><td>
<input type="checkbox" name="wpdm_meta[custom_form_field][name]" value="1" <?php if($cff['name']==1) echo 'checked=checked'; ?> > Ask for visitor's name    <br/>
<input type="checkbox" name="wpdm_meta[custom_form_field][company]" value="1" <?php if($cff['company']==1) echo 'checked=checked'; ?> > Ask for company name   <br/>  
<input type="checkbox" name="wpdm_meta[custom_form_field][title]" value="1" <?php if($cff['title']==1) echo 'checked=checked'; ?> > Ask for title   <br/>  
</td></tr>
</table> 
    
    <?php
}

//add cuistom fields html to show at front end with email form
function wpdm_render_custom_data($pid){
    if(!$pid) return;
    $cff = get_wpdm_meta($pid,'custom_form_field');
    $labels['name'] = 'Your Name';
    $labels['company'] = 'Company Name';
    $labels['title'] = 'Title';    
    if(!$cff) return;
    foreach($cff as $name=>$value){
    $html .= <<<DATA
    <label><nobr>{$labels[$name]}:</nobr></label><input placeholder="Enter {$labels[$name]}" type="text" name="custom_form_field[$name]" size=30 /><br/>
DATA;
}
return $html;
}

// Function that output's the contents of the dashboard widget
function wpdm_dashboard_widget_function() {
    echo "<img src='".plugins_url('/download-manager/images/wpdm-logo.png')."' /><br/>";
    ?>
    
    <iframe border=0 id="wpdmiframe"  style="border: 0px;width:100%;height:300px;" scrolling="no" src="http://wpdownloadmanager.com/notice.php?version=<?php echo WPDM_Version; ?>"></iframe>
    <script type="text/javascript">
    try{
       if(jQuery('#wpdmiframe').width()>500)
       jQuery('#wpdmiframe').css('height','300px').css('overflow','hidden');
       else
       jQuery('#wpdmiframe').css('height','380px').css('overflow','hidden');
    } catch(err) {}
    </script>
    <?php
}

// Function that beeng used in the action hook
function wpdm_add_dashboard_widgets() {
    wp_add_dashboard_widget('wpdm_dashboard_widget', 'WordPress Download Manager', 'wpdm_dashboard_widget_function');
    global $wp_meta_boxes;      
    $side_dashboard = $wp_meta_boxes['dashboard']['side']['core'];    
    $wpdm_widget = array('wpdm_dashboard_widget' => $wp_meta_boxes['dashboard']['normal']['core']['wpdm_dashboard_widget']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['wpdm_dashboard_widget']);
    $sorted_dashboard = array_merge($wpdm_widget, $side_dashboard);
    $wp_meta_boxes['dashboard']['side']['core'] = $sorted_dashboard;
}

function wpdm_custom_form_fields($id, $pack){
    if(!isset($_POST['wpdm_meta']['custom_form_field'])) delete_wpdm_meta($id,'custom_form_field');
}

add_action("after_add_package","wpdm_custom_form_fields",999,2);
add_action("after_update_package","wpdm_custom_form_fields",999,2);


// Register the new dashboard widget into the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'wpdm_add_dashboard_widgets' );


function wpmp_get_files($dir){
    global $dfiles;    
    $tdfiles = scandir($dir);
    array_shift($tdfiles);
    array_shift($tdfiles);
    foreach($tdfiles as $file_index=>$file){
        if(!is_dir($dir.$file))
            $dfiles[] = $dir.$file;
        else    
            wpmp_get_files($dir.$file.'/');
    }                       
}

function wpdm_currency($return = 0){
    if($return)
    return get_option('_wpdm_currency');
    echo  get_option('_wpdm_currency');
}
function wpdm_currency_sign($return = 0){
    if($return)
    return get_option('_wpdm_currency_symbol');
    echo  get_option('_wpdm_currency_symbol');
}

function wpdm_load_data(){
    global $wp_query, $wpdm_category, $wpdm_package;
    if($wp_query->query_vars[get_option('__wpdm_purl_base','download')]==''&&$wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]=='') return;
    
    if($wp_query->query_vars[get_option('__wpdm_purl_base','download')]!='') {
        //die($wp_query->query_vars[get_option('__wpdm_purl_base','download')]);         
        $wpdm_package = wpdm_get_package($wp_query->query_vars[get_option('__wpdm_purl_base','download')]);                 
         
    }
    
    if($wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]!=''){
        $cats = maybe_unserialize(get_option('_fm_categories'));
        $wpdm_category = $cats[$wp_query->query_vars[get_option('__wpdm_curl_base','downloads')]];    
        $wpdm_category['id'] = $wp_query->query_vars[get_option('__wpdm_curl_base','downloads')];
    }
        
}
                            
function wpdm_category_ID($return = 0){
    global $wp_query;
    if($return)
    return $wp_query->query_vars[get_option('__wpdm_curl_base','downloads')];    
    echo $wp_query->query_vars[get_option('__wpdm_curl_base','downloads')];    
}

function wpdm_category_title($return = 0){
    global $wpdm_category;
    if($return)
    return $wpdm_category['title'];
    echo $wpdm_category['title'];    
}

function wpdm_category_description($return = 0){
    global $wpdm_category;
    if($return)
    return $wpdm_category['content'];
    echo $wpdm_category['content'];
}


function wpdm_top_downloads($show=5, $linktemplate=''){
    global $wpdb, $post;
     
    $tdata = $wpdb->get_results("select * from {$wpdb->prefix}ahm_files order by download_count desc limit 0, $show",ARRAY_A);
    foreach($tdata as $data){      
        $postlink = get_permalink($post->ID);
        $data['page_url'] ="{$postlink}{$sap}wpdm_page={$id}";    
        $data['popup_link'] = "<a href='{$postlink}{$sap}wpdm_page={$id}&mode=popup' class='popup-link' >$link_label</a>";    
        $data['page_link'] = "<a href='{$postlink}{$sap}wpdm_page={$id}'>$link_label</a>";
        if($data['preview']=='')
        $data['preview'] = "download-manager/preview/noimage.gif";
        $data['thumb'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_wthumb_w',150).'&h='.get_option('_wpdm_wthumb_h',70).'&zc=1&src='.$data[preview]."'/>";
        if($data[icon]!='')
        $data['icon'] = "<img class='wpdm_icon' align='left' src='".plugins_url()."/{$data[icon]}' />";        
        $data = apply_filters('wdm_pre_render_link', $data);    
        $templates = unserialize(get_option("_fm_link_templates"));
        $linktemplates = maybe_unserialize(get_option("_fm_link_templates"));        
        if(isset($linktemplates[$linktemplate])&&$linktemplates[$linktemplate]!='') $linktemplate = $linktemplates[$linktemplate]['content'];
        $html .= "<li>".FetchTemplate($linktemplate, $data, 'link')."</li>";
        
    }
    echo $html;
}

function wpdm_new_packages($show=5, $linktemplate='', $show_count=true){
    global $wpdb;
     
    $tdata = $wpdb->get_results("select * from {$wpdb->prefix}ahm_files order by id desc limit 0, $show",ARRAY_A);
    foreach($tdata as $data){      
        $postlink = get_permalink($post->ID);
        $data['page_url'] ="{$postlink}{$sap}wpdm_page={$id}";    
        $data['popup_link'] = "<a href='{$postlink}{$sap}wpdm_page={$id}&mode=popup' class='popup-link' >$link_label</a>";    
        $data['page_link'] = "<a href='{$postlink}{$sap}wpdm_page={$id}'>$link_label</a>";
        if($data['preview']=='')
        $data['preview'] = "download-manager/preview/noimage.gif";
        $data['thumb'] = "<img src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_wthumb_w',150).'&h='.get_option('_wpdm_wthumb_h',70).'&zc=1&src='.$data[preview]."'/>";
        if($data[icon]!='')
        $data['icon'] = "<img class='wpdm_icon' align='left' src='".plugins_url()."/{$data[icon]}' />";        
        $data = apply_filters('wdm_pre_render_link', $data);    
        $linktemplates = unserialize(get_option("_fm_link_templates",true));
        $linktemplates = maybe_unserialize(get_option("_fm_link_templates"));        
        if(isset($linktemplates[$linktemplate])&&$linktemplates[$linktemplate]!='') $linktemplate = $linktemplates[$linktemplate]['content'];
        $html .= "<li>".FetchTemplate($linktemplate, $data, 'link')."</li>";
        
    }
    echo $html;
}


function wpdm_update_client_profile(){
    global $current_user;
    $task = isset($_REQUEST['wpdmtask'])?$_REQUEST['wpdmtask']:'';
    if($task!='wpdmupdateprofile'||!is_user_logged_in()) return;
    update_user_meta($current_user->ID,'_wpdm_client',$_POST['_wpdm_client']);
    die('Saved');
}


function wpdm_enqueue_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-form');     
    wp_enqueue_script('jquery-ui');     
    wp_enqueue_script('jquery-ui-datepicker');         
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');     

     
    wp_enqueue_style('icons',plugins_url().'/download-manager/css/front.css');    
    if(get_option('wpdm_exclude_bootstrap')==0){
    wp_enqueue_style('wpdm-bootstrap',plugins_url().'/download-manager/bootstrap/css/bootstrap.css');
    wp_enqueue_style('wpdm-bootstrap-responsive',plugins_url().'/download-manager/bootstrap/css/bootstrap-responsive.css');
    wp_enqueue_script('wpdm-bootstrap',plugins_url().'/download-manager/bootstrap/js/bootstrap.min.js',array('jquery'));     
    }
    wp_enqueue_script('jquery-cookie',plugins_url('/download-manager/js/jquery.cookie.js'),array('jquery'));    
        

}

function wpdm_admin_enqueue_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-form');     
    wp_enqueue_script('jquery-ui');     
    wp_enqueue_script('jquery-ui-datepicker');     
    wp_enqueue_style('icons',plugins_url().'/download-manager/css/icons.css'); 
    wp_enqueue_script('wp-pointer');         
    wp_enqueue_style('wp-pointer');    
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
}  

function wpdm_reorder_categories(){     
    if(isset($_POST['corder'])&&$_POST['corder']){   
        $tpldata = maybe_unserialize(get_option('_fm_categories'));
        if(count(($tpldata))==count($_POST['corder'])){
            foreach($_POST['corder'] as $ck){
                $neworder[$ck] = $tpldata[$ck];
            }
            update_option('_fm_categories',@serialize($neworder));
        }
        
        header("location: admin.php?page=file-manager/categories");
    }
} 

function wpdm_delete_all_cats(){
    if(isset($_GET['_nonce'])&&wp_verify_nonce($_GET['_nonce'],'wpdmdcs')&&$_GET['task']=='deleteallcats'){
    update_option('_fm_categories',array()); 
    header("location: admin.php?page=file-manager/categories");
    die();
    }
}

function wpdm_popup_link(){
    ?>
    <div id="wpdm-popup-link" class="modal hide fade">
    <div class="modal-header">
    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
    <h3>Download</h3>
    </div>
    <div class="wpdmpro modal-body" id='wpdm-modal-body'>
    
    </div>
    <div class="wpdmpro modal-footer">
    <a href="#" data-dismiss="modal" class="btn">Close</a>     
    </div>
    </div>   
    <script language="JavaScript">
    <!--
      jQuery(function(){           
          jQuery('#wpdm-popup-link').modal('hide');
          jQuery('.popup-link').click(function(e){     
              e.preventDefault();                    
              jQuery('#wpdm-modal-body').html('<i class="icon"><img align="left" style="margin-top: -1px" src="<?php echo plugins_url('/download-manager/images/loading-new.gif'); ?>" /></i>&nbsp;Please Wait...');
              jQuery('#wpdm-popup-link').modal('show');
              jQuery('#wpdm-modal-body').load(this.href);               
          });
      });
    //-->
    </script> 
    <style type="text/css">
    #wpdm-modal-body img{
        max-width: 100% !important;
    }
    </style>
    <?php
}

//import csv to mysql    

function wpdm_import_category_csv_file() {
    global $wpdb;
    if($_GET['task']!='wpdm-import-category-csv') return;
    $max_line_length = 10000;
    $source_file = $_FILES['csv']['tmp_name'];    
    if (($handle = fopen("$source_file", "r")) !== FALSE) {
        $columns = fgetcsv($handle, $max_line_length, ",");
        foreach ($columns as &$column) {
            $column = str_replace(".","",$column);
        }
         
        while (($data = fgetcsv($handle, $max_line_length, ",")) !== FALSE) {
            while (count($data)<count($columns))
                array_push($data, NULL);
            //$query = "$insert_query_prefix (".join(",",quote_all_array($data)).");";            
            $values = quote_all_array($data);             
            $drow = array_combine($columns, $values);             
            $category_id = $drow['category_id'];
            unset($drow['category_id']);
            $drow['access'] = serialize(explode(",", $drow['access']));
            $cats[$category_id] = $drow;
        }
        fclose($handle);
    }                     
     
    $categories = maybe_unserialize(get_option("_fm_categories"));
    $categories = array_merge($categories, $cats);    
    update_option("_fm_categories",$categories);
    @unlink($source_file);    
    header("location: admin.php?page=file-manager/categories");
    die();
}

         
function wpdm_import_csv_file() {
    global $wpdb;
    if($_GET['task']!='wpdm-import-csv') return;
    $max_line_length = 10000;
    $source_file = $_FILES['csv']['tmp_name'];    
    if (($handle = fopen("$source_file", "r")) !== FALSE) {
        $columns = fgetcsv($handle, $max_line_length, ",");
        foreach ($columns as &$column) {
            $column = str_replace(".","",$column);
        }
        $target_table = $wpdb->prefix.'ahm_files';
        /*$flds = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}ahm_files");
        array_shift( $flds );
        $fileinf = array();        
        foreach($flds as $fld){
        $def = strpos($fld->Type,"nt(")?0:'';
        $fileinf[$fld->Field] = $_POST[$fld->Field]?$_POST[$fld->Field]:$def;
        }*/
        $insert_query_prefix = "INSERT INTO $target_table (".join(",",$columns).")\nVALUES";
        while (($data = fgetcsv($handle, $max_line_length, ",")) !== FALSE) {
            while (count($data)<count($columns))
                array_push($data, NULL);
            //$query = "$insert_query_prefix (".join(",",quote_all_array($data)).");";
            $values = quote_all_array($data);             
            $drow = array_combine($columns, $values);
            $drow['files'] = serialize(explode(',',$drow['files']));
            $drow['category'] = serialize(explode(',',$drow['category']));
            $drow['create_date'] = isset($drow['create_date'])?strtotime($drow['create_date']):time();
            $drow['update_date'] = isset($drow['update_date'])?strtotime($drow['update_date']):time();
            $drow['access'] = isset($drow['access'])?serialize($drow['access']):serialize(array('guest'));
            $id = $wpdb->insert($target_table, $drow);                        
            do_action('after_add_package',$id, $drow);        
        }
        fclose($handle);
    }
    @unlink($source_file);
    header("location: admin.php?page=file-manager");
    die();
}

function quote_all_array($values) {
    foreach ($values as $key=>$value)
        if (is_array($value))
            $values[$key] = quote_all_array($value);
        else
            $values[$key] = quote_all($value);
    return $values;
}

function quote_all($value) {
    if (is_null($value))
        return "NULL";

    $value =  mysql_real_escape_string($value) ;
    return $value;
} 


 