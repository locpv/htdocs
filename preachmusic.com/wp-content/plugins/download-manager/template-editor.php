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
</style>  
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/download-manager/css/tabs.css" />
<!--[if IE]>
<style>
ul#navigation { 
border-bottom: 1px solid #999999;
}
</style>
<![endif]-->
<div class="wrap">
<header>
<div class="icon32" id="icon-template"><br></div>
<h2><?php echo __('Templates','wpdmpro'); ?>
<a href="admin.php?page=file-manager/templates&_type=page&task=NewTemplate" class="button add-new-h2"><?php echo __('Create page template','wpdmpro'); ?></a><a href="admin.php?page=file-manager/templates&_type=link&task=NewTemplate" class="button add-new-h2"><?php echo __('Create link template','wpdmpro'); ?></a>
</h2>
</header>
<nav> 
<ul id="tabs">    
    <li <?php if(($_GET[_type]=='link'||$_GET[_type]=='')&&$_GET[task]==''){ ?>class="selected"<?php } ?>><a href="admin.php?page=file-manager/templates&_type=link" id="basic"><?php echo __('Link Templates','wpdmpro'); ?></a></li>    
    <li <?php if($_GET[_type]=='page'&&$_GET[task]==''){ ?>class="selected"<?php } ?>><a href="admin.php?page=file-manager/templates&_type=page" id="basic"><?php echo __('Page Templates','wpdmpro'); ?></a></li>    
    <li <?php if($_GET[task]=='NewTemplate'||$_GET[task]=='EditTemplate'){ ?>class="selected"<?php } ?>><a href="" id="basic"><?php echo __('Template Editor','wpdmpro'); ?></a></li>       
</ul>
</nav>

<div style="padding: 15px;">  
   
<div style="margin-left:10px;float: left;width:66%">
<form action="" method="post">  
<table cellspacing="0" class="widefat fixed">
    <thead>
    <tr>
    <th style="" class="manage-column column-author" id="author" scope="col"><?php echo $_GET['task']=='NewTemplate'?'New':'Edit'; ?> <?php echo $_GET['_type']=='page'?'Page':'Link'; ?> <?php echo __('Template','wpdmpro'); ?></th>
    </tr>
    </thead>
   
   <?php
    $default['link'] = '[thumb_50x50]  
<br style="clear:both"/>    
<b>[popup_link]</b><br/>
<b>[download_count]</b> downloads';    

$default['popup'] = '[thumb_400x200]
<fieldset class="pack_stats">
<legend><b>Package Statistics</b></legend>
<table>
<tr><td>Total Downloads:</td><td>[download_count]</td></tr>
<tr><td>Stock Limit:</td><td>[quota]</td></tr>
<tr><td>Total Files:</td><td>[file_count]</td></tr>
</table>
</fieldset>
<br style="clear:both"/>

[download_link]';

    $default['page'] = '[thumb_700x400]
<br style="clear:both"/>
[description]
<fieldset class="pack_stats">
<legend><b>Package Statistics</b></legend>
<table>
<tr><td>Total Downloads:</td><td>[download_count]</td></tr>
<tr><td>Stock Limit:</td><td>[quota]</td></tr>
<tr><td>Total Files:</td><td>[file_count]</td></tr>
</table>
</fieldset><br>
[download_link]';

    $tpl = maybe_unserialize(get_option("_fm_{$ttype}_templates",true));
    $tpl = $tpl[$_GET['tplid']];
    $tpl['content'] = $tpl['content']?$tpl['content']:$default[$ttype];

?> 
    
    <tbody class="list:post" id="the-list">    
    <tr valign="top" class="alternate author-self status-inherit" id="post-8">
                <td class="author column-author">
                <input type="hidden" name="tplid" value="<?php echo $_GET[tplid]?$_GET[tplid]:uniqid(); ?>">
                <?php echo __('Title','wpdmpro'); ?>:<br>
                <input type="text" style="width: 99%" name="tpl[title]" value="<?php echo htmlspecialchars($tpl[title]); ?>">
                <?php echo __('Content:','wpdmpro'); ?>
                <textarea spellcheck='false' style="width: 99%;height:250px;font-family:'Courier New'" id="templateeditor" name="tpl[content]"><?php echo stripslashes(htmlspecialchars($tpl[content])); ?></textarea>
				
                <div id="poststuff" class="postarea">
              <?php //the_editor(stripslashes($tpl['content']),'tpl[content]','content', true, true); ?>                
</div>
				
				

                <br />
                 
                <input type="submit" value="<?php echo __('Save Template','wpdmpro'); ?>" class="button-primary">
				
				
				
				
                </td>
                
     </tr>
    </tbody>
</table>
</form>
 
          
</div>

     







<div style="margin-left:10px;float: left;width:30%">
<table cellspacing="0" class="widefat fixed">
    <thead>
    <tr>
    <th style="" class="manage-column column-author" id="author" scope="col"><?php echo __('Template Variables','wpdmpro'); ?></th>
    </tr>
    </thead>
    

    <tbody class="list:post" id="the-list">    
    <tr valign="top" class="alternate author-self status-inherit" id="post-8">
               <td class="author column-author" style="padding: 10px;">
               <table id="template_tags">
               <?php if($ttype=='link'){ ?>
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[popup_link]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('download link open as popup','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[page_link]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('download link open as page','wpdmpro'); ?></td></tr>                               
               <?php } ?>
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[page_url]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('Package details page url','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[title]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show package title','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[icon]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show icon if available','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[thumb_WxH]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show preview thumbnail with specified width and height if available,l eg: [thumb_700x400] will show 700px &times; 400px image preview ','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[thumb_url_WxH]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('returns preview thumbnail url with specified width and height if available,l eg: [thumb_url_700x400] will return 700px &times; 400px image preview url','wpdmpro'); ?></td></tr>                
               <?php if($ttype!='link'){ ?>
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[gallery_WxH]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show additional preview thumbnails in gallery format, each image height and with will be same as specified, eg: [gallery_50x30] will show image gallery of additional previews and each image size will be 50px &timesx40px','wpdmpro'); ?></td></tr>                
               <!--<tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[slider-previews]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show previews in a slider type gallery','wpdmpro'); ?></td></tr>                -->
               <?php } ?>
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[excerpt_chars]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show a short description of pacakge from description, eg: [excerpt_200] will show short description with first 200 chars of description','wpdmpro'); ?></td></tr>                               
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[description]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('package description','wpdmpro'); ?></td></tr>                               
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[download_count]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('download counter','wpdmpro'); ?></td></tr>                               
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[download_url]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('download url','wpdmpro'); ?></td></tr>                               
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[download_link]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('direct link to download using download link label','wpdmpro'); ?></td></tr>                               
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[quota]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('number of downloads to expire download quota','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[file_list]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show list of all files in a package','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[version]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show package version','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[create_date]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show package create date','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[update_date]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('show package update date','wpdmpro'); ?></td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[audio_player]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- <?php echo __('Show mp3 player with your page or link template.','wpdmpro'); ?></td></tr>                
               <?php do_action("wdm_template_tag_row"); ?>
               </table>
               </td>
                
     </tr>
    </tbody>
</table>
</div>








</div>
</div>
 
