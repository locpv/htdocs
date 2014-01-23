
 
<div class="wpdm-front"><br>
<form id="wpdm-pf" action="" method="post">
 
<input type="hidden" id="act" name="act" value="<?php echo $_GET['task']=='edit-package'?'_ep_wpdm':'_ap_wpdm'; ?>" />

<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
<div  style="width: 100%;">
    
<table cellpadding="5" cellspacing="5" width="100%" style="border: 0px;">
<tr>
 
<td>
 
<input id="title" onchange="jQuery('#terr').remove();" style="font-size:16pt;width:99%;line-height: 30px;height: 30px" onkeyup="jQuery('#urlkey').val(this.value.replace(/[\s|\#|\.]+/g,'-').toLowerCase());jQuery('#urlkey_v').html(jQuery('#urlkey').val())" placeholder="Enter title here" type="text" value="<?php echo $file['title']; ?>" name="file[title]" /><br/>
<div style="float: left;font-style:italic;line-height: 25px">Custom package url: <?php if(get_option('permalink_structure')!=''){ ?><span style="cursor: pointer" onclick="jQuery('#ked').show();jQuery('#urlkey_v').hide();"><?php echo home_url('/'.get_option('__wpdm_purl_base','download').'/'); ;?></span><span id="urlkey_v" style="color: #0000dd;cursor: pointer" onclick="jQuery('#ked').show();jQuery(this).hide();"><?php echo get_wpdm_meta($file[id],'url_key'); ?></span><?php } else { ?><a target="_blank" href='<?php echo admin_url('options-permalink.php'); ?>'>Enable permalink structure</a><?php } ?></div>
<div id='ked' style="float: left;display: none"><input style="padding-left: 0px;font-style:italic;" type="text" name="url_key" size="60" value="<?php echo get_wpdm_meta($file[id],'url_key'); ?>" id="urlkey" ><input type="button" class="button-secondary" value="Ok" onclick="jQuery('#ked').hide();jQuery('#urlkey_v').html(jQuery('#urlkey').val()).show(); if(jQuery('#urlkey').val()=='') {jQuery('#urlkey').val(jQuery('#title').val().replace(/[\s|\#|\.]+/g,'-').toLowerCase()); jQuery('#urlkey_v').html(jQuery('#urlkey').val());}"></div>
<a base="<?php echo home_url('/'.get_option('__wpdm_purl_base','download').'/');  ?>" href="<?php echo home_url('/'.get_option('__wpdm_purl_base','download').'/'.get_wpdm_meta($file['id'],'url_key'));  ?>/" target="_blank" class="label label-important" id="wview" style="font-weight:200;margin-left: 15px;font-style: italic;"><i class="icon-white icon-eye-open"></i> View Package</a>
</td>
</tr>

<tr>
<td valign="top"> 
<div id="poststuff" class="postarea">
<?php wp_editor(stripslashes($file['description']),'file[description]','title', true, true); ?>                
</div>
 
</td>
</tr>

 
<tr>
<td> &nbsp;<br/>
 
<div  style="width: 100%;float: left;"> 
<div class="postbox " id="file_settings">
<h3 class="hndle"><span>Package Settings</span></h3>
<div class="inside">
<table cellpadding="5" id="file_settings_table" cellspacing="0" width="100%" class="frm">
<tr id="link_label_row">    
<td width="90px">Link Label:</td>
<td><input size="10" type="text" style="width: 200px" value="<?php echo $file[link_label]?$file[link_label]:'Download'; ?>" name="file[link_label]" />
</td></tr>

<tr id="stock_limit_row">
<td>Stock&nbsp;Limit:</td>  
<td><input size="10" style="width: 80px" type="text" name="file[quota]" value="<?php echo $file[quota]; ?>" /></td>
</tr>
 
