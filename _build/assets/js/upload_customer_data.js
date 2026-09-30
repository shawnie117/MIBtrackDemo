(function (initialise) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initialise(window.jQuery);
        });
    } else {
        initialise(window.jQuery);
    }
})(function ($) {
    'use strict';

    if (!$) {
        return;
    }

    var allowedExtension = /\.(csv|xls|xlsx)$/i;

    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return bytes + ' B';
        }
        if (bytes < 1024 * 1024) {
            return (bytes / 1024).toFixed(1) + ' KB';
        }
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function setFileError($input, message) {
        var $form = $input.closest('.upload-form');
        var $zone = $form.find('.upload-drop-zone');
        var maxSizeLabel = $input.attr('data-max-size-label') || '4 MB';

        $zone.removeClass('has-file').addClass('has-error');
        $form.find('.upload-file-name').text('Choose a file');
        $form.find('.upload-file-help').text('CSV, XLS or XLSX up to ' + maxSizeLabel);
        $form.find('.upload-file-error').text(message);
        $form.find('.upload-submit-btn').prop('disabled', true);
        $input.attr('aria-invalid', 'true');
    }

    function clearFileSelection(input) {
        try {
            input.value = '';
        } catch (ignore) {
            // Older browsers can prevent programmatic clearing; validation
            // still blocks the form submission below.
        }
    }

    function validateSelectedFile(input, showMissingError) {
        var $input = $(input);
        var $form = $input.closest('.upload-form');
        var $zone = $form.find('.upload-drop-zone');
        var file = input.files && input.files.length ? input.files[0] : null;
        var maxSize = parseInt($input.attr('data-max-size'), 10);

        $zone.removeClass('has-error has-file');
        $form.find('.upload-file-error').text('');
        $input.removeAttr('aria-invalid');

        if (!file) {
            $form.find('.upload-file-name').text('Choose a file');
            $form.find('.upload-file-help').text('or drag and drop it here');
            $form.find('.upload-submit-btn').prop('disabled', true);
            if (showMissingError) {
                setFileError($input, 'Please choose a CSV, XLS or XLSX file.');
            }
            return false;
        }

        if (input.files.length !== 1) {
            setFileError($input, 'Please select only one file.');
            clearFileSelection(input);
            return false;
        }

        if (!allowedExtension.test(file.name)) {
            setFileError($input, 'Unsupported file type. Choose a CSV, XLS or XLSX file.');
            clearFileSelection(input);
            return false;
        }

        if (file.size === 0) {
            setFileError($input, 'The selected file is empty. Choose a file containing data.');
            clearFileSelection(input);
            return false;
        }

        if (maxSize && file.size > maxSize) {
            setFileError($input, 'The file is too large. Maximum allowed size is ' + ($input.attr('data-max-size-label') || formatFileSize(maxSize)) + '.');
            clearFileSelection(input);
            return false;
        }

        $zone.addClass('has-file');
        $form.find('.upload-file-name').text(file.name);
        $form.find('.upload-file-help').text(formatFileSize(file.size) + ' \u00b7 Ready to upload');
        $form.find('.upload-submit-btn').prop('disabled', false);
        return true;
    }

    $(function () {
        var $page = $('.upload-data-page');
        $page.addClass('js-upload-ready');
        $page.find('.upload-submit-btn').prop('disabled', true);

        $page.on('click', '.upload-instruction-toggle', function () {
            var $button = $(this);
            var panelId = $button.attr('aria-controls');
            var isOpen = $button.attr('aria-expanded') === 'true';
            var $panel = $('#' + panelId);

            $button.attr('aria-expanded', isOpen ? 'false' : 'true');
            $button.find('span').html('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + (isOpen ? 'View instructions' : 'Hide instructions'));

            if (isOpen) {
                $panel.attr('hidden', true);
            } else {
                $panel.removeAttr('hidden');
            }
        });

        $page.on('change', '.upload-file-input', function () {
            validateSelectedFile(this, false);
        });

        $page.on('keydown', '.upload-drop-zone', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                document.getElementById($(this).attr('for')).click();
            }
        });

        $page.on('dragenter dragover', '.upload-drop-zone', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).addClass('is-dragging');
        });

        $page.on('dragleave dragend drop', '.upload-drop-zone', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).removeClass('is-dragging');
        });

        $page.on('drop', '.upload-drop-zone', function (event) {
            var input = document.getElementById($(this).attr('for'));
            var originalEvent = event.originalEvent;

            if (input && originalEvent && originalEvent.dataTransfer && originalEvent.dataTransfer.files.length) {
                try {
                    input.files = originalEvent.dataTransfer.files;
                    validateSelectedFile(input, false);
                } catch (ignore) {
                    input.click();
                }
            }
        });

        $page.on('submit', '.upload-form', function (event) {
            var input = $(this).find('.upload-file-input').get(0);
            var $button = $(this).find('.upload-submit-btn');

            if (!validateSelectedFile(input, true)) {
                event.preventDefault();
                $(this).find('.upload-drop-zone').focus();
                return;
            }

            $button.prop('disabled', true);
            $button.find('i').removeClass('fa-upload').addClass('fa-spinner fa-spin');
            $button.find('span').text('Uploading...');
        });
    });
});
