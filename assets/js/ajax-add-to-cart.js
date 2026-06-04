jQuery(function ($) {
    'use strict';

    /**
     * AJAX Add to Cart for Single Product Page
     */
    /**
     * Handle Form Submit
     */
    $(document).on('submit', 'form.cart', function (e) {
        var $form = $(this),
            $thisbutton = $form.find('.single_add_to_cart_button');

        // Check for Simple or Variable product
        // If it's external, let it go.
        if ($form.hasClass('external-product')) {
            return;
        }

        e.preventDefault();

        $thisbutton.removeClass('added').addClass('loading');

        var formData = $form.serializeArray();

        // Add specific action for WooCommerce
        formData.push({ name: 'add-to-cart', value: $form.find('[name="add-to-cart"]').val() || $thisbutton.val() });

        $.ajax({
            url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
            data: formData,
            type: 'POST',
            success: function (response) {
                $thisbutton.removeClass('loading');

                if (!response) {
                    return;
                }

                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                }

                // Redirect to cart option (if enabled in settings)
                if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                    window.location = wc_add_to_cart_params.cart_url;
                    return;
                }

                // Trigger event so themes can refresh mini-cart
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

                // User Feedback: Add 'View Cart' link if not present
                $thisbutton.addClass('added');

                // Construct View Cart link
                // We assume wc_add_to_cart_params.i18n_view_cart is available or we use hardcoded for now,
                // but ideally we should localize this string.
                // For simplicity in this prompt, I'll use a hardcoded string or try to use what WC provides if available.
                // WC usually provides `wc_add_to_cart_params.i18n_view_cart`.

                if (!$form.find('.added_to_cart').length) {
                    var viewCartText = (typeof wc_add_to_cart_params.i18n_view_cart !== 'undefined') ? wc_add_to_cart_params.i18n_view_cart : 'View cart';
                    var viewCartUrl = wc_add_to_cart_params.cart_url;

                    $thisbutton.after(' <a href="' + viewCartUrl + '" class="added_to_cart wc-forward" title="' + viewCartText + '">' + viewCartText + '</a>');
                }
            },
            error: function () {
                $thisbutton.removeClass('loading');
                // Fallback to reload if error
                // window.location = window.location.href;
            }
        });
    });
});
