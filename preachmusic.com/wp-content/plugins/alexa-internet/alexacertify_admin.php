<?php
//must check that the user has the required capability 
if (!current_user_can('manage_options')) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
}
$formAction = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
?>

<?php if (!empty($this->updated)): ?>
    <div class="updated"><?= implode("<br />\n", $this->updated) ?></div>
<?php endif;?>   

<?php if (!empty($this->errors)): ?>
    <div class="error"><?= implode("<br />\n", $this->errors) ?></div>
<?php endif; ?>

<div class="wrap">
    <h2> The Official Alexa WordPress Plugin </h2>

	<form name="alexacertify_form" method="post" action="<?php echo $formAction ?>">
        <input type="hidden" name="alexacertify_submit" value="Y"/>
        
        <h3> Claim Your Site </h3>
        <p>
            To claim your site on Alexa, enter your verification ID below and then press the "Verify my ID" button at 
            <a href="http://www.alexa.com/" target="_blank">Alexa.com</a>.
            <br/>
            If you need a verification ID, please visit Alexa's 
            <a href="http://www.alexa.com/siteowners/claim" target="_blank">Claim Your Site</a> page.
        </p>    
	    <p>
	        Verification ID:
            <br/>
	        <input type="text" name="alexacertify_verify" value="<?= htmlspecialchars($this->verify_tag) ?>" size="40">
            <br/>
            example: kbgNFC70SGDf0pmgwT0VGoKlRtI
        </p>
        
        <br/>
        <h3>
            Certified Site Metrics
        </h3>
        <p>
            Alexa Pro customers have the opportunity to have their website traffic
            Certified by Alexa. To learn more, visit Alexa's 
            <a href="http://www.alexa.com/siteowners/certify" target="_blank">Certified Site Metrics</a> page.
	        <br/>
	        If you are an Alexa Pro customer, paste your Certify Code into the box
	        below and the Certification process will begin shortly.
        </p>    
        <p>
	        Certify Code:
            <br />
            <textarea name="alexacertify_certify" style="width: 80%; height: 8em;"><?= htmlspecialchars($this->certify_snippet) ?></textarea>
        </p>
        <p class="submit">  
           <input type="submit" name="Submit" value="Update Options" />  
        </p>
    </form>
</div>
