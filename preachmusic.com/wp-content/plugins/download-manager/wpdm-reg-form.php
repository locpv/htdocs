<script language="JavaScript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<div align="left"> 
<form method="post" action="" id="registerform" name="registerform" class="login-form">
<input type="hidden" name="permalink" value="<?php the_permalink(); ?>" />
<h1 class="header-1 entry-title">Register</h1>
<div class="stripe"></div> 
<?php global $wp_query; if($_SESSION['reg_error']!='') {  ?>
<blockquote class="error alert alert-danger" style="width: 260px;text-align: left;">
<b>Registration Failed!</b><br/>
<?php echo $_SESSION['reg_error']; $_SESSION['reg_error']=''; ?>
</blockquote>   
<?php } ?>

    <p class="control-group">
        Display Name<br>
        <input type="text" tabindex="101" size="20" class="input" id="displayname" value="<?php echo $_SESSION['tmp_reg_info']['display_name']; ?>" name="reg[display_name]">
    </p>
    <p class="control-group">
        <label class="control-label" for="user_login">Username</label>
        <input type="text" tabindex="102" size="20" class="required" id="user_login" value="<?php echo $_SESSION['tmp_reg_info']['user_login']; ?>" name="reg[user_login]">
    </p>
    <p class="control-group">
        <label class="control-label" for="user_email">E-mail</label>
        <input type="text" tabindex="103" size="25" class="required email" id="user_email" value="<?php echo $_SESSION['tmp_reg_info']['user_email']; ?>" name="reg[user_email]">
        <?php if($invoice!=''){ ?>
        <input type="hidden" value="<?php echo $invoice; ?>" name="invoice">
        <?php } ?>
                                      
    </p>
    <?php if($invoice==''){ ?>
    <p class="login-remember"><label><input name="rememberme" onchange="if(this.checked) {jQuery('#inv').slideDown();jQuery('#invn').removeAttr('disabled'); }else{jQuery('#inv').slideUp();jQuery('#invn').attr('disabled','disabled'); }" type="checkbox" id="rememberme" value="forever" tabindex="39" /> I already purchased WPDM Pro.</label></p> 
    <p class="control-group" id="inv" style="display: none;">
    <label class="control-label" for="user_email">Invoice ID</label>
    <input type="text" value="<?php echo $invoice; ?>" id="invn" name="invoice" disabled="disabled"> 
    </p> 
    <?php }?>
    
    <div class="alert alert-info">Password will be mailed to your inbox!</div>
    
     
     
    <input type="hidden" value="" name="redirect_to">
    <p class=""><input type="submit" tabindex="104" value="Join Now!" class="btn btn-success" id="wp-submit" name="wp-submit"></p>
    <p>     <br>
    
          
            
            </p>
</form>
</div>
<script language="JavaScript">
<!--
  jQuery(function(){       
      jQuery('#registerform').validate({
            highlight: function(label) {
            jQuery(label).closest('.control-group').addClass('error');
            },
             success: function(label) {
            label
            .addClass('valid')
            .closest('.control-group').addClass('success');
            }
      });
  });
//-->
</script> 