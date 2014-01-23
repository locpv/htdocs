<style>
input[type=text],textarea{
    width:500px;
    padding:5px;
}

input{
   padding: 7px; 
}

.ccount{
    -webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
background: #333333;
color: #ffffff;
padding:3px 5px;
font-weight: bold; 
min-width: 15px;
 
float: right;
text-align: center;
}
.dragging{
    background: #555;
}
.dragging a{
    color: #fff !important;
}
#access{ width: 95%; }
a.delete{
    color: #800000;
}
select{
    min-width: 200px;
}
#wpdmcats_info,
#wpdmcats_length{
    float: left;
    width:40%;
    margin-bottom: 10px;
}
#wpdmcats_paginate,
#wpdmcats_filter{
   float: right;
   margin-bottom: 12px;
     
}
#wpdmcats_filter input[type=text]{
    width:200px;
}
#wpdmcats_paginate,
#wpdmcats_info{
    margin-top: 10px;
}
#wpdmcats_previous{
    margin-right: 10px;
}
</style>
<link rel="stylesheet" href="<?php echo plugins_url('/download-manager/css/chosen.css'); ?>" />
<script language="JavaScript" src="<?php echo plugins_url('/download-manager/js/chosen.jquery.min.js'); ?>"></script> 
<script language="JavaScript" src="<?php echo plugins_url('/download-manager/js/jquery.form.js'); ?>"></script> 
<script language="JavaScript" src="<?php echo plugins_url('/download-manager/js/jquery.dataTables.min.js'); ?>"></script> 
<!--<script language="JavaScript" src="https://raw.github.com/isocra/TableDnD/master/js/jquery.tablednd.js"></script> -->
<script type="text/javascript">
jQuery(document).ready(function() {     
    //jQuery("#wpdmcats").tableDnD({onDragClass: "dragging"});
    jQuery("select").chosen({no_results_text: ""});
    jQuery("#wpdmcats").dataTable();
});
</script>
<div class="wrap"> 
    <div class="icon32" id="icon-categories"><br></div>
<h2><?php echo __('Categories','wpdmpro'); ?> <a href='admin.php?page=file-manager/categories' class="button-secondary"><?php echo __('add new','wpdmpro'); ?></a></h2><br>
  &nbsp;
<?php if($_GET['cid']==''){ ?>  
<div style="margin-left:10px;float: right;width:63%">  
<form method="post">
<table cellspacing="0" class="widefat fixed" width="100%" id="wpdmcats">
    <thead>
    <tr>
     
    
    <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
    <th><?php echo __('Category','wpdmpro'); ?></th>    
    <th><?php echo __('Embed Code','wpdmpro'); ?></th>        
    <th width="180px"><?php echo __('Actions','wpdmpro'); ?></th>        
       
    </tr>
    </thead>

    <tfoot>
    <tr>
        
    <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
 
    <th><?php echo __('Category','wpdmpro'); ?></th>       
    <th><?php echo __('Embed Code','wpdmpro'); ?></th>     
    <th width="180px"><?php echo __('Actions','wpdmpro'); ?></th>          
    </tr>
    </tfoot>

    <tbody class="list:post" id="the-list">
    <?php 
    function wpdm_render_cats($parent="",$level=0){
    global $wpdb;    
    if($categories = maybe_unserialize(get_option("_fm_categories",true))){    
       // print_r($categories); die();
    if(is_array($categories)){
    foreach($categories as $id=>$category) {  
        //$ccount = $wpdb->get_var("select count(*) as t from {$wpdb->prefix}ahm_files where category like '%\"$id\"%'");
        if($category['parent']==$parent){
            $pres = str_repeat("&mdash;", $level);
        ?>
     
    <tr id="row-<?php echo $id; ?>" valign="top" class="alternate author-self status-inherit child-of-<?php echo $parent; ?>"  <?php //if($parent!='') echo "style='display:none;'"; ?> >
    
                <th class="check-column" scope="row"><input type="checkbox" value="8" name="id[]">
                <input type="hidden" name="corder[]" value="<?php echo $id; ?>">
                </th>
                <td class="column-icon media-icon" style="text-align: left;" width="100%">                
                   
                    <a title="Edit" href="admin.php?page=file-manager/categories&task=EditCategory&cid=<?php echo $id; ?>">
                    <b><?php echo $pres.' '.stripcslashes($category['title']); ?></b>
                    </a> 
                   
                </td>
                <td>
                <input type="text" title="copy the code and place it anywhere inside your post or page" value="[wpdm_category id=<?php echo $id; ?> item_per_page=10]" readonly=readonly onclick="this.select()"  style="width:180px;font-size: 10px;" />
                </td>
                <td>                              
                <span class="edit"><a href="admin.php?page=file-manager/categories&task=EditCategory&cid=<?php echo $id; ?>">Edit</a> | </span>
                    <span class="delete"><a href="admin.php?page=file-manager/categories&task=DeleteCategory&cid=<?php echo $id?>" onclick="return showNotice.warn();" class="submitdelete">Delete</a>
                    </span>
                    
                </td>
                 
                
                
     
     </tr>
     <?php wpdm_render_cats($id,$level+1);}}}}} wpdm_render_cats(); ?>
    </tbody>
</table><br clear="all" />

<input type="submit" onclick="return showNotice.warn();" class="button button-primary" value="Delete Selected">
 <a href="admin.php?page=file-manager&task=deleteallcats&_nonce=<?php echo wp_create_nonce('wpdmdcs'); ?>" onclick="return confirm('<?php echo __("You are about to delete all categories. Are you sure?"); ?>');" class="button"><?php echo __("Delete All Categories At Once!"); ?></a>
 
</form>
</div>
<?php } ?>
<div style="margin-left:10px;float: left;width:33%">
<form id="wpdm-cf" action="admin-ajax.php" method="post">  
<input type="hidden" id="aact" name="action" value="<?php echo $_GET['cid']?'wpdm_create_category':'wpdm_update_category';?>" />
<h3><?php echo $_GET['cid']?'Edit':'Add';?> Category <?php if($_GET['cid']){ ?>( <a href='admin.php?page=file-manager/categories'><?php echo __("add new"); ?></a> )<?php } ?></h3>
 
    
   
   <?php
    $cat = maybe_unserialize(get_option('_fm_categories',array()));    
    $cat = $cat[$_GET['cid']];
    $cat[template_wraper] = $cat[template_wraper]?$cat[template_wraper]:'<div class="wpdm_category">
    [repeating_block]
