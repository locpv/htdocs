 <link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/download-manager/css/tabs.css" /> 
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
 
<div class="wrap">
<header>
    <div class="icon32" id="icon-stats"><br></div>
<h2><?php echo __('Download Statistics','wpdmpro'); ?></h2><br>
</header>
<nav> 
<ul id="tabs">    
    <li <?php if(($_GET[type]=='')&&$_GET[task]==''){ ?>class="selected"<?php } ?>><a href='admin.php?page=file-manager/stats'><?php echo __('This Month','wpdmpro'); ?></a></li>    
    <li <?php if($_GET[type]=='pvdpu'){ ?>class="selected"<?php } ?>><a href='admin.php?page=file-manager/stats&type=pvdpu'><?php echo __('Package vs Date','wpdmpro'); ?></a></li>    
    <li <?php if($_GET[type]=='pvupd'){ ?>class="selected"<?php } ?>><a href='admin.php?page=file-manager/stats&type=pvupd'><?php echo __('Package vs User','wpdmpro'); ?></a></li>       
</ul>
</nav>
 <div style="padding: 15px;"> 
<br/>
<?php 

$type = $_GET['type']?"stats/{$_GET[type]}.php":"stats/current-month.php";

include($type);

?>
</div>
</div>