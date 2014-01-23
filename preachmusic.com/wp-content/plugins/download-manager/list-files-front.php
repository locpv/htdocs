<?php
global $wpdb, $current_user, $wp_query;

$limit = 10;
get_currentuserinfo(); 
$cond[] = "uid='{$current_user->ID}'";
$_REQUEST[q] = $_POST['q']?$_POST['q']:$_GET['q'];
$_GET['paged'] = $wp_query->query_vars['paged']?$wp_query->query_vars['paged']:1;
$_REQUEST['q'] =mysql_escape_string(trim($_REQUEST['q']));
if($_REQUEST['q']!='') $cond[] = "(`title` LIKE '%$_REQUEST[q]%' or `description` LIKE '%$_REQUEST[q]%')";
$cond = count($cond)>0?"where ".implode(" and ", $cond):'';
$start = $_GET['paged']?(($_GET['paged']-1)*$limit):0;
$field = $_GET['sfield']?$_GET['sfield']:'id';
$ord = $_GET['sorder']?$_GET['sorder']:'desc';
if($_REQUEST['q']) $qr = "&q=$_REQUEST[q]";
else $qr = '';
$res = $wpdb->get_results("select * from {$wpdb->prefix}ahm_files $cond order by {$field} {$ord} limit $start, $limit",ARRAY_A); 
$total = $wpdb->get_var("select count(*) as t from {$wpdb->prefix}ahm_files $cond");
 
?>

<div class="wpdm-front wpdmpro">
 

           
<form method="get" action="" id="posts-filter">

  
<div class="tablenav" style="line-height: 25px;margin-top: 20px;">
<nobr style="line-height: 25px;">
Select Action:
<select class="select-action" name="do" onchange="if(this.value=='search') {jQuery('#sfld').fadeIn();jQuery('#posts-filter').attr('method','get');jQuery('input[type=checkbox]').removeAttr('checked');} else  {jQuery('#sfld').fadeOut();jQuery('#posts-filter').attr('method','post');}">
<option value="search">Search</option>
<option value="DeleteFile">Delete Selected</option>
</select>&nbsp;<input type="text" id="sfld" style="width: 140px;" name="q" value="<?php echo $_REQUEST['q']; ?>">
<button type="submit" class="btn btn-primary" id="doaction" style="margin-top: -10px;">Apply</button>
<?php if($_REQUEST['q']) { ?>
<button type="button" class="btn btn-danger" onclick="location.href='?'"  style="margin-top: -10px;">Reset Search</button>
<?php } ?>

</nobr> 
</div>

<div class="clear"></div>

