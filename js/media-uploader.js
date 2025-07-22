jQuery(document).ready(function($){
    // Handles the click event for the "Upload/Add Image" button (generic for series logo and issue cover)
    $(document).on('click', '.upload-button', function(e) {
        e.preventDefault();

        var button = $(this);
        var mediaUploader; // Declare mediaUploader locally for each button click
        var fieldId = '#' + button.data('field-id'); // Get the target input ID from data-field-id
        var previewId = '#' + button.data('preview-id'); // Get the target preview div ID from data-preview-id
        var removeButton = button.siblings('.remove-button'); // Get the associated remove button

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Extends the wp.media object to create a custom media frame
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image', // Generic title for the media modal
            button: {
                text: 'Choose Image' // Generic text for the button in the modal
            },
            multiple: false // Allow only one file to be selected
        });

        // When a file is selected in the media uploader
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON(); // Get selected attachment details
            $(fieldId).val(attachment.id); // Store the attachment ID in the hidden input
            // Display a preview of the selected image
            $(previewId).html('<img src="' + attachment.url + '" style="max-width:150px; height:auto;">');
            removeButton.show(); // Show the remove button after an image is selected
            button.hide(); // Hide the upload button after selection for better UX
        });

        // Open the uploader dialog
        mediaUploader.open();
    });

    // Handles the click event for the "Remove Image" button (generic)
    $(document).on('click', '.remove-button', function(e) {
        e.preventDefault();

        var button = $(this);
        var uploadButton = button.siblings('.upload-button'); // Get the associated upload button
        var fieldId = '#' + uploadButton.data('field-id'); // Get the target input ID from the associated upload button
        var previewId = '#' + uploadButton.data('preview-id'); // Get the target preview div ID

        $(fieldId).val(''); // Clear the hidden input
        $(previewId).html(''); // Clear the preview
        button.hide(); // Hide the remove button
        uploadButton.show(); // Show the upload button
    });

    // On page load, check if an image is already set to show/hide remove buttons appropriately
    // This ensures correct button visibility when editing existing terms
    $('.upload-button').each(function() {
        var button = $(this);
        var fieldId = '#' + button.data('field-id');
        var removeButton = button.siblings('.remove-button');
        if ($(fieldId).val()) { // If there's an ID in the hidden field (meaning an image is set)
            button.hide(); // Hide upload button
            removeButton.show(); // Show remove button
        } else {
            button.show(); // Show upload button
            removeButton.hide(); // Hide remove button
        }
    });
});