</div>';
    
    $cat[template_repeater] = $cat[template_repeater]?$cat[template_repeater]:'<div class="wpdm_package">
    <a href="[page_url]">[thumb]</a><br>
    <b><a href="[page_url]">[title]</a></b><br>                
    [download_count] downloads
                
</div>';
?> 
    
             
                <input type="hidden" name="cid" id="hcid" value="<?php echo isset($_GET['cid'])?$_GET['cid']:''; ?>">
                <?php echo __('Title:','wpdmpro'); ?> <span style="padding-left: 30px;" id='ct'></span><br>
                <input type="text" id="ctitle" style="width: 99%" name="cat[title]" value="<?php echo htmlspecialchars(stripslashes($cat['title'])); ?>">                
                <br/>
                <br/>
                <?php echo __('Description:','wpdmpro'); ?>
                <textarea spellcheck=false style="width: 99%;" name="cat[content]"><?php echo stripslashes(htmlspecialchars($cat['content'])); ?></textarea>
                <br /><br/>
                <?php echo __('Parent:','wpdmpro'); ?><br />
                <select name="cat[parent]" id="cprnt">
                <option value=""><?php echo __('Top Level Category','wpdmpro'); ?></option>
                <?php wpdm_cat_dropdown_tree('',0,$cat['parent']); ?>
                </select>
                <br>                
                <br>                
                <?php /* depretiated from on v3.1.6
                Template Wrapper:<br>
                <textarea style="width: 99%;font-family:'Courier New'" rows="6" name="cat[template_wraper]"><?php echo htmlspecialchars(stripslashes($cat[template_wraper])); ?></textarea>
                Repeating Part (for each package):
                <textarea spellcheck=false style="width: 99%;font-family:'Courier New'" rows="6" name="cat[template_repeater]"><?php echo htmlspecialchars(stripslashes($cat[template_repeater])); ?></textarea>
                */ ?>
                <?php echo __('Wrapper Class Name','wpdmpro'); ?><span class="info" title="CSS Class Name"></span>:<br/>
                <input type="text" name="cat[wrapper_cllass]" value="<?php echo stripslashes(htmlspecialchars($cat['wrapper_class'])); ?>" style="width: 99%;"><br/>
                <i style="color: gray;">Optional, you can use this for styling reason, all package links will be under this css class</i>
                <br>
                <br>
                
                <?php echo __('Link Template:','wpdmpro'); ?> <span style="padding-left: 30px;" id='lt'></span><br>
                <select name="cat[link_template]" id="ltt">
                <?php 
                  $ctpls = scandir(WPDM_BASE_DIR.'/templates/');
                  array_shift($ctpls);
                  array_shift($ctpls);
                  foreach($ctpls as $ctpl){
                      $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                      if(preg_match("/WPDM[\s]+Link[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){                           
                ?>                
                <option value="<?php echo $ctpl; ?>"  <?php echo ( $cat['link_template']==$ctpl )?' selected ':'';  ?>><?php echo $matches[1]; ?></option>
                <?php
                }}
                if($templates = unserialize(get_option("_fm_link_templates",true))){ 
                  foreach($templates as $id=>$template) {  
                ?>
                <option value="<?php echo $id; ?>"  <?php echo ( $cat['link_template']==$id )?' selected ':'';  ?>><?php echo $template['title']; ?></option>
                <?php } } ?>
                </select><br/>
                <i style="color: gray;"><?php echo __('Required, Select a link template to apply to all packages uder this category','wpdmpro'); ?></i>
                <br>                
                <?php echo __('Allow Access:','wpdmpro'); ?><br>                
                <select name="cat[access][]" class="chzn-select role" multiple="multiple" id="access">
                <?php
                
                $currentAccess = $cat['access'];
                if(  $currentAccess ) $selz = (in_array('guest',$currentAccess))?'selected=selected':'';
                ?>
                
                <option value="guest" <?php echo $selz  ?>> All Visitors</option>
                <?php
                global $wp_roles;
                $roles = array_reverse($wp_roles->role_names);
                foreach( $roles as $role => $name ) { 
                
                
                
                if(  $currentAccess ) $sel = (in_array($role,$currentAccess))?'selected=selected':'';
                
                
                
                ?>
                <option value="<?php echo $role; ?>" <?php echo $sel  ?>> <?php echo $name; ?></option>
                <?php } ?>
                </select>
 
                <br>                
                <br>                
                <input type="submit" value="<?php echo $_GET['cid']?__('Update','wpdmpro'):__('Create','wpdmpro');?> <?php echo __('Category','wpdmpro'); ?>" class="button button-primary button-large">
                <img id="loading" src="images/loading.gif" style="padding: 7px 0 0 10px;position: absolute;display: none;" />
               
                
   
</form>                             <br>
<div noshade="noshade" size="1" style="border-top: 1px solid #ccc;">&nbsp;</div>
<form action="admin.php?task=wpdm-import-category-csv" method="post" enctype="multipart/form-data">
<b>Import form CSV File:</b>
<input type="file" name="csv" />
<input type="submit" value="Import CSV" class="button button-primary" />
</form>
<code>Download sample csv file: <a href="<?php echo plugins_url('/download-manager/category-sample.csv'); ?>">category-sample.csv</a></code>
</div>
<?php /*
<div style="margin-left: 10px; float: left; width: 30%;display: none;">
<table cellspacing="0" class="widefat fixed">
    <thead>
    <tr>
    <th scope="col" id="author" class="manage-column column-author" style="">Template Variables</th>
    </tr>
    </thead>
    <tbody id="the-list" class="list:post">    
    <tr valign="top" id="post-8" class="alternate author-self status-inherit">
                <td style="padding: 10px;" class="author column-author">
                <table>
               <tbody>
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[repeating_block]" onclick="this.select()" readonly="readonly"></td><td>- use this in "Template Wrapper" part</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[popup_link]" onclick="this.select()" readonly="readonly"></td><td>- download link open as popup</td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[page_url]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- Package details page url</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[page_link]" onclick="this.select()" readonly="readonly"></td><td>- download link open as page</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[icon]" onclick="this.select()" readonly="readonly"></td><td>- show icon if available</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[thumb]" onclick="this.select()" readonly="readonly"></td><td>- show thumbnail if available</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[desciption]" onclick="this.select()" readonly="readonly"></td><td>- download link description</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[price]" onclick="this.select()" readonly="readonly"></td><td>- download link price</td></tr>                
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[download_count]" onclick="this.select()" readonly="readonly"></td><td>- download counter</td></tr>                               
               <tr><td><input type="text" style="font-size: 10px; width: 120px; text-align: center;" value="[quota]" onclick="this.select()" readonly="readonly"></td><td>- number of downloads to expire download quota</td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[version]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- show package version</td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[create_date]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- show package create date</td></tr>                
               <tr><td><input type="text" readonly="readonly" onclick="this.select()" value="[update_date]" style="font-size:10px;width: 120px;text-align: center;"></td><td>- show package update date</td></tr>                
                </tbody></table>
                </td>
                
     </tr>
    </tbody>
</table>
</div> 
   
 */ ?>   
</div>

<script language="JavaScript">
<!--
  jQuery('#wpdm-cf').submit(function(){
      if(jQuery('#ctitle').val()==''){
         jQuery('#ct').css('color','#800000').html('* required');       
         return false;
      }
      
      if(jQuery('#ltt').val()==''){
         jQuery('#lt').css('color','#800000').html('* required');       
         return false;
      }
      jQuery('#loading').fadeIn();
      jQuery(this).ajaxSubmit({
          <?php if(!isset($_GET['cid'])): ?>clearForm: true,<?php endif; ?>
          success: function(res){
              var parts = res.split("|||");
              var cid = parts[1];
              var cname = parts[2];
              var cinfo = parts[3];       
              <?php if(!isset($_GET['cid'])): ?>
              var aact = 'Created';
              jQuery('#wpdmcats').prepend('<tr valign="top" class="alternate author-self status-inherit child-of- even" id="row-'+cid+'"><th scope="row" class="check-column  sorting_1"><input type="checkbox" name="id[]" value="8"><input type="hidden" value="'+cid+'" name="corder[]"></th><td width="100%" style="text-align: left;" class="column-icon media-icon "><nobr><a href="admin.php?page=file-manager/categories&amp;task=EditCategory&amp;cid='+cid+'" title="Edit"><b> '+cname+'</b></a> <em>'+cinfo+'</em></nobr></td><td class=" "><input type="text" style="width:180px;font-size: 10px;" onclick="this.select()" readonly="readonly" value="[wpdm_category id='+cid+' item_per_page=10]" title="copy the code and place it anywhere inside your post or page"></td><td class=" "><nobr><span class="edit"><a href="admin.php?page=file-manager/categories&amp;task=EditCategory&amp;cid='+cid+'">Edit</a> | </span><span class="delete"><a class="submitdelete" onclick="return showNotice.warn();" href="admin.php?page=file-manager/categories&amp;task=DeleteCategory&amp;cid='+cid+'">Delete</a></span></nobr></td></tr>');
              <?php else: ?>
              var aact = 'Updated';
              //jQuery('#row-<?php echo $_GET['cid']; ?>').replaceWith('<tr valign="top" class="alternate author-self status-inherit child-of- even" id="row-'+cid+'"><th scope="row" class="check-column  sorting_1"><input type="checkbox" name="id[]" value="8"><input type="hidden" value="'+cid+'" name="corder[]"></th><td width="100%" style="text-align: left;" class="column-icon media-icon "><nobr><a href="admin.php?page=file-manager/categories&amp;task=EditCategory&amp;cid='+cid+'" title="Edit"><b> '+cname+'</b></a> <em>'+cinfo+'</em></nobr></td><td class=" "><input type="text" style="width:180px;font-size: 10px;" onclick="this.select()" readonly="readonly" value="[wpdm_category id='+cid+' item_per_page=10]" title="copy the code and place it anywhere inside your post or page"></td><td class=" "><nobr><span class="edit"><a href="admin.php?page=file-manager/categories&amp;task=EditCategory&amp;cid='+cid+'">Edit</a> | </span><span class="delete"><a class="submitdelete" onclick="return showNotice.warn();" href="admin.php?page=file-manager/categories&amp;task=DeleteCategory&amp;cid='+cid+'">Delete</a></span></nobr></td></tr>');
              location.href="admin.php?page=file-manager/categories";
              <?php endif; ?>
              jQuery('#loading').fadeOut();              
              jQuery('#wpdm-cf').prepend('<div class="cinfom info updated" style="padding:5px;">Category '+aact+' Successfully!</div>');
              //jQuery('#cprnt_chzn').remove();
              //jQuery('#cprnt').fadeIn();                                                                                                  
              jQuery.post('admin-ajax.php',{action:'wpdm_category_dropdown'},function(res){jQuery("#cprnt").html(res); jQuery('#cprnt').trigger("liszt:updated");});
              setTimeout("jQuery('.cinfom').slideUp();",3000);
          }
      });
      return false;
  });
  <?php if($_GET['cid']!=''): ?>
  jQuery('.<?php echo $_GET['cid'];?>').attr('disabled','disabled');
  <?php endif; ?>
//-->
</script>