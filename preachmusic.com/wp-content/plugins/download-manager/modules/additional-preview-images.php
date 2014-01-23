<?php
function wpdm_additional_preview_images(){             
   
?>
 
<div class="postbox " id="categories_meta_box">
<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Additional Previews <a id="add-prev-img" href="#"><img align="right" src="<?php echo plugins_url('/download-manager/images/add-image.gif'); ?>" /></a></span></h3>
<div class="inside">
<div id="adpcon">
<?php
    $mpvs = get_wpdm_meta($_GET[id],'more_previews');         
    
    if(is_array($mpvs)){
       
        foreach($mpvs as $mpv){
         
            ?>
             <div id='<?php echo ++$mmv; ?>' style='float:left;padding:5px;' class='adp'>
             <input type='hidden'  id='in_<?php echo $mmv; ?>' name='adp[]' value='<?php echo $mpv; ?>' />
             <img style='position:absolute;z-index:9999;cursor:pointer;' id='del_<?php echo $mmv; ?>' rel="<?php echo $mmv; ?>" src='<?php echo plugins_url(); ?>/download-manager/images/minus.png' class="del_adp" align=left />
             <img src='<?php echo plugins_url(); ?>/download-manager/timthumb.php?w=50&h=50&zc=1&src=<?php echo $mpv; ?>'/>
             <div style='clear:both'></div>
             </div>
            <?php
        }
    }
?>
</div> 
 

<div class="clear"></div>
</div>
</div>
<script type="text/javascript">
      
      jQuery(document).ready(function() {
  
          jQuery('#add-prev-img').click(function() {            
            tb_show('', '<?php echo admin_url('media-upload.php?type=image&TB_iframe=1&width=640&height=551'); ?>');
            window.send_to_editor = function(html) {           
              var imgurl = jQuery('img',"<p>"+html+"</p>").attr('src');                     
              //jQuery('#img').html("<img src='"+imgurl+"' style='max-width:100%'/><input type='hidden' name='file[preview]' value='"+imgurl+"' >");
                            var newDate = new Date;
                            var ID = newDate.getTime();
                            jQuery('#adpcon').append("<div id='"+ID+"' style='display:none;float:left;padding:5px;' class='adp'><input type='hidden' id='in_"+ID+"' name='adp[]' value='"+imgurl+"' /><nobr><b><img style='position:absolute;z-index:9999;cursor:pointer;' id='del_"+ID+"' src='<?php echo plugins_url(); ?>/download-manager/images/minus.png' rel='del' align=left /><img src='<?php echo plugins_url(); ?>/download-manager/timthumb.php?w=50&h-5-&zc=1&src="+imgurl+"'/></b></nobr><div style='clear:both'></div></div>");
                            jQuery('#'+ID).fadeIn();
                            jQuery('#del_'+ID).click(function(){
                                if(confirm('Are you sure?')){                                     
                                    jQuery('#'+ID).fadeOut().remove();
                                }
                                
                            });
                            
              tb_remove();
              }
            return false;
        });
     
       
                        
        jQuery('.del_adp').click(function(){
                                if(confirm('Are you sure?')){                                     
                                    jQuery('#'+jQuery(this).attr('rel')).fadeOut().remove();
                                }
                                
                            });
   
      });
  
      </script>
<?php    
}    


function wpdm_delete_preview(){    
    die();
}

function wpdm_update_additional_previews($id, $package){    
    update_wpdm_meta($id,'more_previews',$_POST['adp']);    
}

function wpdm_push_additional_preview_images($file){
    $file['additional_previews'] = get_wpdm_meta($file[id],'more_previews');         
    $img = '';
    if($file['additional_previews']){
    foreach($file['additional_previews'] as $p){
        ++$k;
        $img .= "<a href='{$p}' id='more_previews_a_{$k}' class='more_previews_a' ><img id='more_previews_{$k}' class='more_previews' src='".plugins_url().'/download-manager/timthumb.php?w='.get_option('_wpdm_athumb_w').'&h='.get_option('_wpdm_athumb_h').'&zc=1&src='.$p."'/></a>";
    }}
    $file['athumbs'] = $img;    
    return $file;
}

function wpdm_get_additional_preview_images($file, $w, $h){
    $file['additional_previews'] = get_wpdm_meta($file[id],'more_previews');         
    $img = '';
    if($file['additional_previews']){
    foreach($file['additional_previews'] as $p){
        ++$k;
        $img .= "<a href='{$p}' id='more_previews_a_{$k}' class='more_previews_a' ><img id='more_previews_{$k}' class='more_previews img-circle' src='".plugins_url().'/download-manager/timthumb.php?w='.$w.'&h='.$h.'&zc=1&src='.$p."'/></a>";
    }}
        
    return $img;
}

add_action("add_new_file_sidebar","wpdm_additional_preview_images");
add_filter("wdm_pre_render_page","wpdm_push_additional_preview_images");
add_filter("wdm_pre_render_link","wpdm_push_additional_preview_images");
add_action('after_add_package','wpdm_update_additional_previews',10,2);
add_action('after_update_package','wpdm_update_additional_previews',10,2);

?>