<div class="options-group">
    <div class="option">
        <div class="option-heading">
            <h4 class="option-title">Countdown Type</h4>
        </div>
        <div class="option-body">
            <!-- Fixed Time Option -->
            <div class="dropdown">
                <label class="label" for="2">Fixed Time</label>
                <input class="labelvalue" type="radio" <?php echo $checked; ?>name="countdown_type" id="2" value="2" <?php checked($countdown_type, '2'); ?>>
                <div class="clear"></div>
                <div class="display-none time-options">
                    <label class="label">Select Date</label>
                    <input class="labelvalue" id="event_date" name="countdown_value" value="<?php echo esc_attr($countdown_value); ?>" />
                    <div class="clear"></div>
                </div>
            </div>

            <!-- Evergreen Option -->
            <div class="dropdown">
                <label class="label" for="0">Evergreen</label>
                <input class="labelvalue" type="radio" name="countdown_type" id="0" value="0" <?php checked($countdown_type, '0'); ?>>
                <div class="clear"></div>
                <div class="display-none time-options">
                    <label class="label" for="0">Days</label>
                    <input class="labelvalue" type="number" min="0" value="<?php echo esc_attr($ds); ?>" placeholder="0" name="ds">
                    <div class="clear"></div>
                    <label class="label" for="0">Hours</label>
                    <input class="labelvalue" type="number" min="0" value="<?php echo esc_attr($hr); ?>" placeholder="0" name="hr">
                    <div class="clear"></div>
                    <label class="label" for="0">Minutes</label>
                    <input class="labelvalue" type="number" min="0" value="<?php echo esc_attr($mn); ?>" placeholder="0" name="mn">
                    <div class="clear"></div>
                    <label class="label" for="0">Seconds</label>
                    <input class="labelvalue" type="number" min="0" value="<?php echo esc_attr($sc); ?>" placeholder="0" name="sc">
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="option">
        <div class="option-heading">
            <h4 class="option-title">Countdown Expire Action</h4>
        </div>
        <div class="option-body">
            <label class="label" for="action-0">Do Nothing</label>
            <input class="labelvalue" type="radio" name="expire_action" <?php echo $checked; ?> id="action-0" value="0" <?php checked($expire_action, '0'); ?>>
            <div class="clear"></div>
            <label class="label" for="action-1">Show Content</label>
            <input class="labelvalue" type="radio" name="expire_action" id="action-1" value="1" <?php checked($expire_action, '1'); ?>>
            <div class="clear"></div>
            <label class="label" for="action-2">Hide Countdown</label>
            <input class="labelvalue" type="radio" name="expire_action" id="action-2" value="2" <?php checked($expire_action, '2'); ?>>
            <div class="clear"></div>
            <label class="label" for="action-3">Redirect To URL</label>
            <input class="labelvalue" type="radio" name="expire_action" id="action-3" value="3" <?php checked($expire_action, '3'); ?>>
            <br>
            <input type="text" class="labelvalue" placeholder="Redirection URL" value="<?php echo  esc_url($redirect_url); ?>" name="redirect_url" />
            <div class="clear"></div>
        </div>
    </div>

    <div class="option">
        <div class="option-heading">
            <h4 class="option-title">Countdown Style</h4>
        </div>
        <div class="option-body">
            <!-- Hide Title Option -->
            <label class="label hide_title" for="hide_title">Hide Title</label>
            <input class="labelvalue" type="checkbox" name="hide_title" id="hide_title" value="1" <?php checked($hide_title, '1'); ?>>
            <div class="clear"></div>

            <!-- Title Color -->
            <label class="label" for="title_color">Title Color</label>
            <input type="text" value="<?php echo esc_attr($title_color); ?>" name="title_color" class="labelvalue" id="title_color" />
            <div class="clear"></div>

            <!-- Timer Color -->
            <label class="label" for="timer_color">Timer Color</label>
            <input type="text" value="<?php echo esc_attr($timer_color); ?>" name="timer_color" class="labelvalue" id="timer_color" />
            <div class="clear"></div>

            <!-- Timer Background -->
            <label class="label" for="timer_background">Timer Background</label>
            <input type="text" value="<?php echo esc_attr($timer_background); ?>" name="timer_background" class="labelvalue" id="timer_background" />
            <div class="clear"></div>

            <!-- Timer Border -->
            <label class="label" for="timer_border">Timer Border</label>
            <input type="text" value="<?php echo esc_attr($timer_border); ?>" name="timer_border" class="labelvalue" id="timer_border" />
            <div class="clear"></div>

            <!-- Timer Font -->
            <label class="label" for="font_face">Timer Font</label>
            <select name="font_face" id="font_face" class="labelvalue">
                <?php
                foreach ($imsc_config_fonts as $key => $value) {
                    $select_font = ($font_face == $key) ? " selected" : "";
                    echo "<option{$select_font} value='{$key}'>{$value}</option>";
                }
                ?>
            </select>
            <div class="clear"></div>

            <!-- Timer Themes -->
            <label class="label" for="theme">Timer Themes</label>
            <select name="theme" class="labelvalue">
                <option value="custom" <?php selected($theme, 'custom'); ?>>Custom Theme</option>
                <option value="black" <?php selected($theme, 'black'); ?>>Black</option>
                <option value="white" <?php selected($theme, 'white'); ?>>White</option>
                <option value="gold" <?php selected($theme, 'gold'); ?>>Gold</option>
                <option value="red" <?php selected($theme, 'red'); ?>>Red</option>
            </select>
            <div class="clear"></div>
        </div>
    </div>

    <div class="option">
        <div class="option-heading">
            <h4 class="option-title">Countdown Language</h4>
        </div>
        <div class="option-body">
            <!-- Countdown Language Labels -->
            <label class="label" for="days">Days</label>
            <input type="text" class="labelvalue" value="<?php echo esc_attr($days); ?>" name="days" id="days" />
            <div class="clear"></div>

            <label class="label" for="hours">Hours</label>
            <input type="text" class="labelvalue" value="<?php echo esc_attr($hours); ?>" name="hours" id="hours" />
            <div class="clear"></div>

            <label class="label" for="minutes">Minutes</label>
            <input type="text" class="labelvalue" value="<?php echo esc_attr($minutes); ?>" name="minutes" id="minutes" />
            <div class="clear"></div>

            <label class="label" for="seconds">Seconds</label>
            <input type="text" class="labelvalue" value="<?php echo esc_attr($seconds); ?>" name="seconds" id="seconds" />
            <div class="clear"></div>
        </div>
    </div>

    <div class="option">
        <div class="option-heading">
            <h4 class="option-title">Shortcode</h4>
        </div>
        <div class="option-body">
            <label class="label">[displayCountdowns id="<?php echo esc_attr($post->ID); ?>"]</label>
            <div class="clear"></div>
        </div>
    </div>

    <!-- Nonce field for CSRF protection -->
    <?php wp_nonce_field('countdown_options_nonce', 'countdown_options_nonce_field'); ?>
</div>