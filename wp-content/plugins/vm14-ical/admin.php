<div class="wrap">
    <h2>ICS endpoint settings</h2>

    <form method="post" action="options.php">
        <?php settings_fields('vm14-ics');?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Calendar Title</th>
                <td><input type="text" name="vm14_ics_cal_title" value="<?php echo get_option('vm14_ics_cal_title'); ?>" /></td>
            </tr>
             
            <tr valign="top">
                <th scope="row">Calendar Description</th>
                <td><input type="text" name="vm14_ics_cal_description" value="<?php echo get_option('vm14_ics_cal_description'); ?>" /></td>
            </tr>
        </table>
    
    <?php submit_button(); ?>
    </form>
</div>
