<div id="wrap">
    <h1>Grizzly Bear Design Options Page</h1>
	<form method="post" action="options.php">
		<?php
			settings_fields( 'gt-cpt-settings' );
			do_settings_sections( 'gt-cpt-settings' );
			submit_button();
		?>
	</form>
</div>