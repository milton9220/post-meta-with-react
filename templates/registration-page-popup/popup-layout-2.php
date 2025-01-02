<?php
/**
 * @package GbRegistrationPagePopup
 * @var array $args
 * @var array $class_lists all class list
 * @var array $packages_types all package types list
 * @var array $package_names all package name list
 * @var string $site_key site key
 * @var string $discount_text discount text
 * @var string  $form_title form title
 * @var string  $registration_page_view registration page view type
 * @var string  $submit_btn_text submit button text
 * @var string  $image_url popup image url
 * @var boolean $enable_recaptcha recaptcha enable
 * @var boolean $has_popup_overlay popup overlay enable
 * @var boolean $has_discount_text discount text enable
 * @var boolean $has_form_title  registration form title enable
 * @var array   $popup_data popup settings json data
 * @version 1.0.0
 */


defined( 'ABSPATH' ) || exit;
?>
<?php if ($has_popup_overlay){ ?>
	<div class="gb-registration-page-popup-overlay"></div>
<?php } ?>
<div class="gb-registration-page-popup" data-popup-settings="<?php echo esc_attr($popup_data); ?>">
    <?php if ($image_url){ ?>
        <div class="popup-img">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('popup image','gb-registration-page-popup'); ?>">
        </div>
    <?php } ?>
	<div class="form-fields-wrapper">
        <span class="gb-registration-page-popup-close-btn">&times;</span>
		<?php if ($has_discount_text){ ?>
            <h2 class="gb-page-discount-text"><?php echo esc_html($discount_text); ?></h2>
		<?php } ?>
		<?php if ($has_form_title){ ?>
            <h3 class="gb-page-title"><?php echo esc_html($form_title); ?></h3>
		<?php } ?>
        <form  method="post" id="registrationForm" enctype="multipart/form-data">
            <div class="gb-fields-wrapper">
                <div class="gb-input-field">
                    <label for="full_name"><?php esc_html_e('Full Name','gb-registration-page-popup'); ?></label>
                    <input id="full_name" type="text" name="full_name" placeholder="<?php  esc_attr_e('Enter your name','gb-registration-page-popup') ?>">
                    <span class="error-message" id="full_name_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="email"><?php esc_html_e('Email','gb-registration-page-popup'); ?></label>
                    <input id="email" type="email" name="email" placeholder="<?php  esc_attr_e('Enter your email','gb-registration-page-popup') ?>">
                    <span class="error-message" id="email_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="address"><?php esc_html_e('Address','gb-registration-page-popup'); ?></label>
                    <textarea name="address" id="address"  placeholder="<?php  esc_attr_e('Enter your address','gb-registration-page-popup') ?>"></textarea>
                    <span class="error-message" id="address_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="phone_number"><?php esc_html_e('Phone Number','gb-registration-page-popup'); ?></label>
                    <input id="phone_number" type="tel" name="phone_number" placeholder="<?php  esc_attr_e('Enter your phone number','gb-registration-page-popup') ?>">
                    <span class="error-message" id="phone_number_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="age"><?php esc_html_e('Age','gb-registration-page-popup'); ?></label>
                    <input id="age" type="number" name="age">
                    <span class="error-message" id="age_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="gender"><?php esc_html_e('Gender','gb-registration-page-popup'); ?></label>
                    <select name="gender" id="gender" class="gym-builder-select2">
                        <option value="male"><?php esc_html_e('Male','gb-registration-page-popup'); ?></option>
                        <option value="female"><?php esc_html_e('Female','gb-registration-page-popup'); ?></option>
                    </select>
                </div>
                <div class="gb-input-field">
                    <label for="joining_date"><?php esc_html_e('Joining Date','gb-registration-page-popup'); ?></label>
                    <input id="joining_date" type="date" name="joining_date" placeholder="<?php  esc_attr_e('Enter your joining date','gb-registration-page-popup') ?>">
                    <span class="error-message" id="joining_date_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="classes"><?php esc_html_e('Select Class','gb-registration-page-popup'); ?></label>
                    <select name="classes[]" id="classes" class="gym-builder-select2" multiple>
						<?php
						if ($class_lists){
							foreach ($class_lists as $class_list) {
								?>
                                <option value="<?php echo esc_attr($class_list['label']); ?>"><?php echo esc_html($class_list['label']); ?></option>
							<?php }
						}
						?>
                    </select>
                    <span class="error-message" id="classes_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="membership_package"><?php esc_html_e('Select Course Pricing Package Name','gb-registration-page-popup'); ?></label>
                    <select name="membership_package" id="membership_package" class="gym-builder-select2">
						<?php
						if ($packages_types){
							foreach ($packages_types as $index=>$value) {
								?>
                                <option value="<?php echo esc_attr($index); ?>"><?php echo esc_html($value); ?></option>
							<?php }
						}
						?>
                    </select>
                    <span class="error-message" id="package_name_error"></span>
                </div>
                <div class="gb-input-field">
                    <label for="membership_package_name"><?php esc_html_e('Select Course Pricing Package List & Price','gb-registration-page-popup'); ?></label>
                    <select name="membership_package_name" id="membership_package_name" class="gym-builder-select2">
						<?php
						if ($package_names){
							foreach ($package_names as $index=>$value) {
								?>
                                <option value="<?php echo esc_attr($index); ?>"><?php echo esc_html($value); ?></option>
							<?php }
						}
						?>
                    </select>
                </div>
                <div class="gb-input-field">
                    <label for="profile_image"><?php esc_html_e('Profile Image (JPG/PNG, Max 2MB)','gb-registration-page-popup'); ?></label>
                    <input id="profile_image" type="file" name="profile_image" accept=".jpg, .jpeg, .png">
                    <span class="error-message" id="profile_image_error"></span>
                </div>
				<?php if ($enable_recaptcha){?>
                    <div class="gb-input-field">
                        <div class="g-recaptcha" id="gb_recaptcha" data-sitekey="<?php echo esc_attr($site_key); ?>"></div>
                        <span class="error-message" id="g-recaptcha-error"></span>
                    </div>
				<?php } ?>
                <div class="gb-input-field">
                    <input type="hidden" id="gb_frontend_member_registration_nonce" value="<?php echo wp_create_nonce('gb_register_member_nonce'); ?>" />
                    <button class="register-btn" type="submit"><?php echo esc_html($submit_btn_text); ?></button>
                </div>
            </div>
        </form>
        <div id="gb-registration-page-form-message" class="gb-registration-page-form-message"></div>
    </div>
</div>
