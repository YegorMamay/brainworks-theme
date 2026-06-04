<?php
/**
 * Admin Term Image
 * Adds a "Social Cover Image" field to Category (post, product) edit screens.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Media Scripts
 */
/**
 * Enqueue Media Scripts
 */
function brainworks_admin_term_image_enqueue()
{
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'brainworks_admin_term_image_enqueue');

/**
 * Inline Scripts for Media Uploader
 */
function brainworks_admin_term_image_scripts()
{
    $screen = get_current_screen();
    if (!$screen || !in_array($screen->base, array('term', 'edit-tags'))) {
        return;
    }

    // Simple inline JS to handle the image upload
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var brainworks_image_frame;
            // Runs when the image button is clicked.
            $('.brainworks-upload-image-btn').click(function (e) {
                e.preventDefault();
                // If the frame already exists, re-open it.
                if (brainworks_image_frame) {
                    brainworks_image_frame.open();
                    return;
                }
                // Sets up the media library frame
                brainworks_image_frame = wp.media.frames.brainworks_image_frame = wp.media({
                    title: '<?php _e('Select Social Cover Image', 'brainworks'); ?>',
                    button: { text: '<?php _e('Use this image', 'brainworks'); ?>' },
                    library: { type: 'image' }
                });
                // Runs when an image is selected.
                brainworks_image_frame.on('select', function () {
                    var media_attachment = brainworks_image_frame.state().get('selection').first().toJSON();
                    $('#brainworks-social-image-id').val(media_attachment.id);
                    $('#brainworks-social-image-preview').attr('src', media_attachment.url).show();
                    $('.brainworks-remove-image-btn').show();
                });
                // Opens the media library frame.
                brainworks_image_frame.open();
            });

            // Runs when the remove button is clicked.
            $('.brainworks-remove-image-btn').click(function (e) {
                e.preventDefault();
                $('#brainworks-social-image-id').val('');
                $('#brainworks-social-image-preview').attr('src', '').hide();
                $(this).hide();
            });
        });
    </script>
    <style>
        .brainworks-term-image-wrap img {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 10px 0;
            border: 1px solid #ddd;
            padding: 4px;
            background: #fff;
        }
    </style>
    <?php
}
add_action('admin_footer', 'brainworks_admin_term_image_scripts');

/**
 * Add form field (Add New Category)
 */
function brainworks_add_social_image_field($taxonomy)
{
    ?>
    <div class="form-field term-group">
        <label for="brainworks-social-image-id">
            <?php _e('Social Cover Image', 'brainworks'); ?>
        </label>
        <input type="hidden" id="brainworks-social-image-id" name="brainworks_social_image_id" value="">
        <div class="brainworks-term-image-wrap">
            <img id="brainworks-social-image-preview" src="" style="display:none;">
            <button type="button" class="button brainworks-upload-image-btn">
                <?php _e('Upload/Add Image', 'brainworks'); ?>
            </button>
            <button type="button" class="button brainworks-remove-image-btn" style="display:none;">
                <?php _e('Remove Image', 'brainworks'); ?>
            </button>
        </div>
        <p class="description">
            <?php _e('Image for social networks (Open Graph). Recommended size: 1200x630px.', 'brainworks'); ?>
        </p>
    </div>
    <?php
}
add_action('category_add_form_fields', 'brainworks_add_social_image_field', 10, 2);
add_action('product_cat_add_form_fields', 'brainworks_add_social_image_field', 10, 2);

/**
 * Edit form field (Edit Category)
 */
function brainworks_edit_social_image_field($term, $taxonomy)
{
    $image_id = get_term_meta($term->term_id, 'brainworks_social_image_id', true);
    $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="brainworks-social-image-id">
                <?php _e('Social Cover Image', 'brainworks'); ?>
            </label></th>
        <td>
            <input type="hidden" id="brainworks-social-image-id" name="brainworks_social_image_id"
                value="<?php echo esc_attr($image_id); ?>">
            <div class="brainworks-term-image-wrap">
                <img id="brainworks-social-image-preview" src="<?php echo esc_url($image_url); ?>"
                    style="<?php echo $image_url ? '' : 'display:none;'; ?>">
                <button type="button" class="button brainworks-upload-image-btn">
                    <?php _e('Upload/Add Image', 'brainworks'); ?>
                </button>
                <button type="button" class="button brainworks-remove-image-btn"
                    style="<?php echo $image_url ? '' : 'display:none;'; ?>">
                    <?php _e('Remove Image', 'brainworks'); ?>
                </button>
            </div>
            <p class="description">
                <?php _e('Image for social networks (Open Graph). Recommended size: 1200x630px.', 'brainworks'); ?>
            </p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'brainworks_edit_social_image_field', 10, 2);
add_action('product_cat_edit_form_fields', 'brainworks_edit_social_image_field', 10, 2);

/**
 * Save Term Meta
 */
function brainworks_save_social_image_field($term_id)
{
    if (isset($_POST['brainworks_social_image_id'])) {
        update_term_meta($term_id, 'brainworks_social_image_id', absint($_POST['brainworks_social_image_id']));
    }
}
add_action('created_category', 'brainworks_save_social_image_field', 10, 2);
add_action('edited_category', 'brainworks_save_social_image_field', 10, 2);
add_action('created_product_cat', 'brainworks_save_social_image_field', 10, 2);
add_action('edited_product_cat', 'brainworks_save_social_image_field', 10, 2);
