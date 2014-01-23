 <style>
 .frm td{
     padding:5px;
     border-bottom: 1px solid #eeeeee;
    
     font-size:10pt;
     
 }
 </style>
<table cellpadding="5" cellspacing="0" class="frm" width="100%">
           
<tr>
<td width="250"><?php echo __('Allow only','wpdmpro'); ?> </td><td><select name="access_level">
    <option value="level_10">Administrator</option>    
    <option value="level_5" <?php echo get_option('access_level',true)=='level_5'?'selected':''?>>Editor</option>    
    <option value="level_2" <?php echo get_option('access_level',true)=='level_2'?'selected':''?>>Author</option>    
    </select> <?php echo __('and upper level users to use this plugin','wpdmpro'); ?>
</td>
</tr>

<tr>
<td><?php echo __('Multi-User','wpdmpro'); ?> </td><td> 
<select name="wpdm_multi_user">
    <option value="0"><?php echo __('Disabled','wpdmpro'); ?></option>    
    <option value="1" <?php echo get_option('wpdm_multi_user')=='1'?'selected':''?>><?php echo __('Enabled','wpdmpro'); ?></option>    
</select>
</td>
</tr>


<tr>
<td><?php echo __('Enable short-code','wpdmpro'); ?> </td><td> 
<select name="_wpdm_skip_blog">
    <option value="0"><?php echo __('Everywhere','wpdmpro'); ?></option>    
    <option value="1" <?php echo get_option('_wpdm_skip_blog')=='1'?'selected':''?>><?php echo __('Only Single Page/Post','wpdmpro'); ?></option>    
</select>
</td>
</tr>



<tr>
<td valign="top"><?php echo __('Page Template:','wpdmpro'); ?></td><td><select name="_wpdm_custom_template">
<option value="0"><?php echo __('Integrated Page Template','wpdmpro'); ?></option>
<option value="1" <?php echo get_option('_wpdm_custom_template')=='1'?'selected=selected':''; ?> > <?php echo __('Custom Page Template','wpdmpro'); ?></option>
</select><br />
<a href='admin.php?action=wdm_help&helpfile=before-creating-new-package' class="thickbox"><?php echo __('How to build custom page template?','wpdmpro'); ?></a> <br/>
<a href='#'><?php echo __('How to use integrated page template?','wpdmpro'); ?></a> 
</td>
</tr> 

<tr>
<td><?php echo __('Link Thumb Size','wpdmpro'); ?></td><td><input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_thumb_w" value="<?php echo get_option('_wpdm_thumb_w',200);?>" />x<input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_thumb_h" value="<?php  echo get_option('_wpdm_thumb_h',100);?>" /> (Width x Height px) <span title="<?php echo __('Thumbnail size for main previews which will be<br/>displayed by shortcode <b>[thumb]</b> with link template.','wpdmpro'); ?>" class="info infoicon">(?)</span></td>
</tr> 
<tr>
<td><?php echo __('Page Thumb Size','wpdmpro'); ?></td><td><input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_pthumb_w" value="<?php echo get_option('_wpdm_pthumb_w',400);?>" />x<input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_pthumb_h" value="<?php  echo get_option('_wpdm_pthumb_h',200);?>" /> (Width x Height px) <span title="<?php echo __('Thumbnail size for main previews which will be displayed<br/>by shortcode <b>[thumb]</b> with page template.','wpdmpro'); ?>" class="info infoicon">(?)</span></td>
</tr> 
<tr>
<td><?php echo __('Gallery Thumb Size','wpdmpro'); ?></td><td><input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_athumb_w" value="<?php echo get_option('_wpdm_athumb_w',50);?>" />x<input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_athumb_h" value="<?php  echo get_option('_wpdm_athumb_h',50);?>" /> (Width x Height px) <span title="<?php echo __('Thumbnail size for additional previews<br/>which will be displayed by shortcode <b>[athumbs]</b>.','wpdmpro'); ?>" class="info infoicon">(?)</span></td>
</tr> 
<tr>
<tr>
<td><?php echo __('Widget Thumb Size','wpdmpro'); ?></td><td><input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_wthumb_w" value="<?php echo get_option('_wpdm_wthumb_w',150);?>" />x<input style="width: 40px;padding:3px;text-align: center;" type="text" name="_wpdm_wthumb_h" value="<?php  echo get_option('_wpdm_wthumb_h',70);?>" /> (Width x Height px) <span title="<?php echo __('Thumbnail size for additional previews<br/>which will be displayed by shortcode <b>[athumbs]</b>.','wpdmpro'); ?>" class="info infoicon">(?)</span></td>
</tr> 
 
<tr>
<td><?php echo __('File Browser Root:','wpdmpro'); ?></td><td><input type="text" value="<?php echo get_option('_wpdm_file_browser_root',$_SERVER['DOCUMENT_ROOT']); ?>" name="_wpdm_file_browser_root" /> <span title="<?php echo __("Root dir for server file browser.<br/><b>*Don't add tailing slash (/)</b>",'wpdmpro'); ?>" class="info infoicon">(?)</span></td>
</tr> 
<tr>
<td colspan="3"><br>
<b><?php echo __('Messages:','wpdmpro'); ?></b>
<div style="border-top:1px solid #ccc;border-bottom:1px solid #fff;"></div><br>

<?php echo __('Permission Denied Message:','wpdmpro'); ?><br>
<textarea cols="70" rows="6" name="wpdm_permission_msg"><?php echo get_option('wpdm_permission_msg')?stripslashes(get_option('wpdm_permission_msg')):"<span  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') left center no-repeat;padding-left:20px;font:bold 10pt verdana;color:#800000\">Permission denied!</span>"; ?></textarea><br>
<br>
<?php echo __('Login Required Message:','wpdmpro'); ?><br>
<textarea cols="70" rows="6" name="wpdm_login_msg"><?php echo get_option('wpdm_login_msg')?stripslashes(get_option('wpdm_login_msg')):"<a href='".get_option('siteurl')."/wp-login.php'  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;\">Please login to access downloadables</a>"; ?></textarea><br>
<br>

 
</td>
</tr>

<?php do_action('basic_settings'); ?> 

</table>
 

