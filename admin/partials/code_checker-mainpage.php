<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Code_checker
 * @subpackage Code_checker/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h3>General Settings</h3>
<hr>

<div class="code_checker_wrap">
    <div id="code_checker_opt_tbl">
    <?php
    echo '<form action="options.php" method="post" id="code_checker_settings_section">';
    echo '<table class="widefat">';
    settings_fields( 'code_checker_settings_section' );
    do_settings_fields( 'code_checker_settings_page', 'code_checker_settings_section' );
    echo '<tr><th>Reset counter</th><td><strong><button id="counter-reset" class="button-secondary">Reset</button></strong></td><tr>';
    echo '<tr><th>Output</th><td><strong>[code_checker]</strong></td><tr>';
    echo '<tr><th>Counter</th><td><strong>[check_counter]</strong></td><tr>';
    echo '</table>';
    submit_button();
    echo '</form>';
    ?>
    </div>
</div>
