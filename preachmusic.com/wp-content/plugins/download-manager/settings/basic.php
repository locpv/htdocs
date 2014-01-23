 <style>
 .frm td{
     padding:5px;
     border-bottom: 1px solid #eeeeee;
    
     font-size:10pt;
     
 }
 h4{
     color: #336699;
     margin-bottom: 0px;
 }
 em{
     color: #888;
 }
 </style>
<table cellpadding="5" cellspacing="0" class="frm" width="100%">
<?php if(!wpdm_is_custom_admin()): ?>            
<tr>
<td colspan="2">
<h4>Administration Options</h4>
</td>
</tr>
<tr>
<td width="250"><?php echo __('Allow only','wpdmpro'); ?> </td><td><select name="access_level">
    <option value="level_10">Administrator</option>    
    <option value="level_5" <?php echo get_option('access_level',true)=='level_5'?'selected':''?>>Editor</option>    
    <option value="level_2" <?php echo get_option('access_level',true)=='level_2'?'selected':''?>>Author</option>    
    </select> <?php echo __('and upper level users to administrate this plugin','wpdmpro'); ?>
</td>
</tr>

<tr>
<td><?php echo __('Multi-User','wpdmpro'); ?> </td><td> 
<select name="wpdm_multi_user">
    <option value="0"><?php echo __('Disabled','wpdmpro'); ?></option>    
    <option value="1" <?php echo get_option('wpdm_multi_user')=='1'?'selected':''?>><?php echo __('Enabled','wpdmpro'); ?></option>    
</select><br/>
<em><?php echo __('if multi-user enabled, only users with role "administrator" will able to see/mamane all wpdm packages, all other allowed users will able to manage their own  packages only'); ?><br/>
 <?php echo __('If multi-user disabled, all allowed users will able to see, manage all wpdm packages'); ?></em>
</td>
</tr>
<tr>
<td><?php echo __('Custom WPDM Super Admin','wpdmpro'); ?> </td><td> 
<input type="text" name="__wpdm_custom_admin" value="<?php echo get_option('__wpdm_custom_admin',''); ?>"><br/>
<em><?php echo __('Incase, if you want to allow any specific user(s) to administrate wpdm, enter his/her usernames above, usernames should separated by comma (",").'); ?></em>
</td>
</tr>
<tr>
<td><?php echo __('Show Search & Sort Bar for Categories','wpdmpro'); ?> </td><td> 
<select name="_wpdm_show_ct_bar"><option value="1">Yes</option><option value="" <?php if(get_option('_wpdm_show_ct_bar')=='') echo 'selected=selected'; ?> >No</option></select><br/>
<em><?php echo __('Incase, if you want to show a toolbar with option for searching and sorting packages in category page or for category short-codes'); ?></em>
</td>
</tr>
<tr>
<td colspan="2">
<h4>URL Structure</h4>
<em><?php echo __('If you like, you may enter custom structures for your wpdm category and package URLs here. For example, using packages as your category base would make your category links like http://example.org/packages/category-slug/. If you leave these blank the defaults will be used.'); ?></em>
</td>
</tr>
<tr>
<td><?php echo __('WPDM Category URL Base','wpdmpro'); ?> </td><td> 
<input type="text" name="__wpdm_curl_base" value="<?php echo get_option('__wpdm_curl_base','downloads'); ?>"><br/>
</td>
</tr>
<tr>
<td><?php echo __('WPDM URL Pacakge Base','wpdmpro'); ?> </td><td> 
<input type="text" name="__wpdm_purl_base" value="<?php echo get_option('__wpdm_purl_base','download'); ?>" onchange="jQuery('#purlbase').html(this.value);"><br/>
</td>
</tr>
 
<?php endif; ?>
<tr>
<td colspan="2">
<h4>Display Settings</h4>
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
<td valign="top"><?php echo __('Page Template:','wpdmpro'); ?></td><td>
<select name="_wpdm_custom_template">
<option value="page.php"><?php echo __('Default Page Template'); ?></option>
<?php 
$templates = get_page_templates();
foreach($templates as $name=>$file):
?>
<option value="<?php echo $file; ?>" <?php echo get_option('_wpdm_custom_template')==$file?'selected=selected':''; ?>><?php echo $name; ?></option>
<?php endforeach; ?>
<option value="1" <?php echo get_option('_wpdm_custom_template')=='1'?'selected=selected':''; ?> > <?php echo __('Custom Page Template','wpdmpro'); ?></option>
</select><br />
 
</td>
</tr> 
 
<tr>
<td><?php echo __('File Browser Root:','wpdmpro'); ?></td><td><input type="text" value="<?php echo get_option('_wpdm_file_browser_root',$_SERVER['DOCUMENT_ROOT']); ?>" name="_wpdm_file_browser_root" /> <span title="<?php echo __("Root dir for server file browser.<br/><b>*Don't add tailing slash (/)</b>",'wpdmpro'); ?>" class="info infoicon">(?)</span></td>
</tr> 
<tr>
<td><a name="fbappid"></a><?php echo __('Facebook APP ID','wpdmpro'); ?></td><td> 
<input type="text" name="_wpdm_facebook_app_id" value="<?php echo get_option('_wpdm_facebook_app_id'); ?>"><br/>
<em>Create new facebook app from <a target="_blank" href='https://developers.facebook.com/apps'>here</a></em>
</td>
</tr>
<tr>
<td colspan="3"><br>
<h4><?php echo __('Messages:','wpdmpro'); ?></h4>
<div style="border-top:1px solid #ccc;border-bottom:1px solid #fff;"></div><br>

<?php echo __('Permission Denied Message for Pacakges:','wpdmpro'); ?><br>
<input type=text name="wpdm_permission_msg" value="<?php echo htmlspecialchars(stripslashes(get_option('wpdm_permission_msg','Access Denied'))); ?>" /><br>
<br>
<?php echo __('Category Access Blocked Message:','wpdmpro'); ?><br>
<textarea cols="70" rows="6" name="__wpdm_category_access_blocked"><?php echo stripcslashes(get_option('__wpdm_category_access_blocked',__('You are not allowed to access this category!','wpdmpro'))); ?></textarea><br>
<br>
<?php echo __('Login Required Message <em>( use short-code [loginform] inside message box to integrate login form )</em>:','wpdmpro'); ?><br>
<textarea cols="70" rows="6" name="wpdm_login_msg"><?php echo get_option('wpdm_login_msg')?stripslashes(get_option('wpdm_login_msg')):"<a href='".get_option('siteurl')."/wp-login.php'  style=\"background:url('".get_option('siteurl')."/wp-content/plugins/download-manager/images/lock.png') no-repeat;padding:3px 12px 12px 28px;font:bold 10pt verdana;\">Please login to access downloadables</a>"; ?></textarea><br>
<input type="checkbox" name="__wpdm_login_form" value="1" <?php echo get_option('__wpdm_login_form',0)==1?'checked=checked':'';?> > <?php echo __('Show Only Login Button Instead of Login Required Message','wpdmpro'); ?>
<br>

 
</td>
</tr>

<?php do_action('basic_settings'); ?> 

</table>
 