<tr id="download_limit_row">
<td>Download&nbsp;Limit:</td>  
<td><input size="10" style="width: 80px" type="text" name="wpdm_download_limit_per_user" value="<?php echo get_wpdm_meta($file['id'],'wpdm_download_limit_per_user'); ?>" /> / user <span class="info infoicon" title="For non-registered members IP will be taken as ID">&nbsp;</span></td>
</tr>
<tr id="download_count_row">
<td>Download&nbsp;Count:</td>  
<td><input size="10" style="width: 80px" type="text" name="file[download_count]" value="<?php echo $file['download_count']; ?>" /> <span class="info infoicon" title="Set/Reset Download Count for this package">&nbsp;</span></td>
</tr>
 
<tr id="access_row">
<td valign="top">Access:</td>
<td>   
    <ul>
	<?php
	
	$currentAccess = unserialize( $file['access'] );
	if(  $currentAccess ) $selz = (in_array('guest',$currentAccess))?'checked':'';
	?>
	
    <li><label><input class="role" type="checkbox"  name="file[access][]" value="guest" <?php echo $selz  ?>> All Visitors</option></label></li>
    <?php
    global $wp_roles;
    $roles = array_reverse($wp_roles->role_names);
    foreach( $roles as $role => $name ) { 
	
	
	
	if(  $currentAccess ) $sel = (in_array($role,$currentAccess))?'checked':'';
	
	
	
	?>
    <li><label><input type="checkbox" class="role"  name="file[access][]" value="<?php echo $role; ?>" <?php echo $sel  ?>> <?php echo $name; ?></label></li>
    <?php } ?>
    </ul>
</td></tr>

  

<tr id="templates_row">
<td><?php echo __('Link Template:','wpdmpro'); ?></td>
<td><?php

 

