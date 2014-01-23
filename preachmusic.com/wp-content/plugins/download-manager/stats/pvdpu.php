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
</style>
<?php
$uid = $_GET['uid']&&$_GET['uid']!='all'?" s.uid='$_GET[uid]' and":'';
$m = $_GET['m']?$_GET['m']:date('n');
$y = $_GET['y']?$_GET['y']:date('Y');
?>
<form method="get" action="admin.php">
<input type="hidden" name="page" value="file-manager/stats">
<input type="hidden" name="type" value="pvdpu">
User ID: <input style="width: 60px" type="text" name="uid" value="<?php echo $_GET[uid]?$_GET[uid]:'all';?>">
Year: <input style="width: 80px" type="text" name="y" value="<?php echo $y;?>">
Month: <select name="m">
<?php for($i=1;$i<=12;$i++) { $sel = $m==$i?'selected=selected':''; echo "<option $sel value='{$i}'>{$i}</option>";} ?>
</select>
<input type="submit" class="button-secondary" value="Submit">

</form>
 <br>
 
<?php
global $wpdb;
$files = $wpdb->get_results("select s.pid,f.title from {$wpdb->prefix}ahm_download_stats s,{$wpdb->prefix}ahm_files f where $uid f.id=s.pid group by pid",ARRAY_A);
$dates = $wpdb->get_results("select *, concat(year,month,day) as dt from {$wpdb->prefix}ahm_download_stats where $uid `year`='$y' and `month`='$m' group by dt order by timestamp asc",ARRAY_A);
echo "<table class=stable width=100% cellspacing=0>" ;
echo "<tr><th>PACKAGE/DATE</th>";
foreach($dates as $date){
    echo "<th><a href='admin.php?page=file-manager/stats&type=pvupd&y={$date[year]}&m={$date[month]}&d={$date[day]}'>".date("d",$date[timestamp])."</a></th>";
    
}
echo "</tr>";
foreach($files as $file){
    echo "<tr><th align=left>{$file[title]}</th>";
    foreach($dates as $date){
           
          $fstats[$file['pid']][$date['dt']] = $wpdb->get_var("select count(*)  from {$wpdb->prefix}ahm_download_stats where concat(year,month,day)='$date[dt]' and pid='$file[pid]'");          
          if($fstats[$file['pid']][$date['dt']]>0)
          echo "<td class='info' title='".$fstats[$file['pid']][$date['dt']]." downloads' align=center><a href='admin.php?page=file-manager/stats&type=pvdaud&pid={$file[pid]}&y={$date[year]}&m={$date[month]}&d={$date[day]}'>".$fstats[$file['pid']][$date['dt']]."</a></td>";
          else
          echo "<td align=center>".$fstats[$file['pid']][$date['dt']]."</td>";
        
    }
    echo "</tr>";
}
echo "</table>" ;
echo "<pre>";


