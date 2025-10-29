<?php

/**
 * Provide a public-facing view for the plugin
 * @link       https://github.com/amanwebexp/
 * @since      1.0.0
 * @package    Ims_Countdown
 * @subpackage Ims_Countdown/public/partials
 */

$atts = shortcode_atts(array('id' => '0'), $atts);
$post_id = absint($atts['id']);
$args = array('post_type' => 'ims_countdown', 'p' => $post_id);
$query = new WP_Query($args);

if ($query->have_posts()) {
    $query->the_post();

    // Get timezone from settings or default to UTC
    $getTimezone = get_option('imsc_timezone', 'UTC');
    $timezone = new DateTimeZone($getTimezone);
    $date = new DateTime();
    $date->setTimezone($timezone);
    $timetest = $date->format('Y-m-d H:i:s');

    // Countdown settings
    $multiCountDown = "countdown" . get_the_ID();
    $countdown_type = get_post_meta(get_the_ID(), 'countdown_type', true);
    $countdown_value = get_post_meta(get_the_ID(), 'countdown_value', true);
    $ds = intval(get_post_meta(get_the_ID(), 'ds', true));
    $hr = intval(get_post_meta(get_the_ID(), 'hr', true));
    $mn = intval(get_post_meta(get_the_ID(), 'mn', true));
    $sc = intval(get_post_meta(get_the_ID(), 'sc', true));
    $timeGap = ($ds * 86400) + ($hr * 3600) + ($mn * 60) + $sc;
    $expire_action = intval(get_post_meta(get_the_ID(), 'expire_action', true));
    $redirect_url = esc_url(get_post_meta(get_the_ID(), 'redirect_url', true));
    $theme = sanitize_text_field(get_post_meta(get_the_ID(), 'theme', true));
    $font_face = sanitize_text_field(get_post_meta(get_the_ID(), 'font_face', true));
    $title_color = sanitize_hex_color(get_post_meta(get_the_ID(), 'title_color', true));
    $timer_color = sanitize_hex_color(get_post_meta(get_the_ID(), 'timer_color', true));
    $timer_background = sanitize_hex_color(get_post_meta(get_the_ID(), 'timer_background', true));
    $timer_border = sanitize_hex_color(get_post_meta(get_the_ID(), 'timer_border', true));
    $hide_title = get_post_meta(get_the_ID(), 'hide_title', true);

    // Override theme styles
    switch ($theme) {
        case 'black':
            $title_color = "#2a2a2a";
            $timer_color = "#ffffff";
            $timer_background = "#2a2a2a";
            $timer_border = "#494949";
            break;
        case 'white':
            $title_color = "#2a2a2a";
            $timer_color = "#333333";
            $timer_background = "#FCFCFC";
            $timer_border = "#d3d3d3";
            break;
        case 'gold':
            $title_color = "#8c6047";
            $timer_color = "#8c6047";
            $timer_background = "#fcdc88";
            $timer_border = "#9e887c";
            break;
        case 'red':
            $title_color = "#db4742";
            $timer_color = "#ffffff";
            $timer_background = "#fc544e";
            $timer_border = "#db4742";
            break;
    }

    $days = esc_html(get_post_meta(get_the_ID(), 'days', true) ?: "Days");
    $hours = esc_html(get_post_meta(get_the_ID(), 'hours', true) ?: "Hours");
    $minutes = esc_html(get_post_meta(get_the_ID(), 'minutes', true) ?: "Minutes");
    $seconds = esc_html(get_post_meta(get_the_ID(), 'seconds', true) ?: "Seconds");
    // Calculate the time difference
    $currentTime = new DateTime($timetest);
    $countdownTime = DateTime::createFromFormat('Y/m/d H:i', $countdown_value);
    $interval = $currentTime->diff($countdownTime);
    $timeValue = ($countdown_type == 2) ? strtotime($countdown_value) - $currentTime->getTimestamp() : $timeGap;
    $fontFace = str_replace("+", " ", $font_face);
    $fontUrl = "https://fonts.googleapis.com/css?family=" . esc_attr($fontFace);
    wp_enqueue_style('imsc_googleapis', $fontUrl);
    wp_enqueue_style('imsc_custom', plugin_dir_url(dirname(__FILE__)) . 'css/custom.css');
    // Custom styles
    $custom_css = "
        .$multiCountDown #note div {
            color: $timer_color !important;
            background-color: $timer_background !important;
            border-color: $timer_border !important;
        }
        .$multiCountDown .countDownTitle,
        .$multiCountDown div span {
            font-family: '$fontFace', sans-serif !important;
        }
        .$multiCountDown .countDownTitle {
            color: $title_color !important;
        }
    ";
    wp_add_inline_style('imsc_custom', $custom_css);

    // Output HTML
    echo "<div class='" . esc_attr($multiCountDown) . "'>";
    if ($hide_title != 1) {
        echo "<p class='countDownTitle'>" . esc_html(get_the_title()) . "</p>";
    }
?>
    <div id="note"></div>
    <div style="display:none;" class="expireContent"><?php echo wp_kses_post(get_the_content()); ?></div>
    </div>
<?php
    // Embed inline JS securely
    $expireActionJS = '';
    switch ($expire_action) {
        case 0:
            $expireActionJS = "function onExpiry_$post_id() { console.log('Countdown expired - no action'); }";
            break;
        case 1:
            $expireActionJS = "function onExpiry_$post_id() {
                jQuery('.$multiCountDown .expireContent').fadeIn();
                jQuery('.$multiCountDown #note').remove();
            }";
            break;
        case 2:
            $expireActionJS = "function onExpiry_$post_id() {
                jQuery('.$multiCountDown').remove();
            }";
            break;
        case 3:
            $expireActionJS = "function onExpiry_$post_id() {
                window.location.replace('" . esc_url($redirect_url) . "');
            }";
            break;
    }

    $layout = " <div><span>{dn}</span> " . esc_js($days) . " </div>" .
        "<div><span>{hn}</span> " . esc_js($hours) . " </div>" .
        "<div><span>{mn}</span> " . esc_js($minutes) . " </div>" .
        "<div><span>{sn}</span> " . esc_js($seconds) . " </div>";

    $inline_js = "
            jQuery(document).ready(function() {
                $expireActionJS
                jQuery('.$multiCountDown #note').countdown({
                    until: $timeValue,
                    onExpiry: onExpiry_$post_id,
                    padZeroes: true,
                    format: 'DHMS',
                    layout: '$layout'
                });
            });
        ";
    wp_add_inline_script('imsc_custom', $inline_js);
}
?>