?>
<select name="file[template]" id="lnk_tpl" onchange="jQuery('#lerr').remove();"> 
<?php
$ctpls = scandir(WPDM_BASE_DIR.'/templates/');
                  array_shift($ctpls);
                  array_shift($ctpls);
                  $ptpls = $ctpls;
                  foreach($ctpls as $ctpl){
                      $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                      if(preg_match("/WPDM[\s]+Link[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){                                 
    
?>
<option value="<?php echo $ctpl; ?>"  <?php echo $file['link_template']==$ctpl?'selected=selected':''; ?>><?php echo $matches[1]; ?></option>
<?php    
}  
} 
if($templates = unserialize(get_option("_fm_link_templates",true))){ 
  foreach($templates as $id=>$template) {  
?>
<option value="<?php echo $id; ?>"  <?php echo ( $file['template']==$id )?' selected ':'';  ?>><?php echo $template['title']; ?></option>
<?php } } ?>
</select> 
</td>
</tr>


<tr id="templates_row">
<td><?php echo __('Page Template:','wpdmpro'); ?></td>
<td><?php
  
//print_r(  unserialize(get_option("_fm_link_templates",true)) );
?>
<select name="file[page_template]" id="pge_tpl" onchange="jQuery('#perr').remove();"> 
<?php
                   
                  
                      foreach($ptpls as $ctpl){
                      $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                      if(preg_match("/WPDM[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){       
    
?>
<option value="<?php echo $ctpl; ?>"  <?php echo $file['link_template']==$ctpl?'selected=selected':''; ?>><?php echo $matches[1]; ?></option>
<?php    
}  
} 

if($templates = unserialize(get_option("_fm_page_templates",true))){ 
  foreach($templates as $id=>$template) {  
?>
<option value="<?php echo $id; ?>"  <?php echo ( $file['page_template']==$id )?' selected=selected ':'';  ?>><?php echo $template['title']; ?></option>
<?php } } ?>
</select>
 </td>
</tr>
</table>
<div class="clear"></div>
</div>
</div>


<div class="postbox " id="categories_meta_box">
<h3 class="hndle"><span>Package Lock Settings</span><span class="info infoicon" title="This section will allow you to lock your download link using password, facebook like or google +1">(?)</span></h3>
<div class="inside">
You can use one or more of following methods to lock your package download:
<table class="table">
<thead>
<tr><th><input type="checkbox" class="wpdmlock" rel='password' name="wpdm_meta[password_lock]" <?php if(get_wpdm_meta($file['id'],'password_lock')=='1') echo "checked=checked"; ?> value="1"> Enable Password Lock</th></tr>
</thead>
<tr><td>
<table id="password" class="fwpdmlock" width="100%"  cellpadding="0" cellspacing="0" <?php if(get_wpdm_meta($file['id'],'password_lock')!='1') echo "style='display:none'"; ?> >
<tr id="password_row">
<td>Password:</td>  
<td><input size="10" style="width: 200px" type="text" name="file[password]" value="<?php echo $file[password]; ?>" /><span class="info infoicon" title="You can use single or multiple password<br/>for a package. If you are using multiple password then<br/>separate each password by []. example [password1][password2]">(?)</span></td>
</tr>
<tr id="password_usage_row">
<td>PW Usage Limit:</td>  
<td><input size="10" style="width: 80px" type="text" name="wpdm_meta[password_usage_limit]" value="<?php echo get_wpdm_meta($file['id'],'password_usage_limit', true); ?>" /> / password <span class="info infoicon" title="Password will expire after it exceed this usage limit">(?)</span></td>
</tr>
</table>
</td></tr>
<thead>
<tr><th><input type="checkbox" rel="gplusone" class="wpdmlock" name="wpdm_meta[gplusone_lock]" <?php if(get_wpdm_meta($file['id'],'gplusone_lock')=='1') echo "checked=checked"; ?> value="1"> Enable Google +1 Lock</th></tr>
</thead>
<tr><td>
<table id="gplusone" class="frm fwpdmlock" width="100%"  cellpadding="0" cellspacing="0" <?php if(get_wpdm_meta($file['id'],'gplusone_lock')!='1') echo "style='display:none'"; ?> >
<tr>
<td width="90px">URL for +1:</td>  
<td><input size="10" style="width: 200px" type="text" name="wpdm_meta[google_plus_1]" value="<?php echo get_wpdm_meta($file['id'],'google_plus_1') ?>" /></td>
</tr>
</table>
</td></tr>
<thead>
<tr><th><input type="checkbox" rel="facebooklike" class="wpdmlock" name="wpdm_meta[facebooklike_lock]" <?php if(get_wpdm_meta($file['id'],'facebooklike_lock')=='1') echo "checked=checked"; ?> value="1"> Enable Facebook Like Lock</th></tr>
</thead>
<tr><td>
<table id="facebooklike" class="frm fwpdmlock" width="100%" cellpadding="0" cellspacing="0" <?php if(get_wpdm_meta($file['id'],'facebooklike_lock')!=1) echo "style='display:none;width:100%'"; ?> >
<tr>
<td width="90px">URL to Like:</td>  
<td><input size="10" style="width: 200px" type="text" name="wpdm_meta[facebook_like]" value="<?php echo get_wpdm_meta($file['id'],'facebook_like') ?>" /></td>
</tr>
</table>
</td></tr>
<thead>
<tr><th><input type="checkbox" rel="email" class="wpdmlock" name="wpdm_meta[email_lock]" <?php if(get_wpdm_meta($file['id'],'email_lock')=='1') echo "checked=checked"; ?> value="1"> Enable Email Lock </th></tr>
</thead>
<tr><td>
<table id="email" class="frm fwpdmlock"  cellpadding="0" cellspacing="0" <?php if(get_wpdm_meta($file['id'],'email_lock')!='1') echo "style='display:none'"; ?>>
<tr><td>
Will ask for email before download
</td></tr>
</table>
</td></tr>
</table>

<div class="clear"></div>
</div>
</div>


<?php do_action("add_new_file_body_left"); ?>
</div> 

<div  style="width: 100%;float: right;height: inherit;">
<div class="postbox " id="categories_meta_box">
<h3 class="hndle"><span>Version & Dates</span></h3>
<div class="inside">
<table class="frm" width="100%">
<tr><td width="180">Current Package Version:</td><td><input type="text" size="20" name="wpdm_meta[version]" value="<?php echo get_wpdm_meta($file['id'],'version'); ?>" /></td></tr>
<tr><td>Create Date:</td><td><input id="pdate" type="text" size="20" name="wpdm_meta[create_date]" value="<?php $cd = get_wpdm_meta($file['id'],'create_date'); $cd=$cd?$cd:time(); echo date("Y-m-d",$cd); ?>" /><span class="info infoicon" title="Date format yyyy-mm-dd , If you keep empty, system will set current date">(?)</span></td></tr>
<tr><td>Update Date:</td><td><input id="udate" type="text" size="20" name="wpdm_meta[update_date]" value="<?php $ud = get_wpdm_meta($file['id'],'update_date'); $ud=$ud?$ud:time(); echo date("Y-m-d",$ud); ?>" /><span class="info infoicon" title="Date format yyyy-mm-dd , If you keep empty, system will set current date">(?)</span></td></tr>
</table>

<div class="clear"></div>
</div>
</div>

 
<div class="postbox " id="categories_meta_box">
<h3 class="hndle"><span>Remote File URL</span><span class="info infoicon" title="Here you can use a file url for your download package<br/>like, http://www.domain.com/myfiles.zip<br/><b>If you use this option uploaded files for same package will be skipped.</b>">(?)</span></h3>
<div class="inside">
Use Direct Link to download file
<input type="text" style="width: 98%" name="file[sourceurl]" value="<?php echo $file[sourceurl]; ?>" />                    <br />
<label for="url_protect">Enable url protection <input type="checkbox" <?php echo get_wpdm_meta($file[id],'url_protect')?'checked=checked':''; ?> value="1" name="wpdm_url_protect" id="url_protect"></label> <span class="info infoicon" title="If checked users will not know the actual download url.<br/><b>Important! </b>enabling this option may occur memory overflow error if you server cache memory size is not larger then file size">(?)</span>
<div class="clear"></div>
</div>
</div>

<div class="postbox " id="categories_meta_box">
<h3 class="hndle"><span>Categories</span></h3>
<div class="inside">
<ul>
<?php
 $currentAccesss = maybe_unserialize( $file['category'] );
 if(!is_array($currentAccesss)) $currentAccesss = array();
 wpdm_cblist_categories('',0,$currentAccesss);   
?>
</ul> 

<div class="clear"></div>
</div>
</div>  

<?php do_action("add_new_file_body_right"); ?>
</div> 

 
</td>
</tr>
 
</table>
</div>
<div style="width:100%">

<div class="postbox " id="upload_meta_box">
<h3 class="hndle"><?php echo __('Attached Files','wpdmpro'); ?></h3>
<div class="inside">
<div id="currentfiles">

<?php

$files = unserialize( $file['files']  );

if( empty($files)  ) $files = array();
 
?>

<table class="table">
<thead>
<tr>
<th style="width: 50px;">Action</th>
<th>Filename</th>
<th>Title</th>
<th style="width: 130px;">Password</th>
</tr>
</thead>
<?php $fileinfo = get_wpdm_meta($file['id'],'fileinfo');  foreach($files as $value): ++$file_index; if(!is_array($fileinfo[$value])) $fileinfo[$value] = array();  ?>
<tr  class="cfile">
<td>
<input class="fa" type="hidden" value="<?php echo $value; ?>" name="files[]">
<img align="left" rel="del" src="<?php echo plugins_url('download-manager/images/minus.png'); ?>">
</td>
<td><?php echo $value; ?></td>
<td><input style="width:99%" type="text" name='wpdm_meta[fileinfo][<?php echo $value; ?>][title]' value="<?php echo $fileinfo[$value]['title'];?>"></td>
<td><input size="10" type="text" id="indpass_<?php echo $file_index;?>" name='wpdm_meta[fileinfo][<?php echo $value; ?>][password]' value="<?php echo $fileinfo[$value]['password'];?>"></td>
</tr>
<?php
endforeach;
?>
</table>


<?php if($files):  ?>
<script type="text/javascript">


jQuery('img[rel=del], img[rel=undo]').click(function(){

     if(jQuery(this).attr('rel')=='del')
     {
     
     jQuery(this).parents('tr.cfile').removeClass('cfile').addClass('dfile').find('input.fa').attr('name','del[]');
     jQuery(this).attr('rel','undo').attr('src','<?php echo plugins_url(); ?>/download-manager/images/add.png').attr('title','Undo Delete');
     
     } else {
     
     
            jQuery(this).parents('tr.dfile').removeClass('dfile').addClass('cfile').find('input.fa').attr('name','files[]');
            jQuery(this).attr('rel','del').attr('src','<?php echo plugins_url(); ?>/download-manager/images/minus.png').attr('title','Delete File');

     
     
     }



});


</script>


<?php endif; ?>



</div>
</div>
</div>
<div class="postbox " id="upload_meta_box">
<h3 class="hndle"><?php echo __('Upload file(s) from PC','wpdmpro'); ?></h3>
<div class="inside">
  

<div id="plupload-upload-ui" class="hide-if-no-js">
     <div id="drag-drop-area">
       <div class="drag-drop-inside">
        <p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
        <p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
        <p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="btn btn-inverse" /></p>
      </div>
     </div>
  </div>

  <?php

  $plupload_init = array(
    'runtimes'            => 'html5,silverlight,flash,html4',
    'browse_button'       => 'plupload-browse-button',
    'container'           => 'plupload-upload-ui',
    'drop_element'        => 'drag-drop-area',
    'file_data_name'      => 'async-upload',            
    'multiple_queues'     => true,
   /* 'max_file_size'       => wp_max_upload_size().'b',*/
    'url'                 => admin_url('admin-ajax.php'),
    'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
    'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
    'filters'             => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
    'multipart'           => true,
    'urlstream_upload'    => true,

    // additional post data to send to our ajax hook
    'multipart_params'    => array(
      '_ajax_nonce' => wp_create_nonce('photo-upload'),
      'action'      => 'photo_gallery_upload',            // the ajax action name
    ),
  );

  // we should probably not apply this filter, plugins may expect wp's media uploader...
  $plupload_init = apply_filters('plupload_init', $plupload_init); ?>

  <script type="text/javascript">

    jQuery(document).ready(function($){

      // create the uploader and pass the config from above
      var uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);

      // checks if browser supports drag and drop upload, makes some css adjustments if necessary
      uploader.bind('Init', function(up){
        var uploaddiv = jQuery('#plupload-upload-ui');

        if(up.features.dragdrop){
          uploaddiv.addClass('drag-drop');
            jQuery('#drag-drop-area')
              .bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
              .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });

        }else{
          uploaddiv.removeClass('drag-drop');
          jQuery('#drag-drop-area').unbind('.wp-uploader');
        }
      });

      uploader.init();

      // a file was added in the queue
      uploader.bind('FilesAdded', function(up, files){
        //var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
        
           

        plupload.each(files, function(file){
          jQuery('#filelist').append(
                        '<div class="file" id="' + file.id + '"><b>' +
 
                        file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' +
                        '<div class="fileprogress"></div></div>');
        });

        up.refresh();
        up.start();
      });
      
      uploader.bind('UploadProgress', function(up, file) {
                      
                jQuery('#' + file.id + " .fileprogress").width(file.percent + "%");
                jQuery('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
            });
 

      // a file was uploaded 
      uploader.bind('FileUploaded', function(up, file, response) {

        // this is your ajax response, update the DOM with it or something...
        //console.log(response);
        //response
        jQuery('#' + file.id ).remove();
        var d = new Date();
        var ID = d.getTime();
        response = response.response;
        var nm = response;
                            if(response.length>20) nm = response.substring(0,7)+'...'+response.substring(response.length-10);
                            jQuery('#currentfiles table.table').append("<tr id='"+ID+"' class='cfile'><td><input type='hidden' id='in_"+ID+"' name='files[]' value='"+response+"' /><img id='del_"+ID+"' src='<?php echo plugins_url(); ?>/download-manager/images/minus.png' rel='del' align=left /></td><td>"+response+"</td><td width='40%'><input style='width:99%' type='text' name='wpdm_meta[fileinfo]["+response+"][title]' value='"+response+"' onclick='this.select()'></td><td><input size='10' type='text' id='indpass_"+ID+"' name='wpdm_meta[fileinfo]["+response+"][password]' value=''> </td></tr>");
                            jQuery('#'+ID).fadeIn();
                            jQuery('#del_'+ID).click(function(){
                                if(jQuery(this).attr('rel')=='del'){
                                jQuery('#'+ID).removeClass('cfile').addClass('dfile');
                                jQuery('#in_'+ID).attr('name','del[]');
                                jQuery(this).attr('rel','undo').attr('src','<?php echo plugins_url(); ?>/download-manager/images/add.png').attr('title','Undo Delete');
                                } else if(jQuery(this).attr('rel')=='undo'){
                                jQuery('#'+ID).removeClass('dfile').addClass('cfile');
                                jQuery('#in_'+ID).attr('name','files[]');
                                jQuery(this).attr('rel','del').attr('src','<?php echo plugins_url(); ?>/download-manager/images/minus.png').attr('title','Delete File');
                                }
                                
                                
                            });
                           

      });

    });   

  </script>
  <div id="filelist"></div>

 <div class="clear"></div>
