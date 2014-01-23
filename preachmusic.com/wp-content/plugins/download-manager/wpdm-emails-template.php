<?php

$etpl = get_option('_wpdm_etpl');

?>
<style type="text/css">
#wphead{
    border-bottom:0px;
}
#screen-meta-links{
    display: none;
}
.wrap{
    margin: 0px;
    padding: 0px;
}
#wpbody{
    margin-left: -19px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('download-manager/css/tabs.css'); ?>" />
<div class="wrap">
<header>
<div class="icon32"><img src='<?php echo plugins_url('download-manager/images/email.png'); ?>' /></div>
<h2><?php echo __('Emails','wpdmpro'); ?></h2>
</header>
<nav> 
    <ul id="tabs">    
    <li><a id="basic" href="admin.php?page=file-manager/emails"><?php echo __('Emails','wpdmpro'); ?></a></li>    
    <li class="selected"><a id="basic" href="admin.php?page=file-manager/emails&task=template"><?php echo __('Email Template','wpdmpro'); ?></a></li>        
    <li><a id="basic" href="admin.php?page=file-manager/emails&task=export"><?php echo __('Export CSV','wpdmpro'); ?></a></li>        
    <li><a id="basic" href="admin.php?page=file-manager/emails&task=export&uniq=1"><?php echo __('Export Unique Emails','wpdmpro'); ?></a></li>        
    </ul>
</nav>     

 


           
<form method="post" action="admin.php?page=file-manager/emails&task=template" id="posts-filter" style="padding: 20px;"> 
<input name="task" value="save-etpl" type="hidden" />
Subject:
<input style="width: 100%;font-size: 14pt;" type="text" value="<?php echo $etpl[subject] ?>" placeholder="Subject" name="et[subject]" /><br/><br/>
<b>Template:</b>
<div id="poststuff" class="postarea" contentEditable="true">
<?php echo htmlspecialchars_decode(stripslashes($etpl[body])); //,'et[body]','body', false, false); ?>                
</div>
<input type="hidden" name="et[body]" value="" id="mbd" />
<input type="hidden" value="0" id="rst" />
<br/>
<b>Variables:</b><br/>
<code>[download_url]</code> - Download URL<Br/>
<code>[title]</code> - Package Title<Br/>
<code>Double click on image to change it</code>
<br/>From Mail:
<input style="width: 100%;font-size: 14pt;" type="text" value="<?php echo $etpl[frommail] ?>" placeholder="From Mail" name="et[frommail]" /><br/><br/>
From Name:
<input style="width: 100%;font-size: 14pt;" type="text" value="<?php echo $etpl[fromname] ?>" placeholder="From Name" name="et[fromname]" /><br/><br/>

<input type="submit" class="button-primary" value="Save Template"  style="padding: 7px;margin-top: 10px;">
</form>
<br class="clear">

</div>

 <script language="JavaScript">
 <!--
   jQuery(function(){
       jQuery('#rst').val(0);
       jQuery('#posts-filter').submit(function(){
           if(jQuery('#rst').val()==1) return true;      
           jQuery('#mbd').val(jQuery('#poststuff').html());           
           jQuery('#rst').val(1);
           jQuery('#posts-filter').submit();  
           //if(jQuery('#rst').val()==0) return false;      
       });
       
       jQuery('#poststuff img').dblclick(function() {                            
                var ob = jQuery(this);
                tb_show('', '<?php echo admin_url('media-upload.php?type=image&TB_iframe=1&width=640&height=551'); ?>');
                window.send_to_editor = function(html) {           
                  var imgurl = jQuery('img',"<p>"+html+"</p>").attr('src');                     
                  jQuery(ob).attr("src",imgurl).css("max-width","100%").css("max-height","100%");
                  tb_remove();
                  }
                return false;
            });
 
       
   });
 //-->
 </script>