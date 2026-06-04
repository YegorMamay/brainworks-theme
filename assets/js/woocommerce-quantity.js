jQuery(function ($) {
    'use strict';

    if (!String.prototype.getDecimals) {
        String.prototype.getDecimals = function () {
            var num = this,
                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            if (!match) {
                return 0;
            }
            return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
        };
    }

    function BrainworksQuantity() {
        // Target quantity inputs on product pages and cart
        $(document).on('click', '.quantity .minus, .quantity .plus', function (e) {
            // Get values
            var $qtyBtn = $(this),
                $qtyInput = $qtyBtn.closest('.quantity').find('.qty'),
                currentVal = parseFloat($qtyInput.val()),
                max = parseFloat($qtyInput.attr('max')),
                min = parseFloat($qtyInput.attr('min')),
                step = $qtyInput.attr('step');

            // Format values
            if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
            if (max === '' || max === 'NaN') max = '';
            if (min === '' || min === 'NaN') min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

            // Change the value
            if ($qtyBtn.is('.plus')) {
                if (max && (currentVal >= max)) {
                    $qtyInput.val(max);
                } else {
                    $qtyInput.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
                }
            } else {
                if (min && (currentVal <= min)) {
                    $qtyInput.val(min);
                } else if (currentVal > 0) {
                    $qtyInput.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
                }
            }

            // Trigger change event
            $qtyInput.trigger('change');
            e.preventDefault();
        });

        // Add buttons
        this.init = function () {
            // Ensure we don't add buttons twice
            $('.quantity button').remove();

            $('.quantity').each(function () {
                var $qty = $(this);
                // Check if hidden or already has buttons (though we removed them above for safety re-init)
                // Also check if input is strictly number type
                var $input = $qty.find('input[type="number"]');

                if ($input.length) {
                    $input.before('<button type="button" class="minus">-</button>');
                    $input.after('<button type="button" class="plus">+</button>');
                }
            });
        };

        this.init();
    }

    var brainworksQuantity = new BrainworksQuantity();

    // Re-init on cart update (WooCommerce triggers 'updated_wc_div')
    $(document.body).on('updated_wc_div', function () {
        brainworksQuantity.init();
    });

    // Also try to help with quick view or ajax loaded content if possible
    $(document).on('ajaxComplete', function () {
        setTimeout(function () {
            // Basic check to ensure we add buttons if they are missing
            if ($('.quantity:not(:has(.minus))').find('input[type="number"]').length) {
                brainworksQuantity.init();
            }
        }, 100);
    });

});
