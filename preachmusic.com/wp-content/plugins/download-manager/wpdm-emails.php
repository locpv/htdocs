<?php
global $wpdb, $current_user;
$limit = 20;
get_currentuserinfo(); 
$_GET['paged'] = $_GET['paged']?$_GET['paged']:1;
$start = $_GET['paged']?(($_GET['paged']-1)*$limit):0;
$field = $_GET['sfield']?$_GET['sfield']:'id';
$ord = $_GET['sorder']?$_GET['sorder']:'desc';
$pid = (int)$_GET['pid'];
if($_GET['pid']) $cond = " and e.pid=$pid";
if($_GET['uniq']) $group = " group by e.pid";
$res = $wpdb->get_results("select e.*,f.title from {$wpdb->prefix}ahm_emails e,{$wpdb->prefix}ahm_files f where e.pid=f.id $cond $group order by {$field} {$ord} limit $start, $limit",ARRAY_A);
$total = $wpdb->get_var("select count(*) as t from {$wpdb->prefix}ahm_emails"); 
 
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
    <li class="selected"><a id="basic" href="admin.php?page=file-manager/emails"><?php echo __('Emails','wpdmpro'); ?></a></li>    
    <li><a id="basic" href="admin.php?page=file-manager/emails&task=template"><?php echo __('Email Template','wpdmpro'); ?></a></li>        
    <li><a id="basic" href="admin.php?page=file-manager/emails&task=export"><?php echo __('Export CSV','wpdmpro'); ?></a></li>        
    <li><a id="basic" href="admin.php?page=file-manager/emails&task=export&uniq=1"><?php echo __('Export Unique Emails','wpdmpro'); ?></a></li>        
    </ul>
</nav>     

 


           
<form method="post" action="admin.php?page=file-manager/emails&task=delete" id="posts-filter" style="padding: 20px;"> 
<div class="tablenav">

<div class="alignleft actions">
<nobr>
<input type="submit" class="button-secondary action" id="doaction" value="<?php echo __('Delete Selected','wpdmpro'); ?>">
<?php if($_REQUEST['q']) { ?>
<input type="button" class="button-secondary action" onclick="location.href='admin.php?page=file-manager'" value="<?php echo __('Reset Search','wpdmpro'); ?>">
<?php } ?>
</nobr> 



</div>

<br class="clear">
</div>

<div class="clear"></div>

<table cellspacing="0" class="widefat fixed">
    <thead>
    <tr>
    <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>         
    <th style="width:50px" style="" class="manage-column column-id"  scope="col"><?php echo __('ID','wpdmpro'); ?></th>
    <th style="" class="manage-column column-media" id="email" scope="col"><?php echo __('Email','wpdmpro'); ?></th>
    <th style="" class="manage-column column-media" id="email" scope="col"><?php echo __('Custom Fields','wpdmpro'); ?></th>
    <th style="" class="manage-column column-media" id="filename" scope="col"><?php echo __('Package Name','wpdmpro'); ?></th>
    <th style="" class="manage-column column-password" id="author" scope="col"><?php echo __('Date','wpdmpro'); ?></th>    
    </tr>
    </thead>

    <tfoot>
    <tr>
    <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>         
    <th style="width:50px" style="" class="manage-column column-id"  scope="col"><?php echo __('ID','wpdmpro'); ?></th>
    <th style="" class="manage-column column-media" id="email" scope="col"><?php echo __('Email','wpdmpro'); ?></th>
    <th style="" class="manage-column column-media" id="email" scope="col"><?php echo __('Custom Fields','wpdmpro'); ?></th>
    <th style="" class="manage-column column-media" id="filename" scope="col"><?php echo __('Package Name','wpdmpro'); ?></th>
    <th style="" class="manage-column column-password" id="author" scope="col"><?php echo __('Date','wpdmpro'); ?></th>    
    </tr>
    </tfoot>

    <tbody class="list:post" id="the-list">
    <?php foreach($res as $row) { 
                   
        ?>
    <tr valign="top" class="alternate author-self status-inherit" id="post-<?php echo $row[id]; ?>">

                <th class="check-column" style="padding: 5px 0px !important;" scope="row"><input type="checkbox" value="<?php echo $row[id]; ?>" name="id[]"></th>
                <td scope="row">
                <?php echo $row['id']; ?>
                </td>
                <td scope="row"><?php echo $row['email']; ?></td>
                <td scope="row"><?php $cd = unserialize($row['custom_data']); if($cd) foreach($cd as $k=>$v): echo ucfirst($k).": $v<br/>"; endforeach; ?></td>
                
                <td class="media column-media">
                <a href='admin.php?page=file-manager/emails&pid=<?php echo $row['pid']; ?>'><?php echo $row['title']; ?></a>
                </td>
                <td class="author column-author"><?php echo date("Y-m-d H:i",$row['date']); ?></td>                
     
     </tr>
     <?php } ?>
    </tbody>
</table>
                    
<?php
$cp = $_GET['paged']?$_GET['paged']:1;
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
<div class="tablenav-pages"><?php $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
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
          if(!showNotice.warn()) return false;
          var id = '#post-'+this.rel;
          jQuery.post(this.href,function(){
              jQuery(id).fadeOut();
          }) ;
          return false;
     });
  });
//-->
</script> 