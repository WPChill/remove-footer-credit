<div class="col-fulwidth feedback-box">
	<h3>
	    <?php esc_html_e( 'Lend a hand & share your thoughts', 'remove-footer-credit' ); ?>
		<img src="<?php echo $this->assets_path . 'images/handshake.png' ?>"> 
	</h3>
	<p>
	    <?php
	    echo vsprintf(
	      // Translators: 1 is Theme Name, 2 is opening Anchor, 3 is closing.
	      __( 'We\'ve been working hard on making %1$s the best one out there. We\'re interested in hearing your thoughts about %1$s and what we could do to <u>make it even better</u>.<br/> <br/> %2$sHave your say%3$s', 'remove-footer-credit' ),
	      array(
	        'Remove Footer Credit',
	        '<a class="button button-hero" target="_blank" href="http://bit.ly/feedback-remove-footer-credit">',
	        '</a>',
	      )
	    );
	    ?>
	</p>
</div>
<div class="get-help">
	<h3><?php esc_html_e('Get Help', 'remove-footer-credit') ?></h3>
	<p><?php esc_html_e('Need help using this plugin or want to report a bug? Contact me', 'remove-footer-credit') ?> <a href="https://www.machothemes.com/contact-us-now/?utm_source=remove-footer-credit&utm_medium=about-page&utm_campaign=support-button" target="_blank"><?php esc_html_e('here', 'remove-footer-credit') ?></a>.</p>
	<hr>
	<h3><?php esc_html_e('Learn', 'remove-footer-credit') ?></h3>
	<p><a href="https://www.machothemes.com/remove-footer-credit/?utm_source=remove-footer-credit&utm_medium=about-page&utm_campaign=docs-button" target="_blank"><?php esc_html_e('Click here', 'remove-footer-credit') ?></a> <?php esc_html_e('to view instructions on how to use this plugin.', 'remove-footer-credit') ?></p>
</div>