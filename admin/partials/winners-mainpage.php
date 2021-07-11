<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Winners
 * @subpackage Winners/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h3>General Settings</h3>
<hr>

<div class="winners_wrap">
    <div id="winners_opt_tbl">
    
    <?php
    echo '<form action="options.php" method="post" id="winners_settings_section">';
    echo '<table class="widefat">';

    settings_fields( 'winners_settings_section' );
    do_settings_fields( 'winners_settings_page', 'winners_settings_section' );
    echo '<tr><th>Output</th><td><strong>[winners]</strong></td><tr>';
    echo '</table>';
    submit_button();
    echo '</form>';
    ?>
    </div>
</div>