</div>
</div>
 
<?php    
$path = dirname(__FILE__)."/file-type-icons/";
$scan = scandir( $path );
$k = 0;
foreach( $scan as $v )
{
if( $v=='.' or $v=='..' or is_dir($path.$v) ) continue;

$fileinfo[$k]['file'] = 'download-manager/file-type-icons/'.$v;
$fileinfo[$k]['name'] = $v;
$k++;
}


if( !empty($fileinfo) )
{
          
 include dirname(__FILE__).'/file-icon.php';

} else {

?>
<div class="updated" style="padding: 5px;">
    upload your icons on '/wp-content/plugins/download-manager/file-type-icons/' using ftp</div>

<?php } ?>





 <div class="clear"></div>
 
 

 



<div class="postbox " id="action">
<h3 class="hndle"><span>Preview image <a onclick="return false;" id="upload-main-preview" class="thickbox" style="float: right" href="#"><img src='<?php echo plugins_url('/download-manager/images/add-image.gif'); ?>' /></a></span></h3>
<div class="inside">
<div id="img"><?php if(!empty($file['preview'])): ?>
<p><img src="<?php  echo plugins_url().'/download-manager/timthumb.php?w=200&h=150&zc=1&src='.$file['preview'] ?>" width="240" alt="preview" /></p>
<input type="hidden" name="file[preview]" value="<?php echo $file['preview']; ?>" >
<?php endif; ?>
</div>
<!-- <input type="file" name="preview" /> -->
 <div class="clear"></div>
