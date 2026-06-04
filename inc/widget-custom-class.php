<?php
/**
 * Add custom class field to widgets.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add input field to widget form.
 *
 * @param array     $t The widget instance.
 * @param string|null $return Not used.
 * @param object    $instance The widget instance.
 */
function in_widget_form($t, $return, $instance)
{
    $instance = wp_parse_args((array) $instance, array('classes' => ''));

    if (!isset($instance['classes'])) {
        $instance['classes'] = '';
    }
    ?>
    <p>
        <label for="<?php echo esc_attr($t->get_field_id('classes')); ?>">
            <?php esc_html_e('Custom Class:', 'brainworks'); ?>
        </label>
        <input class="widefat" id="<?php echo esc_attr($t->get_field_id('classes')); ?>"
            name="<?php echo esc_attr($t->get_field_name('classes')); ?>" type="text"
            value="<?php echo esc_attr($instance['classes']); ?>" />
    </p>
    <?php
}

add_action('in_widget_form', 'in_widget_form', 10, 3);

/**
 * Save custom class.
 *
 * @param array     $instance The widget instance.
 * @param array     $new_instance The new widget instance.
 * @param array     $old_instance The old widget instance.
 * @param object    $this_widget The widget object.
 *
 * @return array The updated instance.
 */
function widget_update_callback($instance, $new_instance, $old_instance, $this_widget)
{
    $instance['classes'] = isset($new_instance['classes']) ? sanitize_text_field($new_instance['classes']) : '';
    return $instance;
}

add_filter('widget_update_callback', 'widget_update_callback', 10, 4);

/**
 * Add custom class to widget wrapper.
 *
 * @param array $params The sidebar params.
 *
 * @return array The updated params.
 */
function dynamic_sidebar_params($params)
{
    global $wp_registered_widgets;

    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];

    if (isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes'])) {
        $params[0]['before_widget'] = preg_replace('/class="/', 'class="' . esc_attr($widget_opt[$widget_num]['classes']) . ' ', $params[0]['before_widget'], 1);
    }

    return $params;
}

add_filter('dynamic_sidebar_params', 'dynamic_sidebar_params');
