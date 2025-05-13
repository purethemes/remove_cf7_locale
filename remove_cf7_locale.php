<?php
/**
 * Plugin Name: Remove CF7 Locale Metadata
 * Description: Removes the _locale meta field from all Contact Form 7 forms
 * Version: 1.0
 * Author: Your Name
 */

// Ensure the code doesn't run on direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Function to remove _locale meta field from all CF7 forms
 * 
 * @return array Results of the operation
 */
function remove_cf7_locale_meta() {
    $results = [
        'found' => 0,
        'removed' => 0,
        'error' => 0,
        'errors' => []
    ];

    // Get all Contact Form 7 forms
    $args = [
        'post_type' => 'wpcf7_contact_form',
        'posts_per_page' => -1, // Get all forms
        'post_status' => 'any'
    ];

    $cf7_forms = get_posts($args);
    $results['found'] = count($cf7_forms);

    if (empty($cf7_forms)) {
        return $results;
    }

    // Loop through each form and remove the _locale meta
    foreach ($cf7_forms as $form) {
        try {
            $form_id = $form->ID;
            $locale_value = get_post_meta($form_id, '_locale', true);
            
            if ($locale_value !== '') {
                $deleted = delete_post_meta($form_id, '_locale');
                
                if ($deleted) {
                    $results['removed']++;
                } else {
                    $results['error']++;
                    $results['errors'][] = "Could not delete _locale for form ID: {$form_id}";
                }
            }
        } catch (Exception $e) {
            $results['error']++;
            $results['errors'][] = "Exception for form ID {$form_id}: " . $e->getMessage();
        }
    }

    return $results;
}

/**
 * Add admin menu for running the script
 */
function add_remove_cf7_locale_admin_menu() {
    add_management_page(
        'Remove CF7 Locale',
        'Remove CF7 Locale',
        'manage_options',
        'remove-cf7-locale',
        'remove_cf7_locale_admin_page'
    );
}
add_action('admin_menu', 'add_remove_cf7_locale_admin_menu');

/**
 * Admin page callback function
 */
function remove_cf7_locale_admin_page() {
    $results = null;
    
    if (isset($_POST['remove_cf7_locale_nonce']) && 
        wp_verify_nonce($_POST['remove_cf7_locale_nonce'], 'remove_cf7_locale_action')) {
        
        $results = remove_cf7_locale_meta();
    }
    ?>
    <div class="wrap">
        <h1>Remove _locale Meta from Contact Form 7 Forms</h1>
        
        <?php if ($results): ?>
            <div class="notice notice-success">
                <p>
                    Process completed!<br>
                    Forms found: <?php echo $results['found']; ?><br>
                    Meta fields removed: <?php echo $results['removed']; ?><br>
                    Errors: <?php echo $results['error']; ?>
                </p>
                
                <?php if (!empty($results['errors'])): ?>
                    <div class="error-details">
                        <p><strong>Error details:</strong></p>
                        <ul>
                            <?php foreach ($results['errors'] as $error): ?>
                                <li><?php echo esc_html($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <p>Click the button below to remove the _locale meta field from all Contact Form 7 forms.</p>
        <form method="post">
            <?php wp_nonce_field('remove_cf7_locale_action', 'remove_cf7_locale_nonce'); ?>
            <input type="submit" class="button button-primary" value="Remove _locale Meta Fields">
        </form>
    </div>
    <?php
}

/**
 * Function to use directly in your theme's functions.php or via WP-CLI
 */
function run_remove_cf7_locale_meta() {
    $results = remove_cf7_locale_meta();
    return $results;
}
