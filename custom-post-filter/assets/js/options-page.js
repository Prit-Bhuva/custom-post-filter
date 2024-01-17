/**
 * Initializes the Chosen plugin for the jQuery '.chosen-select' elements.
 */
function chosenSelect() {
    var chosenSelect = jQuery('.chosen-select');

    if (chosenSelect.length) {
        chosenSelect.chosen({
            inherit_select_classes: true,
            placeholder_text_single: 'Select Post Type',
            placeholder_text_multiple: 'Select Post Types',
            no_results_text: "Oops, nothing found!"
        });
    }
}

/**
 * Removes the success message from the DOM if it exists.
 */
function removeMessage() {
    var successMessage = document.getElementById('success-msg');
    if (successMessage) {
        successMessage.remove();
    }
}

/**
 * Ensure the DOM is ready before executing the functions
 */
document.addEventListener('DOMContentLoaded', function () {
    chosenSelect();
});