</div>
</div>
 

<?php do_action("add_new_file_sidebar"); ?> 










<div class="postbox " id="action">
<h3 class="hndle"><span>Actions</span></h3>
<div class="inside">



 <button type="button" value="Back" tabindex="9" class="btn btn-inverse  backbtn" onclick="location.href='<?php the_permalink(); ?>'"  name="addmeta" id="addmetasub">Back</button>

<button  type="reset" tabindex="9" class="btn btn-info" name="addmeta" id="addmetasub">Reset</button>

<button type="submit" accesskey="p" tabindex="5" id="publish" class="btn btn-primary" name="publish"><?php echo $_GET['task']=='EditPackage'?'Update Package':'Create Package'; ?></button>
<img src="images/wpspin_light.gif" id="sving" style="position: absolute;margin: 5px 0 0 5px;display: none;"/>
 <div class="clear"></div><br/>
 <div id="serr" style="display: none;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;border:1px solid #800000;background: #FFEDED;color: #000;font-family:'Courier New';padding:5px 10px;text-align: left;">
 </div>
 <div id="nxt" style="display: none;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;border:1px solid #008000;background: #F9FFEA;color: #000;font-family:'Courier New';padding:5px 10px;text-align: center;">
 Package Data Saved Successfully, Now: <br/>
 <a href="?">Manage Packages</a> | <a href="?task=addnew">Add New</a> | <a href='#' onclick="jQuery('#nxt').slideUp();return false;">Hide this message</a>
 </div>
 <div class="clear"></div>
