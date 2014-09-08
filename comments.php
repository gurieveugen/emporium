<?php
	global $data,$sitepress;
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div class = "specificComment" id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?><br>
		<div class = "commentsDate"> <?php printf('%1$s at %2$s', get_comment_date(),  get_comment_time()) ?><?php edit_comment_link('(Edit)','  ','') ?></div>
      </div>
	 
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php echo 'Your comment is awaiting moderation.' ?></em>
         <br />
      <?php endif; ?>

	  <div class="avatar"><?php echo get_avatar( $comment->comment_author_email, 70 ); ?></div>
      <div class="commenttext"><?php comment_text() ?></div>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>	 
     </div>

<?php
        }	
?>

<!-- You can start editing here. -->
	<?php 
		$no_comments = get_comments_number( $post->ID );
		$comment_0  = $comment_1 = $comment_2 = '';
		if($no_comments == 0){
			if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $comment_0 = stripText($data['translation_comment_no_responce']); } else {  $comment_0 = __('No Responses','wp-emporium'); } 
		}
		else if($no_comments == 1){
			if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $comment_1 = stripText($data['translation_comment_one_comment']); } else {  $comment_1 = __('One Response','wp-emporium'); } 
		}
		else{
			if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $comment_2 = stripText($data['translation_comment_max_comment']); } else {  $comment_2 = __('Responses','wp-emporium'); } 
		}
		
		$cancel_reply_link = translation('translation_comment_leave_replay_cancle', 'Cancle Replay'); 	
		
		if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { 
			$title_reply_to = stripText($data['translation_comment_leave_replay_to']); 			
			$label_submit = stripText($data['translation_comment_leave_replay']); 		
			$translation_comment_website = stripText($data['translation_comment_website']); 	
			$translation_comment_required = stripText($data['translation_comment_required']); 	
			$translation_comment_mail = stripText($data['translation_comment_mail']); 	
			$translation_comment_name = stripText($data['translation_comment_name']); 		
			$translation_comment_closed = stripText($data['translation_comment_closed']); 			
			} 
		else {  
			$title_reply_to = __('Leave a Reply to','wp-emporium'); 	
			$label_submit = __('Leave a Reply','wp-emporium'); 	
			$translation_comment_website = __('Website','wp-emporium'); 	
			$translation_comment_required = __('required','wp-emporium');
			$translation_comment_mail = __('Mail','wp-emporium'); 
			$translation_comment_name = __('Name','wp-emporium');  	
			$translation_comment_closed = __('Comments are closed.','wp-emporium');  				
		} 
	?>
	
<?php if ( have_comments() ) : ?>
	


	<ol class="commentlist">	
	<div class="commenttitle">		
	<h3 id="comments"><?php comments_number($comment_0, $comment_1, '<span>% </span>'. $comment_2 );?> 
	<?php echo stripText(isset($data['translation_comment_so_far'])); ?></h3>	
	</div>
	<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	</ol>

	<div class="commentnav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php echo $translation_comment_closed; ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<?php $aria_req = ''; $post_id = ''; $defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
    'author' => '<div class="commentfield">' .
                '<label for="author">' . $translation_comment_name . '' .
				( $req ? ' <small>('.$translation_comment_required .')</small>' : '' ) .
                '</label><br><input id="author" name="author" type="text" value="' .
                esc_attr( $commenter['comment_author'] ) . '"  tabindex="1"' . $aria_req . ' />' .
                '</div>',
    'email'  => '<div class="commentfield">' .
                '<label for="email">' . $translation_comment_mail . '' .
                ( $req ? ' <small>('.$translation_comment_required .')</small>' : '' ) .
                '</label> <br><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"tabindex="2"' . $aria_req . ' />' .
                '</div>',
    'url'    => '<div class="commentfield">' .
                '<label for="url">' . $translation_comment_website . '</label>' .
                '<br><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  tabindex="3" />' .
                '</div>' ) ),
    'comment_field' => '' .
                '<div>' .
                '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
                '</div>',
    'must_log_in' => '
<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ,'wp-emporium'), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>

',
    'logged_in_as' => '
<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%s">%s</a>. <a title="Log out of this account" href="%s">Log out?</a></p>

' ,'wp-emporium'), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
    'comment_notes_before' => '',
    'comment_notes_after' => '',
    'id_form' => 'commentform',
    'id_submit' => 'submit',
    'title_reply' => '',
    'title_reply_to' => $title_reply_to,
    'cancel_reply_link' => $cancel_reply_link,
    'label_submit' => $label_submit,
	
	
); ?>
<div id="commentform">
<h3><?php echo $label_submit ?></h3>
<?php comment_form($defaults); ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
