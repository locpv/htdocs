<style type="text/css">
.stable {
    border-top:1px solid #888;
    border-left:1px solid #888;
}
.stable td,.stable th{
    border-bottom:1px solid #888;
    border-right:1px solid #888;
    padding:3px;
}
</style><?php
global $wpdb;
$d = $_GET['d']?$_GET['d']:date('d');
$m = $_GET['m']?$_GET['m']:date('n');
$y = $_GET['y']?$_GET['y']:date('Y');
$file = $_GET['pid'];
$fd =  $wpdb->get_row("select * from {$wpdb->prefix}ahm_files where id='$file'",ARRAY_A);
$data = $wpdb->get_results("select * from {$wpdb->prefix}ahm_download_stats where pid='$file' and `year`='$y' and `month`='$m' and `day`='$d'",ARRAY_A);
?>
<b>Package: <?php echo $fd['title']; ?></b><br>
<form method="get" action="admin.php">
<input type="hidden" name="page" value="file-manager/stats">
<input type="hidden" name="type" value="pvdaud">
Package ID: <input style="width: 80px" type="text" name="pid" value="<?php echo $file;?>">
Year: <input style="width: 80px" type="text" name="y" value="<?php echo $y;?>">
Month: <select name="m">
<?php for($i=1;$i<=12;$i++) { $sel = $m==$i?'selected=selected':''; echo "<option $sel value='{$i}'>{$i}</option>";} ?>
</select>
Day: <select name="d">
<?php for($i=1;$i<=31;$i++) { $sel = $d==$i?'selected=selected':''; echo "<option $sel value='{$i}'>{$i}</option>";} ?>
</select>
<input type="submit" class="button-secondary" value="Submit">

</form>
 <br>
<table class="stable" width="100%" cellspacing="0">
<tr>
    <th align="left">User</th>
    <th align="left">Date/Time</th>
    <th align="left">IP</th>    
</tr>
<?php
    foreach($data as $d){
?>
<tr>
    <td><?php echo $wpdb->get_var("select user_login from {$wpdb->prefix}users where ID='$d[uid]'"); ?></td>
    <td><?php echo date("M d,Y H:i:s",$d[timestamp]); ?></td>
    <td><?php echo $d[ip]; ?></td>
</tr>
<?php        
    }
?>
</table>
