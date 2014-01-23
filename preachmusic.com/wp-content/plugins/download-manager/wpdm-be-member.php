<?php
    $invoice = $_GET['invoice']?$_GET['invoice']:$_SESSION['guest_order'];
    if($invoice!=''){
    $oorder = new Order();
    $order = $oorder->GetOrder($invoice);
    if($order->uid!=0) $invoice = '';
    }     
?>

<div class="wpdmpro">
<div class="container">
<div class="row"> 
<?php if($invoice): ?>
<div class="span12" >
<div class="alert alert-success" align="center" style="font-size:10pt;">
Your order is <?php echo $order->order_status; ?>. Please login or register to access your order.
</div>
</div>
<?php endif; ?>
<?php if($_SESSION['reg_warning']!=''): ?>  <br>
<div class="span12" >
<div class="alert alert-warning" align="center" style="font-size:10pt;">
<?php echo $_SESSION['reg_warning']; unset($_SESSION['reg_warning']); ?>
</div>
</div>
<?php endif; ?>
<?php if($_SESSION['sccs_msg']!=''): ?><br>
<div class="span12" >
<div class="alert alert-success" align="center" style="font-size:10pt;">
<?php echo $_SESSION['sccs_msg'];  unset($_SESSION['sccs_msg']); ?>
</div>
</div>
<?php endif; ?>                  
<div class="span6">
<?php include("wpdm-reg-form.php"); ?>
</div>
<div class="span5 offset1">
<?php include("wpdm-login-form.php"); ?>
</div>
</div>
<?php if(isset($_REQUEST['reseted'])): ?>
<div class="row">
<div class="span12">
<div class="alert alert-success"><?php echo $_COOKIE['global_success'];?></div>
</div>
</div>
<?php unset($_COOKIE['global_success']); endif; ?>
</div>
</div>
