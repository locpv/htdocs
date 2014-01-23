<?php 
// Get MediaAccess global variable
global $wpalchemy_media_access; 
?>

<div id="ti-album-info" class="ti-metabox">

	<div class="metabox-tabs-div">
	  
	  <ul class="metabox-tabs" id="metabox-tabs">
	  	<li class="active tab1"><a class="active" href="javascript:void(null);"><?php echo __( 'General', 'theme-it' ); ?></a></li>
	  	<li class="tab2"><a href="javascript:void(null);"><?php echo __( 'Tracks', 'theme-it' ); ?></a></li>
	  	<li class="tab3"><a href="javascript:void(null);"><?php echo __( 'Help', 'theme-it' ); ?></a></li>
	  </ul>
	  
	  <div class="tab1">
	  	<h4 class="heading"><?php echo __( 'General', 'theme-it' ); ?></h4>
	  	
	  	<table>
	  		<tr>
	  			<td>
	  				<table>
	  					<tbody>
	  						<tr>
	  						  <td>
										<label><?php echo __( 'Artist Name' , 'theme-it' ); ?></label><br />
										<?php $mb->the_field( 'artist_name' ); ?>
										<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	  						  </td>
	  						  <td>
										<label><?php echo __( 'Album Name' , 'theme-it' ); ?></label><br />
										<?php $mb->the_field( 'album_name' ); ?>
										<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	  						  </td>
	  						</tr>
	  					</tbody>
	  				</table>
						<?php while( $mb->have_fields_and_multi( 'purchase_links' ) ) : ?>
							<?php $mb->the_group_open(); ?>
	  					<table class="form-table">
	  						<tbody>
									<tr>
						  			<td class="w25">
						  			  <label><?php echo __( 'Seller Name' , 'theme-it' ); ?></label><br />
						  			  <?php $mb->the_field( 'seller_name' ); ?>
						  			  <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
						  			</td>
						  			<td class="w50">
						  			  <label><?php echo __( 'Product Link' , 'theme-it' ); ?></label><br />
						  			  <?php $mb->the_field( 'product_link' ); ?>
						  			  <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
						  			</td>
										<td class="w25">
											<div class="textright" style="margin: 5px 0;">
												<label>&nbsp;</label><br />
												<input style="margin-left: 5px; border: none" type="button" class="dodelete deletion right" value="<?php echo __( 'Remove Seller', 'theme-it' ); ?>" />
											</div>
										</td>
									</tr>	  			
	  						</tbody>
	  					</table>
							<?php $mb->the_group_close(); ?>
						<?php endwhile; ?>
	  			</td>
	  		</tr>
	  		<tr>
	  			<td class="textright">
						<input type="button" class="docopy-purchase_links button" value="<?php echo __( 'Add Purchase Link', 'theme-it' ); ?>" onClick="Increment()" />
	  			</td>
	  		</tr>
	  	</table>
	  </div><!-- .tabs1 -->
	 
	  <div class="tab2">
	  	<h4 class="heading"><?php echo __( 'Tracks', 'theme-it' ); ?></h4>

	  	<?php $track_count = 0; ?>
			<?php while( $mb->have_fields_and_multi( 'tracks' ) ) : ?>
				<?php $mb->the_group_open(); ?>
				
				<?php 
				$track_count++;
				if ( $track_count < 10 )
				  $track_count = "0$track_count"; ?>
				 
	  		<table class="form-table">
	  			<tbody>
						<tr>
						  <td class="w33">
						    <label><span class="track-count"><?php echo esc_html( $track_count )  ?>.</span> <?php echo __( 'Track Name' , 'theme-it' ); ?></label><br />
						    <?php $mb->the_field( 'track_name' ); ?>
						    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
						  </td>
							<td class="w33">
								<label><?php echo __( 'Track File URL <span>(MP3)</span>' , 'theme-it' ); ?></label><br />
				  			<?php $mb->the_field( 'track_file' ); ?>
				  			<?php $wpalchemy_media_access->setGroupName( 'n' . $mb->get_the_index() )->setInsertButtonLabel( 'Insert MP3 File' ); ?>
				  			<?php echo $wpalchemy_media_access->getField( array( 'name' => $mb->get_the_name(), 'value' => $mb->get_the_value() ) ); ?>
							</td>
							<td class="w33" style="padding-top: 13px;">
								<br />
								<?php echo $wpalchemy_media_access->getButton( array( 'label' => 'Attach MP3', 'class' => 'left media-access-button' ) ); ?>
								<input style="margin-left: 5px; border: none" type="button" class="dodelete deletion right" value="<?php echo __( 'Remove Track', 'theme-it' ); ?>" />
							</td>
						</tr>
	  			</tbody>
	  		</table>
				<?php $mb->the_group_close(); ?>
			<?php endwhile; ?>
			<table>
				<tfoot>
					<tr>
						<td style="padding-top: 5px;">
							<p class="sort-warning left"><?php _e( 'The order has been changed.', 'theme-it' ) ?> <em><?php _e( 'Don\'t forget to save and update!', 'theme-it' ) ?></em></p>
							<input style="margin: 0 8px" type="button" class="docopy-tracks button right" value="<?php echo __( 'Add Track', 'theme-it' ); ?>" />
						</td>
					</tr>
				</tfoot>
			</table>

	  </div><!-- .tab2 -->
	  
	  <div class="tab3">
	  	<h4 class="heading"><?php echo __( 'Help', 'theme-it' ); ?></h4>
	  	<table class="form-table">
	  		<thead>
	  			<tr>
	  				<td scope="row" colspan="2">
	  					<p><?php echo __( 'The audio info entered in this metabox will be used in various places.', 'theme-it' ); ?></p>
						</td>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<th scope="row"><h4><?php echo __( 'General', 'theme-it' ); ?></h4></th>
	  				<td>
	  					<p><?php echo __( 'This information is simply general information about the album. Each bit on content is used in various places within the website.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Artist Name: ', 'theme-it' ) . '</strong>' . __( 'Enter the name of the artist. This information will be displayed in the audio player.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Album Name: ', 'theme-it' ) . '</strong>' . __( 'Enter the name of the album.  This information will be displayed in the audio player.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Seller Name: ', 'theme-it' ) . '</strong>' . __( 'Enter the Seller Name where users can buy or download the album or tracks. This information is used on Discography Single Pages.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Product Link: ', 'theme-it' ) . '</strong>' . __( 'Enter a URL to the website where users can buy or download the album or tracks. This information is used on to link the Seller Name on Discography Single Pages.', 'theme-it' ); ?></p>
	  					<p><?php echo __( 'Additional purchase links can be added by clicking on the "Add Purchase Links" button. There is no limit to the amount of additional links that can be set. The option to Remove links is available by clicking on the "Remove Seller" link. Links can also be re-ordered by dragging and dropping into place. Remember to update the post after re-ordering the links.', 'theme-it' ); ?></p>
	  				</td>
	  			</tr>
	  			<tr>
	  				<th scope="row"><h4><?php echo __( 'Tracks', 'theme-it' ); ?></h4></th>
	  				<td>
	  					<p><?php echo __( 'For each track, enter in the title of the track along with a URL to an MP3 file. The file MUST be in an MP3 format in order for theme audio players to function properly. For the track, the option to upload and attach the MP3 file can be done by clicking on the "Attach MP3" button. Follow your basic WordPress media upload routine. When the file is uploaded, Choose the "Insert MP3 File" button. ', 'theme-it' ); ?></p>
	  					<p><?php echo __( 'The other option to adding MP3 files is to use a CDN like Amazon or MaxCDN or other storage websites. In the theme demo, we have utilized Dropbox by putting the files in the Public folder and copying their links into the MP3 input field. This is highly encouraged to save your hosting account bandwidth and space. ', 'theme-it' ); ?></p>
	  					<p><?php echo __( 'Additional tracks can be added by clicking on the "Add Track" button. There is no limit to the amount of tracks that can be added, however, for best results, 10 is a good number. The option to remove tracks is available by clicking on the "Remove Track" links. Links can also be re-ordered by dragging and dropping into place. Remember to update the post after re-ordering the links.', 'theme-it' ); ?></p>
	  				</td>
	  			</tr>
	  		</tbody>
	  	</table>
	  </div><!-- .tab3 -->
	
	</div><!-- .metabox-tabs-div -->

</div> <!-- wpalchemy-metabox -->

<style type="text/css">
/* Group Styles */
.wpa_loop .wpa_group {
  cursor: move;
  overflow: hidden;
  border-bottom: 1px dotted #E3E3E3;
  background: url(<?php echo ti_ADMINURL; ?>/images/corner.png) no-repeat;
}
.wpa_loop .wpa_group:nth-child(odd) {
  background-color: #fff;
}
.wpa_loop .wpa_group:hover {
  background-color: #eaf2fb;
}
.wpa_loop .slide-highlight {
  height: 70px;
  border: 3px dashed #E3E3E3;
  background: #f5f5f5;
}
</style>

<script type="text/javascript">
//<![CDATA[
	
	jQuery(function($)
	{
		$("#wpa_loop-tracks").sortable({
			placeholder: 'slide-highlight',
			change: function() {
				$('.sort-warning').fadeIn('slow');
			}
		});
		
		$('.lyric-box').hide();
		$('.add-lyrics').click( function() {
		  $(this).closest('tr').next().find('.lyric-box').toggle('fast');
		});
	})
	
//]]>
</script>


