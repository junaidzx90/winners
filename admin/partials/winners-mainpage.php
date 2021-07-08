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

    echo '</table>';
    submit_button();
    echo '</form>';
    ?>
    </div>

    <div class="users_list">
        <div class="winners_users">
            <table id="winners_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Id</th>
                        <th>User Name</th>
                        <th>Code</th>
                        <th>Position</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    global $wpdb;
                    $user_list = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}winners_list ORDER BY position DESC");

                    if($user_list){
                        $i = 1;
                        foreach($user_list as $winuser){
                            $user_name = get_user_by( 'ID', $winuser->user_id )->display_name;
                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.intval($winuser->user_id).'</td>';
                            echo '<td>'.ucfirst($user_name).'</td>';
                            echo '<td>'.$winuser->code.'</td>';
                            echo '<td>'.$winuser->position.'</td>';
                            echo '<td>'.$winuser->create_date.'</td>';
                            echo '</tr>';
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
