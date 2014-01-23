<?php
class Stats{
    
    function Stats(){
        
    }
    
    function NewStat($pid, $uid, $oid){
        global $wpdb;
        $ip = $_SERVER['REMOTE_ADDR'];
        $wpdb->insert("{$wpdb->prefix}ahm_download_stats",array('pid'=>(int)$pid, 'uid'=>(int)$uid,'oid'=>$oid, 'year'=> date("Y"), 'month'=> date("m"), 'day'=> date("d"), 'timestamp'=> time(),'ip'=>$ip));        
        $wpdb->query("update {$wpdb->prefix}ahm_files set download_count=download_count+1 where id='$pid'");
         
    }
    
    
    function GetOrder($id) {
        global $wpdb;
        return $wpdb->get_row("select * from {$wpdb->prefix}ahm_orders where order_id='$id'");
    }

    function GetOrders($id) {
        global $wpdb;
        return $wpdb->get_results("select * from {$wpdb->prefix}ahm_orders where uid='$id'");
    }
    
    function Delete($id){
        global $wpdb;
        return $wpdb->query("delete from {$wpdb->prefix}ahm_orders where order_id='$id'");
    }
    
    
}