</div>
</div>

</div>
 
</form>

</div>

 
       
      <script type="text/javascript">
      
      jQuery(document).ready(function() {
          
        jQuery('span.infoicon').addClass('icon icon-question-sign').css({color:'transparent',width:'16px',height:'16px',cursor:'pointer'}).tooltip({placement:'right',html:true});
        jQuery('span.infoicon').tooltip({placement:'right'});
        jQuery('.nopro').click(function(){
            if(this.checked) jQuery('.wpdmlock').removeAttr('checked');
        });
        
        jQuery('.wpdmlock').click(function(){      
         
            if(this.checked) {   
            jQuery('#'+jQuery(this).attr('rel')).slideDown();
            jQuery('.nopro').removeAttr('checked');
            } else {
            jQuery('#'+jQuery(this).attr('rel')).slideUp();    
            }
        });
          
        jQuery( "#pdate" ).datepicker({dateFormat:'yy-mm-dd'});
        jQuery( "#udate" ).datepicker({dateFormat:'yy-mm-dd'});
        
        jQuery('#wpdm-pf').submit(function(){
            jQuery('#serr').hide();
            jQuery('#nxt').hide();
             var error = "";
             if(jQuery('#title').val()=='') { error += '<li id="terr">Must Enter a Package Title</li>'; }
             if(jQuery('#lnk_tpl').val()=='') { error += '<li id="lerr">Must Select a Link Template</li>'; }
             if(jQuery('#pge_tpl').val()=='') { error += '<li id="perr">Must Select a Page Template</li>'; }
             
             if(error!=''){
                 jQuery('#serr').html("<b>Submission Errors:</b><br/><ul>"+error+"</ul>").slideDown();
                 return false;
             }
             
             jQuery('#wpdm-pf').ajaxSubmit({               
                 //dataType: 'json',
                 beforeSubmit: function() { jQuery('#sving').fadeIn(); },
                 success: function(res) {  jQuery('#sving').fadeOut(); jQuery('#nxt').slideDown();                                        
                    jQuery('#wview').attr('href','<?php echo home_url('/'.get_option('__wpdm_purl_base','download').'/'.get_wpdm_meta($file['id'],'url_key'));  ?>/'+jQuery('#urlkey').val());
                    if(res.id!=undefined){
                    jQuery('#wpdm-pf').attr('action','?task=edit-package&id='+res.id); jQuery('#act').val('_ep_wpdm'); jQuery('#id').val(res.id);                       
                    }
                 }
                 
                 
             });
             return false;
        });
  
        
        
       
      });
      
      jQuery('#upload-main-preview').click(function() {           
            tb_show('', '<?php echo admin_url('media-upload.php?type=image&TB_iframe=1&width=640&height=551'); ?>');
            window.send_to_editor = function(html) {           
              var imgurl = jQuery('img',"<p>"+html+"</p>").attr('src');                     
              jQuery('#img').html("<img src='"+imgurl+"' style='max-width:100%'/><input type='hidden' name='file[preview]' value='"+imgurl+"' >");
              tb_remove();
              }
            return false;
        });

     
      
     <?php if(!get_option('prev-img',0)){ ?>
        jQuery(function() {
            var options = {"content":"<h3>Quick Note!<\/h3><p>Click on <img src='<?php echo plugins_url('/download-manager/images/add-image.gif'); ?>' />  icon to lauch wordpress media manager popup. From where you can upload and select preview images<\/p>","position":{"edge":"right","align":"top"}};

            if ( ! options )
                return;

            options = $.extend( options, {
                close: function() {
                    $.post( ajaxurl, {
                        pointer: 'prev-img',
                        action: 'dismiss-wpdm-pointer'
                    }); 
                }
            });

            jQuery('#add-prev-img img').pointer( options ).pointer('open');
            
           
        
        
        });
        
<?php } ?>
  
  <?php if(get_wpdm_meta($file['id'],'lock',true)!='') { ?>   
     jQuery('#<?php echo get_wpdm_meta($file['id'],'lock',true); ?>').show();
  <?php } ?>
      </script>
      
      <?php
 
?>
 