<table cellspacing="0" class="dtable table table-hover table-striped">
    <thead>
    <tr>
    <th width="20" style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>     
    <th style="" class="manage-column column-media sortable <?php echo $_GET['sorder']=='asc'?'asc':'desc'; ?>" id="media" scope="col"><a href='?sfield=title&sorder=<?php echo $_GET['sorder']=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $_GET['paged']?$_GET['paged']:1;?>'><span>Package Title</span><span class="sorting-indicator"></span></a></th>    
    <th style="" class="manage-column column-media" id="media" scope="col">Embed Code</th>    
    <th width="60" style="" class="manage-column column-parent sortable <?php echo $_GET['sorder']=='asc'?'asc':'desc'; ?>" id="parent" scope="col"><a href='?sfield=download_count&sorder=<?php echo $_GET['sorder']=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $_GET['paged']?$_GET['paged']:1;?>'><span>Downloads</span><span class="sorting-indicator"></span></a></th>
    <th style="" class="manage-column column-media" id="media" scope="col" align="center">Actions</th>    
    </tr>
    </thead>

    <tfoot>
    <tr>
    <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th> 
    <th style="" class="manage-column column-media sortable <?php echo $_GET['sorder']=='asc'?'asc':'desc'; ?>" id="media" scope="col"><a href='?sfield=title&sorder=<?php echo $_GET['sorder']=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $_GET['paged']?$_GET['paged']:1;?>'><span>Package Title</span><span class="sorting-indicator"></span></a></th>
    <th style="" class="manage-column column-media" id="media" scope="col">Embed Code</th>    
    <th style="" class="manage-column column-parent sortable <?php echo $_GET['sorder']=='asc'?'asc':'desc'; ?>" id="parent" scope="col"><a href='?sfield=download_count&sorder=<?php echo $_GET['sorder']=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $_GET['paged']?$_GET['paged']:1;?>'><span>Downloads</span><span class="sorting-indicator"></span></a></th>
    <th style="" class="manage-column column-media" id="media" scope="col" align="center">Actions</th>    
    </tr>
    </tfoot>

    <tbody class="list:post" id="the-list">
    <?php foreach($res as $media) { 
                   
        ?>
    <tr valign="top" class="alternate author-self status-inherit" id="post-<?php echo $media[id]; ?>">

                <td class="check-column" scope="row"><input type="checkbox" value="<?php echo $media[id]; ?>" name="id[]"></td>
                  
                <td class="media column-media">
                    <a title="Edit" href="?task=edit-package&id=<?php echo $media['id']?>"><strong><?php echo stripcslashes($media['title']);?></strong></a>                    
                </td>
                <td><input style="text-align:center;padding:3px;font-size:8pt;background: #fff;margin: 0px" type="text" onclick="this.select()" size="20" title="Simply Copy and Paste in post contents" value="[wpdm_package id=<?php echo $media['id'];?>]" /></td>         
                <td class="parent column-parent"><?php echo $media['download_count']; ?></td>
                <td class="actions"><div class="btn-group"><a class="btn btn-primary btn-small" href="?task=edit-package&id=<?php echo $media['id']?>"><i class="icon icon-white icon-edit"></i></a><a class="btn btn-small btn-success" target="_blank" href='<?php echo home_url('/'.get_option('__wpdm_purl_base','download').'/').(get_wpdm_meta($media[id],'url_key')?get_wpdm_meta($media[id],'url_key'):$media[id]); ?>'><i class="icon icon-white icon-eye-open"></i></a><a href="#" class="submitdelete btn btn-danger btn-small deletewpdmfile dropdown-toggle" data-toggle="dropdown" href="#" rel="popover" ><i class="icon icon-white icon-remove"></i></a> <ul class="dropdown-menu">
<li id="li-<?php echo $media['id']; ?>">
&nbsp;&nbsp;&nbsp;&nbsp;Are you sure?<br/>
<a href='?task=delete-package&id=<?php echo $media['id']; ?>' class="submitdelete" rel="<?php echo $media['id']; ?>" style="width: 20px;float: left;">Yes</a> <a href='#' onclick="return false;"  style="width: 20px;float: right;margin-top: -26px;">No</a></li>
</ul></div></td>
     
     </tr>
     <?php } ?>
    </tbody>
</table>
                    
<?php
global $wp_query;
$cp = $wp_query->query_vars['paged']?$wp_query->query_vars['paged']:1;
 
$page_links = paginate_links( array(
    'base' => add_query_arg( 'paged', '%#%' ),
    'format' => '',
    'prev_text' => __('&laquo;'),
    'next_text' => __('&raquo;'),
    'total' => ceil($total/$limit),
    'current' => $cp
));


?>

<div id="ajax-response"></div>

<div class="tablenav">

<?php if ( $page_links ) { ?>
<div class="tablenav-pages"><?php $page_links_text = sprintf( '<span style="margin-right:20px;" class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
    number_format_i18n( ( $_GET['paged'] - 1 ) * $limit + 1 ),
    number_format_i18n( min( $_GET['paged'] * $limit, $total ) ),
    number_format_i18n( $total ),
    $page_links
); echo $page_links_text; ?></div>
<?php } ?>

 
<br class="clear">
</div>
</form>
<br class="clear">

</div>

<script language="JavaScript">
<!--
  jQuery(function(){
     jQuery('.submitdelete').click(function(){           
          var id = '#post-'+this.rel;
          jQuery('#li-'+this.rel).html("<a href='#'><i class='icon icon-time'></i> Deleting...</a>");
          jQuery.post(this.href,function(){
              jQuery(id).fadeOut();
          }) ;
          return false;
     });
     jQuery('.dropdown-toggle').dropdown();
  });
//-->
</script> 