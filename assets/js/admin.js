(function () {
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
            return;
        }
        document.addEventListener('DOMContentLoaded', fn);
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function escapeRegExp(value) {
        return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function sanitizeId(name) {
        return 'emtss-' + String(name || '')
            .replace(/[\[\]]+/g, '-')
            .replace(/[^a-zA-Z0-9_-]+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }

    function uniqueEditorId(name) {
        return sanitizeId(name) + '-' + Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 7);
    }

    function syncWpEditors() {
        if (window.tinyMCE && typeof window.tinyMCE.triggerSave === 'function') {
            window.tinyMCE.triggerSave();
        }
    }

    function removeWpEditor(textarea) {
        if (!textarea || !textarea.id) {
            return;
        }

        if (window.wp && window.wp.editor && typeof window.wp.editor.remove === 'function') {
            try {
                window.wp.editor.remove(textarea.id);
                return;
            } catch (error) {
                // Fall through to the TinyMCE cleanup below.
            }
        }

        if (window.tinyMCE && window.tinyMCE.get(textarea.id)) {
            window.tinyMCE.execCommand('mceRemoveEditor', false, textarea.id);
        }
    }

    function removeWpEditors(scope) {
        if (!scope) {
            return;
        }

        syncWpEditors();
        scope.querySelectorAll('textarea.wp-editor-area[id]').forEach(removeWpEditor);
    }

    function buildEditorShell(textarea) {
        var id = textarea.id;
        var shell = document.createElement('div');
        var containerId = 'wp-' + id + '-editor-container';

        shell.id = 'wp-' + id + '-wrap';
        shell.className = 'wp-core-ui wp-editor-wrap tmce-active';
        shell.innerHTML = [
            '<div id="wp-' + escapeHtml(id) + '-editor-tools" class="wp-editor-tools hide-if-no-js">',
            '<div class="wp-editor-tabs">',
            '<button type="button" id="' + escapeHtml(id) + '-tmce" class="wp-switch-editor switch-tmce" data-wp-editor-id="' + escapeHtml(id) + '">Visual</button>',
            '<button type="button" id="' + escapeHtml(id) + '-html" class="wp-switch-editor switch-html" data-wp-editor-id="' + escapeHtml(id) + '">Text</button>',
            '</div>',
            '</div>',
            '<div id="' + escapeHtml(containerId) + '" class="wp-editor-container"></div>'
        ].join('');

        textarea.parentNode.insertBefore(shell, textarea);
        shell.querySelector('.wp-editor-container').appendChild(textarea);

        shell.querySelectorAll('.wp-switch-editor').forEach(function (button) {
            button.addEventListener('click', function () {
                if (window.switchEditors && typeof window.switchEditors.switchto === 'function') {
                    window.switchEditors.switchto(button);
                }
            });
        });
    }

    function initializeDynamicRichEditors(scope) {
        if (!scope || !window.wp || !window.wp.editor || typeof window.wp.editor.initialize !== 'function') {
            return;
        }

        scope.querySelectorAll('textarea[data-rich-editor-template]').forEach(function (textarea) {
            var field = textarea.closest('.emtss-admin-field');
            var label = field ? field.querySelector('label') : null;

            textarea.id = uniqueEditorId(textarea.name);

            if (label) {
                label.setAttribute('for', textarea.id);
            }

            textarea.classList.add('wp-editor-area');
            textarea.removeAttribute('data-rich-editor-template');
            buildEditorShell(textarea);

            window.wp.editor.initialize(textarea.id, {
                tinymce: {
                    wpautop: true,
                    toolbar1: 'formatselect,bold,italic,bullist,numlist,link,unlink,undo,redo',
                    toolbar2: ''
                },
                quicktags: {
                    buttons: 'strong,em,link,ul,ol,li,close'
                },
                mediaButtons: false
            });
        });
    }

    function updateRepeaterNames(group) {
        syncWpEditors();

        var baseName = group.getAttribute('data-repeat-name');
        var itemsWrap = group.querySelector(':scope > .emtss-admin-group-body > [data-repeat-items]');
        var items = itemsWrap ? Array.prototype.slice.call(itemsWrap.querySelectorAll(':scope > [data-repeat-item]')) : [];

        if (!baseName) {
            return;
        }

        items.forEach(function (item, index) {
            var prefixPattern = new RegExp(escapeRegExp(baseName) + '\\[[^\\]]+\\]');
            var toolbarTitle = item.querySelector(':scope > .emtss-repeat-item-toolbar strong');

            if (toolbarTitle && /^New item$|^Item\s+\d+/i.test(toolbarTitle.textContent.trim())) {
                toolbarTitle.textContent = 'Item ' + (index + 1);
            }

            item.querySelectorAll('[name]').forEach(function (field) {
                field.name = field.name.replace(prefixPattern, baseName + '[' + index + ']');
                if (field.id && !field.classList.contains('wp-editor-area')) {
                    field.id = sanitizeId(field.name);
                }
            });

            item.querySelectorAll('[data-repeat-name]').forEach(function (nestedGroup) {
                nestedGroup.setAttribute('data-repeat-name', nestedGroup.getAttribute('data-repeat-name').replace(prefixPattern, baseName + '[' + index + ']'));
            });

            item.querySelectorAll('template[data-repeat-template]').forEach(function (template) {
                template.innerHTML = template.innerHTML.replace(prefixPattern, baseName + '[' + index + ']');
            });
        });
    }

    function openMediaPicker(button) {
        var control = button.closest('.emtss-media-control');
        var input = control ? control.querySelector('[data-media-input]') : null;
        var preview = control && control.parentElement ? control.parentElement.querySelector('[data-media-preview]') : null;

        if (!input || !window.wp || !window.wp.media) {
            return;
        }

        var frame = window.wp.media({
            title: 'Choose image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            input.value = attachment.url || '';

            if (preview) {
                preview.innerHTML = input.value ? '<img src="' + escapeHtml(input.value) + '" alt="">' : '';
            }
        });

        frame.open();
    }

    ready(function () {
        document.addEventListener('click', function (event) {
            var mediaButton = event.target.closest('[data-media-select]');
            var addButton = event.target.closest('[data-repeat-add]');
            var removeButton = event.target.closest('[data-repeat-remove]');

            if (mediaButton) {
                event.preventDefault();
                openMediaPicker(mediaButton);
                return;
            }

            if (addButton) {
                event.preventDefault();
                syncWpEditors();
                var group = addButton.closest('[data-repeat-group]');
                var template = group ? group.querySelector(':scope > .emtss-admin-group-body > template[data-repeat-template]') : null;
                var itemsWrap = group ? group.querySelector(':scope > .emtss-admin-group-body > [data-repeat-items]') : null;
                var index = itemsWrap ? itemsWrap.querySelectorAll(':scope > [data-repeat-item]').length : 0;

                if (template && itemsWrap) {
                    itemsWrap.insertAdjacentHTML('beforeend', template.innerHTML.replace(/__INDEX__/g, String(index)));
                    var addedItem = itemsWrap.lastElementChild;
                    updateRepeaterNames(group);
                    initializeDynamicRichEditors(addedItem);
                }
                return;
            }

            if (removeButton) {
                event.preventDefault();
                syncWpEditors();
                var item = removeButton.closest('[data-repeat-item]');
                var parentGroup = removeButton.closest('[data-repeat-group]');

                if (item) {
                    removeWpEditors(item);
                    item.remove();
                }

                if (parentGroup) {
                    updateRepeaterNames(parentGroup);
                }
            }
        });

        document.querySelectorAll('.emtss-admin-wrap form').forEach(function (adminForm) {
            adminForm.addEventListener('submit', syncWpEditors);
        });

        var form = document.getElementById('emtss-reply-form');
        if (!form) {
            return;
        }

        var selectVisible = form.querySelector('[data-select-visible]');
        var sendAll = form.querySelector('[data-send-all]');
        var recipients = Array.prototype.slice.call(form.querySelectorAll('[data-recipient]'));
        var subject = form.querySelector('[data-email-subject]');
        var body = form.querySelector('[data-email-body]');
        var previewSubject = form.querySelector('[data-preview-subject]');
        var previewBody = form.querySelector('[data-preview-body]');
        var previewRecipients = form.querySelector('[data-preview-recipients]');

        function updatePreview() {
            var selected = recipients.filter(function (item) {
                return item.checked;
            }).map(function (item) {
                return item.getAttribute('data-name') + ' <' + item.getAttribute('data-email') + '>';
            });

            if (previewSubject) {
                previewSubject.textContent = subject && subject.value ? subject.value : 'Subject preview';
            }

            if (previewBody) {
                var text = body && body.value ? body.value : 'Your email body preview will appear here.';
                previewBody.innerHTML = escapeHtml(text).replace(/\n/g, '<br>');
            }

            if (previewRecipients) {
                if (sendAll && sendAll.checked) {
                    previewRecipients.textContent = 'All collected inquiries';
                } else {
                    previewRecipients.textContent = selected.length ? selected.join(', ') : 'None selected';
                }
            }
        }

        if (selectVisible) {
            selectVisible.addEventListener('change', function () {
                recipients.forEach(function (item) {
                    item.checked = selectVisible.checked;
                });
                updatePreview();
            });
        }

        if (sendAll) {
            sendAll.addEventListener('change', updatePreview);
        }

        recipients.forEach(function (item) {
            item.addEventListener('change', updatePreview);
        });

        if (subject) {
            subject.addEventListener('input', updatePreview);
        }

        if (body) {
            body.addEventListener('input', updatePreview);
        }

        updatePreview();
    });
}());
