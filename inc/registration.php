<?php
    $user = wp_get_current_user();
    $user_info = get_userdata( $user->ID );
?>
<div class="nscs-auth nscs-auth-container">

    <div class="nscs-auth__bg nscs-auth__bg--registration"></div>

    <div class="nscs-auth__content nscs-auth__content--registration">

        <?php
            $auth_title = "Complete Payment";
            include('auth-header.php')
        ?>

        <form id="nscs-auth__registration-form">

            <div class="nscs-auth__constrict">
                <div class="nscs-auth__message"></div>
            </div>

            <div class="nscs-auth__registration-step nscs-auth__registration-step--active" data-step="1">

                <div class="nscs-auth__constrict">
                    <div class="nscs-auth__amount">
                        Total Amount
                        <div class="nscs-amount">$95</div>
                    </div>

                    <div class="nscs-auth__cardinfo">
                        <div class="input-group">
                            <label for="card_owner">Name on Card</label>
                            <input type="text" name="card_owner" id="card_owner" placeholder="For e.g. “Mark Smith”" required>
                        </div>
                        <div class="input-group">
                            <label for="card-element">
                                Enter your card details
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <div id="card-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="nscs-auth__shippinginfo">
                    <div class="input-group">
                        <label for="shipping_address">Shipping Address</label>
                        <input type="text" name="shipping_address" id="shipping_address" placeholder="For e.g. “112 Eagle Trail”" required>
                    </div>
                    <div class="input-group">
                        <label for="shipping_city">City</label>
                        <input type="text" name="shipping_city" id="shipping_city" placeholder="For e.g. “Minneapolis”" required>
                    </div>
                </div>
                <div class="nscs-auth__shippinginfo">
                    <div class="input-group">
                        <label for="shipping_state">State</label>
                        <select name="shipping_state">
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="shipping_zip">Zip</label>
                        <input type="text" name="shipping_zip" id="shipping_zip" placeholder="XXXXX" required>
                    </div>
                </div>

                <input type="submit" value="Make Payment" />

            </div>

            <input type="hidden" name="product_ids" value="32719" />
            <input type="hidden" name="action" value="student_payment" />
            <?php wp_nonce_field( 'student_payment', 'nonce' ); ?>

        </form>

        <script type="text/javascript">

            var nscsPaymentFormSubmitting = false;

            jQuery(document).ready(function($) {

                // Create a Stripe client.
                var stripe = Stripe('pk_test_H5n8LTH0RaQD2JGuWAT4ZIkJ');

                // Create an instance of Elements.
                var elements = stripe.elements();

                // Custom Styling
                var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                        color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                // Create an instance of the card Element.
                var card = elements.create('card', {style: style});

                // Add an instance of the card Element into the `card-element` <div>.
                card.mount('#card-element');

                // Handle real-time validation errors from the card Element.
                card.addEventListener('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                // Handle Form Submission
                $( "#nscs-auth__registration-form" ).submit(function( e ) {

                    e.preventDefault();

                    if ( !nscsPaymentFormSubmitting ) {

                        nscsPaymentFormSubmitting = true;
                        $('#nscs-auth__registration-form input[type=submit]').addClass('loading');

                        // Create a form object we can actually use
                        var PaymentForm = $(this).serialize();
                        var PaymentFormValues = {};
                        $.each($(this).serializeArray(), function (i, field) {
                            PaymentFormValues[field.name] = field.value;
                        });

                        var ownerInfo = {
                            owner: {
                                name: PaymentFormValues.card_owner,
                                address: {
                                    line1: PaymentFormValues.shipping_address,
                                    city: PaymentFormValues.shipping_city,
                                    state: PaymentFormValues.shipping_state,
                                    postal_code: PaymentFormValues.shipping_zip,
                                    country: "US"
                                },
                                email: '<?php echo $user_info->user_email ?>'
                            }
                        };

                        stripe.createSource(card, ownerInfo).then(function(result) {
                            if (result.error) {
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = result.error.message;
                                nscsPaymentFormSubmitting = false;
                            } else {
                                $.ajax({
                                    type   : "POST",
                                    url    : "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                                    data   : PaymentForm + "&stripe_source=" + result.source.id,
                                    error: function() {
                                        $('.nscs-auth__message').html('There was an issue processing the form, please refresh the page and try again.')
                                    },
                                    success: function(data) {

                                        data = JSON.parse(data);

                                        if( !!data.success ) {
                                            window.location = window.location.pathname + '?extras=true';
                                        } else {
                                            $('.nscs-auth__message').html(data.message);
                                        }
                                    },
                                    complete: function() {
                                        nscsPaymentFormSubmitting = false;
                                        $('#nscs-auth__registration-form input[type=submit]').removeClass('loading');
                                    }
                                });
                            }
                        });

                    }

                    return false;
                });
            });
        </script>

    </div>

</div>
