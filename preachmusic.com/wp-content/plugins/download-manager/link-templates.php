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
<h2>Templates 
<a href="admin.php?page=file-manager/templates&_type=page&task=NewTemplate" class="button add-new-h2">Create page template</a><a href="admin.php?page=file-manager/templates&_type=link&task=NewTemplate" class="button add-new-h2">Create link template</a>
</h2>
</header> 
<nav> 
    <ul id="tabs">    
    <li <?php if($_GET[_type]=='link'||$_GET[_type]==''){ ?>class="selected"<?php } ?>><a href="admin.php?page=file-manager/templates&_type=link" id="basic">Link Templates</a></li>    
    <li <?php if($_GET[_type]=='page'){ ?>class="selected"<?php } ?>><a href="admin.php?page=file-manager/templates&_type=page" id="basic">Page Templates</a></li>    
    <!--<li <?php if($_GET[_type]=='popup'){ ?>class="selected"<?php } ?>><a href="admin.php?page=file-manager/templates&_type=popup" id="basic">Popup Templates</a></li>    -->
    </ul>
</nav>    

<div style="padding: 15px;">   
<table cellspacing="0" class="widefat fixed">
    <thead>
    <tr>
    <th style="" class="manage-column column-media" id="media" scope="col">Template Name</th>           
    </tr>
    </thead>

    <tfoot>
    <tr>
    <th style="" class="manage-column column-media" id="media" scope="col">Template Name</th>    
    </tr>
    </tfoot>
    <tbody class="list:post" id="the-list">
    <?php 
    $ttype = $_GET['_type']?$_GET['_type']:'link';
    if($templates = maybe_unserialize(get_option("_fm_{$ttype}_templates",true))){    
    if(is_array($templates)){
    foreach($templates as $id=>$template) {  ?>
    <tr valign="top" class="alternate author-self status-inherit" id="post-8">
                <td class="column-icon media-icon" style="text-align: left;">                
                    <a title="Edit" href="admin.php?page=file-manager/templates&_type=<?php echo $ttype; ?>&task=EditTemplate&tplid=<?php echo $id; ?>">
                    <b><?php echo $template['title']?></b>
                    </a>
                    <div class="row-actions"><span class="edit"><a href="admin.php?page=file-manager/templates&_type=<?php echo $ttype; ?>&task=EditTemplate&tplid=<?php echo $id; ?>">Edit</a> | </span><span class="delete"><a href="admin.php?page=file-manager/templates&_type=<?php echo $ttype; ?>&task=DeleteTemplate&tplid=<?php echo $id?>" onclick="return showNotice.warn();" class="submitdelete">Delete Permanently</a></div>                    
                </td>
                
                
     
     </tr>
     <?php }}} ?>
    </tbody>
</table>

</div>              







</div>
 
