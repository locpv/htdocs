 <style>

input[type=text],textarea{
    width:500px;
    padding:5px;
}

input{
   padding: 7px; 
}
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
select{
    min-width: 150px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/download-manager/css/tabs.css" />
<script type="text/javascript" src="<?php echo plugins_url();?>/download-manager/js/jquery.form.js"></script>
<link rel="stylesheet" href="<?php echo plugins_url('/download-manager/css/chosen.css'); ?>" />
<script language="JavaScript" src="<?php echo plugins_url('/download-manager/js/chosen.jquery.min.js'); ?>"></script> 

<div class="wrap">
<header>
<div class="icon32" id="icon-settings"><br></div>
<h2>Download Manager Settings <img style="display: none;" id="wdms_loading" src="images/loading.gif" /></h2>    
</header>
<nav> 
    <ul id="tabs">
        <?php render_settings_tabs($tab=$_GET['tab']?$_GET['tab']:'basic'); ?>
    </ul>
</nav>
<!--[if IE]>
<style>
ul#navigation { 
border-bottom: 1px solid #999999;
}
</style>
<![endif]-->
<div style="clear: both;"></div>
<div style="padding: 15px;">
<div onclick="jQuery(this).slideUp();" style="padding: 0px 10px;font-size:9pt;display:none;background: #FFF2C9;color:#000;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;border:1px solid #A57D06" id="message"></div>
<form method="post" id="wdm_settings_form">
<input type="hidden" name="task" id="task" value="wdm_save_settings" />
<input type="hidden" name="action" id="action" value="wdm_settings" />
<input type="hidden" name="section" id="section" value="basic" />
<div id="fm_settings">
<?php include('settings/basic.php'); ?>
</div> <br>
<br>

<input type="reset" value="Reset" class="button button-secondary button-large">
<input type="submit" value="Save Settings" class="button button-primary button-large">   
<img style="display: none;" id="wdms_saving" src="images/loading.gif" />
</form>
<br>
 
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('select').chosen();
    jQuery("ul#tabs li a").click(function() {
        jQuery("ul#tabs li").removeClass("selected");
        jQuery('#wdms_loading').fadeIn();
        jQuery(this).parents().addClass("selected");
        var section = this.id;
        jQuery.post(ajaxurl,{action:'wdm_settings',section:this.id},function(res){
            jQuery('#fm_settings').html(res);
            jQuery('#section').val(section)
            jQuery('#wdms_loading').fadeOut();            
            jQuery('select').chosen();
            window.history.pushState({"html":res,"pageTitle":"response.pageTitle"},"", "admin.php?page=file-manager/settings&tab="+section);
        });
        return false;
    });
    
    window.onpopstate = function(e){
    if(e.state){
        jQuery("#fm_settings").html(e.state.html);
        //document.title = e.state.pageTitle;
    }
    };
    
    <?php if($_GET[tab]!=''){ ?>
        jQuery("ul#navigation li").removeClass("selected");
        jQuery('#wdms_loading').fadeIn();
        jQuery('#<?php echo $_GET['tab']; ?>').parents().addClass("selected");
        var section = '<?php echo $_GET['tab'];?>';
        jQuery.post(ajaxurl,{action:'wdm_settings',section:section},function(res){
            jQuery('#fm_settings').html(res);
            jQuery('#section').val(section)
            jQuery('#wdms_loading').fadeOut();
        });
    <?php } ?>
    
    jQuery('#wdm_settings_form').submit(function(){
       
       jQuery(this).ajaxSubmit({
        url:ajaxurl,
        beforeSubmit: function(formData, jqForm, options){
          jQuery('#wdms_saving').fadeIn();  
        },   
        success: function(responseText, statusText, xhr, $form){
          jQuery('#message').html("<p>"+responseText+"</p>").slideDown();
          //setTimeout("jQuery('#message').slideUp()",4000);
          jQuery('#wdms_saving').fadeOut();  
          jQuery('#wdms_loading').fadeOut();  
        }   
       });
        
       return false; 
    });
    
   
});
 
</script>

