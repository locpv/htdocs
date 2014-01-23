<?php
    global $current_user, $wpdb;
    $user = $wpdb->get_row("select * from {$wpdb->prefix}users where ID=".$current_user->ID);
     
?>
<style type="text/css">
#edit_profile span6{
    margin: 0px;
}
#edit_profile li input{
    width: 90%;
}
</style>
 
<div class="my-profile">

<div id="form" class="form profile-form">
<div class="row-fluid">
<div class="span12">
<?php if($_SESSION['member_error']){ ?>         
<div class="alert alert-error"><b>Save Failed!</b><br/><?php echo implode('<br/>',$_SESSION['member_error']); unset($_SESSION['member_error']); ?></div>
<?php } ?>
<?php if($_SESSION['member_success']){ ?>
<div class="alert alert-success"><b>Done!</b><br/><?php echo $_SESSION['member_success']; unset($_SESSION['member_success']); ?></div>
<?php } ?>
</div>
</div>
<form method="post" id="edit_profile" style="margin-left: 20px;" name="contact_form" action="" class="form">
<div class="row-fluid">                                            
                                                <div class="span6"><label for="name">Display name: </label><input type="text" class="required span12" value="<?php echo $user->display_name;?>" name="profile[display_name]" id="name"></div>
                                                <div class="span6"><label for="payment_account">PayPal Email: </label><input type="text" value="<?php echo get_user_meta($user->ID,'payment_account',true); ?>" class="span11" name="payment_account" id="payment_account"> </div>
</div>                                                
<div class="row-fluid">                                            
                                                <div class="span6"><label for="username">Username:</label><input type="text" class="required span12" value="<?php echo $user->user_login;?>" id="username" readonly="readonly"></div>                                                 
                                                <div class="span6"><label for="email">Email:</label><input type="text" class="required span11" value="<?php echo $user->user_email;?>" id="email" readonly="readonly"></div>                                                 
</div>                                                
<div class="row-fluid">                                                                                            
                                                <div class="span6"><label for="new_pass">New Password: </label><input placeholder="Use nothing if you don't want to change old password" type="password" class="span12" value="" name="password" id="new_pass"> </div>
                                                <div class="span6"><label for="re_new_pass">Re-type New Password: </label><input type="password" value="" class="span11" name="cpassword" id="re_new_pass"> </div>                                                
</div>                                                
<div class="row-fluid">                                            
                                                
                                                <?php do_action('wpdm_update_profile_filed_html', $user); ?>
</div>
<div class="row-fluid">                                            
                                                
                                                <div class="span12"><label for="message">Description:</label><textarea class="text span12" cols="40" rows="8" name="profile[description]" id="message"><?php echo htmlspecialchars(stripslashes($current_user->description));?></textarea></div>                                                                                                
</div>  
<div class="row-fluid">                                                                                      
<div class="span12"><button type="submit" class="btn btn-large btn-primary"><i class="icon-ok icon-white"></i> Save Changes</button></div>                                                
</div>
</form>
</div>
</div>