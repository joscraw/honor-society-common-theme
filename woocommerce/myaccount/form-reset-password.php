<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="nscs-auth nscs-auth-container">

    <div class="nscs-auth__bg"></div>

    <div class="nscs-auth__content">

        <?php
        $auth_title = "RESET PASSWORD";
        include( dirname(__FILE__) . '/../../inc/auth-header.php')
        ?>

        <form method="post" id="nscs-auth__reset-form" class="woocommerce-ResetPassword lost_reset_password">

            <p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

            <div class="input-group">
                <label for="password_1"><?php esc_html_e( 'New password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="password" name="password_1" id="password_1" autocomplete="new-password" />
            </div>

            <div class="input-group">
                <label for="password_2"><?php esc_html_e( 'Re-enter new password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="password" name="password_2" id="password_2" autocomplete="new-password" />
            </div>

            <input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
            <input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

            <div class="clear"></div>

            <?php do_action( 'woocommerce_resetpassword_form' ); ?>

            <div class="input-group">
                <input type="hidden" name="wc_reset_password" value="true" />
                <input type="submit" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
            </div>

            <?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

        </form>
    </div>

</div>
