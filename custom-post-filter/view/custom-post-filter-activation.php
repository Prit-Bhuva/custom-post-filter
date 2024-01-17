<?php
class CustomPostFilterActivation
{
    /**
     * Activate the functionality.
     *
     * This function is responsible for activating the desired functionality. It may contain activation logic, if any.
     *
     * @return void
     */
    public static function activate(): void
    {
        // Activation logic, if any
    }

    /**
     * Creates a menu page for the custom post filter settings.
     *
     * @return void
     */
    public static function createMenu(): void
    {
        add_menu_page(
            'Custom Post Filter Settings',
            'Post Filter Settings',
            'manage_options',
            'custom_post_filter_settings',
            [__CLASS__, 'renderSettingsPage']
        );
    }

    /**
     * Render the settings page.
     *
     * This function handles the rendering of the settings page. If the form is submitted, it saves the selected post types and taxonomies.
     *
     * @return void
     */
    public static function renderSettingsPage(): void
    {
        if (isset($_POST['submit'])) {

            // Handle form submission and save settings here
            $selectedPostTypes = isset($_POST['post_types']) ? $_POST['post_types'] : [];
            // $selectedTaxonomies = isset($_POST['taxonomies']) ? $_POST['taxonomies'] : [];

            // Save the selected post types and taxonomies (you may want to sanitize and validate the data)
            update_option('custom_post_types', $selectedPostTypes);
            // update_option('custom_taxonomies', $selectedTaxonomies);

?>
            <div class="filter-option msg-updated" id="success-msg">
                <p class="success-message">Settings saved <span class="close-button" onclick="removeMessage();">&times;</span></p>
            </div>
        <?php
        }

        // Retrieve current settings
        $currentPostTypes = get_option('custom_post_types', []);
        // $currentTaxonomies = get_option('custom_taxonomies', []);

        // Display the form to select post types and taxonomies
        ?>
        <div class="filter-option">
            <h2>Custom Post Filter Settings</h2>
            <form method="post" id="post-filter-form">

                <label for="post_types">Select Post Types:</label>
                <select name="post_types[]" class="post-types-select chosen-select" multiple>
                    <option value='Select Post Type' disabled>Select Post Types</option>

                    <?php
                    $allPublicPostTypes = get_post_types(['public' => true]);
                    foreach ($allPublicPostTypes as $postType) {
                        // $selected = in_array($postType, $currentPostTypes) || ($postType === 'post') ? 'selected' : '';

                        $selected = (empty($currentPostTypes) && $postType === 'post') || in_array($postType, $currentPostTypes) ? 'selected' : '';
                    ?>
                        <option value='<?php echo esc_attr($postType); ?>' <?php echo esc_attr($selected); ?>><?php echo esc_html($postType); ?></option>
                    <?php
                    }
                    ?>

                </select>

                <input type="submit" name="submit" class="button button-primary" value="Save Settings">
            </form>
        </div>
<?php
    }
}
