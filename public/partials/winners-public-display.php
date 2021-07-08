<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Winners
 * @subpackage Winners/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="winners_check__code">
    <div class="win__alerts">
        <?php
        if(!empty(get_option('winners_input_box_headline'))){
            echo '<h5>'.__(get_option('winners_input_box_headline'), $this->plugin_name).'</h5>';
        }
        ?>
        
        <div class="progress">
            <!-- Alert shows here -->
        </div>
    </div>
    <div class="input">
        <input type="text" placeholder="My code" id="win__mycode">
        <button class="win__send button-secondary">Check</button>
    </div>
</div>