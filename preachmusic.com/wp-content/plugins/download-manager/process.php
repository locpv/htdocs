<?php
    
    do_action("before_download", $package);
    global $current_user, $dfiles;
    
    $speed = 1024; //in KB - default 1 MB
    $speed = apply_filters('wpdm_download_speed', $speed);
    
    get_currentuserinfo();
    if(wpdm_is_download_limit_exceed($package['id'])) die(__msg('DOWNLOAD_LIMIT_EXCEED'));    
    $files = unserialize($package['files']);        
    $dir = get_wpdm_meta($package['id'],'package_dir');
    if($dir!=''){   
    $dfiles = array();
    wpmp_get_files($dir);    
    }    
    $log = new Stats();
        
    $oid = isset($_GET['oid'])?addslashes($_GET['oid']):'';
    
    if(!isset($_GET['ind'])&&!isset($_GET['nostat']))
    $log->NewStat($package['id'], $current_user->ID,$oid);                     
    
    if(count($files)==0&&count($dfiles)==0) {
      if($package['sourceurl']!='') {
                
        if(get_wpdm_meta($package['id'],'url_protect')==0&&strpos($package['sourceurl'],'://')){
            header('location: '.$package['sourceurl']);
            die();
        }
        
        $r_filename = basename($package['sourceurl']);
        wpdm_download_file($package['sourceurl'],$r_filename, $speed, 1, $package);
        die();
      } 
    
       wpdm_download_data('download-not-available.txt','Sorry! Download is not available yet.');
       die();
    
    }
     
    $idvdl = get_wpdm_meta($package['id'],'individual_download')&&isset($_GET['ind'])?1:0;    
    
    if((count($files)>1||count($dfiles)>1)&&!$idvdl){
    $zip = new ZipArchive();
    $zipped = WPDM_CACHE_DIR.sanitize_file_name($package['title']).'-'.time().'-'.uniqid().'.zip';
    if ($zip->open($zipped, ZIPARCHIVE::CREATE) !== TRUE) {
       wpdm_download_data('cache-dir-not-writable.txt','Failed to create file. Please make "'.WPDM_CACHE_DIR.'" dir writable..');
       die();
    }        

    foreach($files as $file){   
        if(file_exists(UPLOAD_DIR.$file)) {
        $fnm = preg_replace("/[0-9]+?[wpdm]*_/","", $file);
        $zip->addFile(UPLOAD_DIR.$file, $fnm);
        }
        else if(file_exists($file)) 
        $zip->addFile($file,basename($file));
        else if(file_exists(WP_CONTENT_DIR.end($tmp = explode("wp-content",$file)))) //path fix on site move
        $zip->addFile(WP_CONTENT_DIR.end($tmp = explode("wp-content",$file)),basename(WP_CONTENT_DIR.end($tmp = explode("wp-content",$file))));
    }
    if($dfiles){
    foreach($dfiles as $file){           
        $zip->addFile($file,str_replace($dir,'',$file));
    }}
        
    $zip->close();
    wpdm_download_file($zipped, sanitize_file_name($package['title']).'.zip', $speed, 1, $package);
    @unlink($zipped);
    }
    else {    
    
    //Individual file or single file download section
    
    $ind = $_GET['ind']?$_GET['ind']:0;
    if(file_exists(UPLOAD_DIR.$files[$ind]))
    $filepath = UPLOAD_DIR.$files[$ind];
    else if(file_exists($files[$ind]))
    $filepath = $files[$ind];
    else if(file_exists(WP_CONTENT_DIR.end($tmp = explode("wp-content",$files[$ind])))) //path fix on site move
    $filepath = WP_CONTENT_DIR.end($tmp = explode("wp-content",$files[$ind]));
    else {
        wpdm_download_data('file-not-found.txt','File not found or deleted from server');
        die();        
    }
    
    //$plock = get_wpdm_meta($file['id'],'password_lock',true);
    //$fileinfo = get_wpdm_meta($package['id'],'fileinfo');
     
    $filename = basename($filepath);
    $filename = preg_replace("/([0-9]+)[wpdm]*_/","",$filename);
    
    wpdm_download_file($filepath, $filename, $buffer, $speed, 1, $package);    
    //@unlink($filepath);

}     
do_action("after_downlaod", $package); 
die();
?>
