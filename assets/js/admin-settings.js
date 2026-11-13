(function ($) {
    'use strict';

    var l10n = window.denkonMosaicSettingsL10n || {};

    function normalizeHexColor(value) {
        value = String(value || '').replace(/^\s+|\s+$/g, '');

        if (/^[0-9a-f]{3}([0-9a-f]{3})?$/i.test(value)) {
            value = '#' + value;
        }

        if (!/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/i.test(value)) {
            return '';
        }

        if (value.length === 4) {
            value = '#' + value.charAt(1) + value.charAt(1) + value.charAt(2) + value.charAt(2) + value.charAt(3) + value.charAt(3);
        }

        return value.toUpperCase();
    }

    function updateCustomSchemePreview() {
        var $preview = $('[data-denkon-custom-preview]');
        var background = normalizeHexColor($('[name="settings[custom_color_background]"]').val()) || '#f8f6f2';
        var surface = normalizeHexColor($('[name="settings[custom_color_surface]"]').val()) || '#ffffff';
        var primary = normalizeHexColor($('[name="settings[custom_color_primary]"]').val()) || '#9a681d';

        if ($preview.length) {
            $preview.css('background', 'linear-gradient(145deg, ' + background + ' 0 42%, ' + surface + ' 42% 66%, ' + primary + ' 66% 100%)');
        }
    }

    function toggleCustomSchemeFields() {
        var isCustom = $('[name="settings[color_scheme]"]:checked').val() === 'custom';
        var $fields = $('[data-denkon-custom-scheme]');

        $fields.prop('hidden', !isCustom);

        if (isCustom) {
            updateCustomSchemePreview();
        }
    }

    $(document).on('change', '[name="settings[color_scheme]"]', toggleCustomSchemeFields);
    $(document).on('input change', '[name^="settings[custom_color_"]', updateCustomSchemePreview);

    $(document).on('input change', '[data-denkon-color-hex]', function () {
        var $hex = $(this);
        var color = normalizeHexColor($hex.val());

        if (color) {
            $hex.closest('.denkon-mosaic-admin__color-control').find('[data-denkon-color-picker]').val(color);
        }
    });

    $(document).on('blur', '[data-denkon-color-hex]', function () {
        var $hex = $(this);
        var color = normalizeHexColor($hex.val());

        if (color) {
            $hex.val(color);
        }
    });

    $(document).on('input change', '[data-denkon-color-picker]', function () {
        var $picker = $(this);
        var color = normalizeHexColor($picker.val());

        if (color) {
            $picker.closest('.denkon-mosaic-admin__color-control').find('[data-denkon-color-hex]').val(color).trigger('change');
        }
    });

    $(toggleCustomSchemeFields);

    $(document).on('click', '.denkon-mosaic-admin__media-select', function (event) {
        event.preventDefault();

        var $field = $(this).closest('[data-media-field]');
        var frame = wp.media({
            title: l10n.mediaTitle || 'Select footer logo',
            library: { type: 'image' },
            button: { text: l10n.mediaButton || 'Use logo' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            var imageUrl = attachment.sizes && attachment.sizes.medium
                ? attachment.sizes.medium.url
                : attachment.url;

            $field.find('input[type="hidden"]').val(attachment.id);
            $field.find('[data-media-preview]').html($('<img>', { src: imageUrl, alt: '' }));
            $field.find('.denkon-mosaic-admin__media-remove').prop('disabled', false);
        });

        frame.open();
    });

    $(document).on('click', '.denkon-mosaic-admin__media-remove', function (event) {
        event.preventDefault();

        var $field = $(this).closest('[data-media-field]');

        $field.find('input[type="hidden"]').val('0');
        $field.find('[data-media-preview]').html('<span>' + (l10n.emptyLogo || 'Not selected — the site title will be shown.') + '</span>');
        $(this).prop('disabled', true);
    });

    function showTransferFeedback($context, type, message) {
        var $notice = $context.closest('.denkon-mosaic-admin__panel').find('[data-denkon-transfer-feedback]');

        if (!$notice.length) {
            return;
        }

        $notice
            .removeClass('notice-success notice-error notice-warning notice-info')
            .addClass('notice-' + type)
            .find('p').text(message);
        $notice.prop('hidden', false);
    }

    $(document).on('click', '[data-denkon-export-settings]', function (event) {
        var $link = $(this);
        var url = $link.attr('href');

        if (!window.fetch || !window.URL || $link.data('exporting')) {
            return;
        }

        event.preventDefault();
        $link.data('exporting', true).addClass('disabled').attr('aria-disabled', 'true');
        showTransferFeedback($link, 'info', l10n.exportPreparing || 'Preparing a ZIP archive with settings. This may take a few seconds.');

        window.fetch(url, { credentials: 'same-origin' })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('export-failed');
                }

                return response.blob().then(function (blob) {
                    return {
                        blob: blob,
                        disposition: response.headers.get('content-disposition') || ''
                    };
                });
            })
            .then(function (result) {
                var filename = 'denkon-mosaic-settings.zip';
                var match = result.disposition.match(/filename="?([^";]+)"?/i);
                var downloadUrl = window.URL.createObjectURL(result.blob);
                var download = document.createElement('a');

                if (match && match[1]) {
                    filename = match[1];
                }

                download.href = downloadUrl;
                download.download = filename;
                document.body.appendChild(download);
                download.click();
                document.body.removeChild(download);
                window.setTimeout(function () {
                    window.URL.revokeObjectURL(downloadUrl);
                }, 1000);

                showTransferFeedback($link, 'success', l10n.exportComplete || 'Export complete. The settings ZIP archive has been downloaded.');
            })
            .catch(function () {
                showTransferFeedback($link, 'error', l10n.exportError || 'Could not prepare the ZIP archive. Reload the page and try again.');
            })
            .then(function () {
                $link.data('exporting', false).removeClass('disabled').removeAttr('aria-disabled');
            });
    });

    $(document).on('submit', '[data-denkon-import-settings]', function () {
        showTransferFeedback($(this), 'info', l10n.importPreparing || 'Importing settings. The page will reload after the operation finishes.');
    });

    $(document).on('submit', '[data-denkon-reset-settings]', function (event) {
        if (!window.confirm(l10n.resetConfirm || 'Reset all Denkon Mosaic settings to defaults? Pages, menus and files will not be deleted.')) {
            event.preventDefault();
            return;
        }

        showTransferFeedback($(this), 'info', l10n.resetPreparing || 'Resetting theme settings. The page will reload after the operation finishes.');
    });

    $(document).on('submit', '[data-denkon-migrate-pattern-metadata]', function (event) {
        if (!window.confirm(l10n.migrationConfirm || 'Update metadata for all previously inserted Denkon Mosaic sections? Content and design will not change; WordPress revisions will be created for changed pages.')) {
            event.preventDefault();
            return;
        }

        showTransferFeedback($(this), 'info', l10n.migrationPreparing || 'Updating metadata for previously inserted patterns. The page will reload after the operation finishes.');
    });
}(jQuery));
