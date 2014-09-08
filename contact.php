<?php

/*

Template Name: Contact sidebar

*/

?>



<?php get_header(); ?>







<div id="mainwrap">

	<div id="main" class="clearfix">

	

		<div class="infotextwrap">

			<div class="infotext">

				<div class="infotextBorderSingle"></div>

					<h1><?php the_title();?></h1>

					<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>

				<div class="infotextBorderSingle"></div>

			</div>

		</div>	



		

		<div class="content contact">

				<div class="postcontent">

					<div class="posttext">

			

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>		

						

						

						<?php the_content(); ?>

							

					

						<?php endwhile; endif; ?>

						

						<form method="post" id="contatti" action="<?php echo get_template_directory_uri(); ?>/sendemail.php"> 

							<div id="contactform"> 



								<div class="commentfield">							

								<label for="author"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_contact_name']); } else {  _e('Name','wp-emporium'); } ?><small> (<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_comment_required']); } else {  _e('required','wp-emporium'); } ?>)</small></label>							

								<input type="text" name="name" id="name" />						

								</div>

								<div class="commentfield">							

								<label for="email"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_contact_email']); } else {  _e('Email','wp-emporium'); } ?><small> (<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_comment_required']); } else {  _e('required','wp-emporium'); } ?>)</small></label>							

								<input type="text" name="email" id="email" /> 													

								</div>

								<div class="commentfield">									

								<label for="message"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_contact_message']); } else {  _e('Message','wp-emporium'); } ?><small> (<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_comment_required']); } else {  _e('required','wp-emporium'); } ?>)</small></label>

								<div class="commentfieldarea"><textarea name="message" id="testo" rows="12" cols="" ></textarea>	

								</div>

								</div>

								<input type="hidden" name="errorM" id="errorM" value="<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['contacterror']); } else {  _e('Error while sending mail.','wp-emporium'); } ?><?php echo stripText($data['contacterror']) ?>" />

								<input type="hidden" name="successM" id="successM" value="<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['contactsuccess']); } else {  _e('Success','wp-emporium'); } ?><?php echo stripText($data['contactsuccess']) ?>" />

								<input type="hidden" name="mailto" id="mailto" value="<?php echo stripText($data['contactemail']) ?>" />

								<div class="contactbutton"> 

									<input type="submit" class="contact-button" name="submit" id="invia" value="<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_contact_send']); } else {  _e('Send','wp-emporium'); } ?>"/>

									<input type="reset" class="contact-button" name="clear" value="<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_contact_clear']); } else {  _e('Clear','wp-emporium'); } ?>"/>

								</div>

								<span id="result"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['contacterror']); } else {  _e('Error while sending mail.','wp-emporium'); } ?></span>

								<span id="resultsuccess"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['contactsuccess']); } else {  _e('Success','wp-emporium'); } ?></span>

							</div> 

						</form> 

					</div>

				</div>

			</div>



<?php //get_sidebar(); ?>

</div>

</div>

<?php get_footer(); ?>

