(function () {
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
            return;
        }
        document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function () {
        var modal = document.getElementById('emtssInquiryModal');
        var form = document.querySelector('.emtss-inquiry-form');
        var title = document.getElementById('emtssInquiryTitle');
        var typeInput = document.querySelector('[data-emtss-inquiry-type]');
        var response = document.querySelector('.emtss-form-response');
        var submitButton = form ? form.querySelector('button[type="submit"]') : null;
        var submitLabel = submitButton ? submitButton.querySelector('span') : null;
        var phoneInput = document.getElementById('emtss-phone');
        var phoneCountryInput = document.querySelector('[data-emtss-phone-country]');
        var phoneInstance = null;
        var defaultSubmitText = submitLabel ? submitLabel.textContent : '';
        var phoneOptions = window.emtssTheme && window.emtssTheme.phone ? window.emtssTheme.phone : {};

        if (phoneInput && window.intlTelInput) {
            phoneInstance = window.intlTelInput(phoneInput, {
                initialCountry: phoneOptions.initialCountry || 'sa',
                onlyCountries: phoneOptions.onlyCountries || [],
                countryOrder: phoneOptions.countryOrder || ['sa'],
                countrySearch: true,
                separateDialCode: true,
                strictMode: true,
                countryNameLocale: window.emtssTheme && window.emtssTheme.isRtl ? 'ar' : 'en',
                loadUtils: function () {
                    return import(phoneOptions.utilsUrl || 'https://cdn.jsdelivr.net/npm/intl-tel-input@29.0.5/dist/js/utils.js');
                }
            });

            phoneInput.addEventListener('countrychange', function () {
                var country = phoneInstance.getSelectedCountryData();
                if (phoneCountryInput && country && country.iso2) {
                    phoneCountryInput.value = country.iso2;
                }
            });

            phoneInput.addEventListener('input', function () {
                phoneInput.setCustomValidity('');
            });
        }

        document.querySelectorAll('.emtss-open-inquiry').forEach(function (button) {
            button.addEventListener('click', function () {
                var type = button.getAttribute('data-inquiry-type') || 'briefing';

                if (typeInput) {
                    typeInput.value = type;
                }

                if (title && window.emtssTheme && window.emtssTheme.modalTitles) {
                    title.textContent = window.emtssTheme.modalTitles[type] || window.emtssTheme.modalTitles.briefing;
                }

                if (response) {
                    response.textContent = '';
                    response.classList.remove('is-error');
                }
            });
        });

        if (modal) {
            modal.addEventListener('hidden.bs.modal', function () {
                if (response) {
                    response.textContent = '';
                    response.classList.remove('is-error');
                }
            });
        }

        if (!form) {
            return;
        }

        function setLoading(isLoading) {
            if (response) {
                if (isLoading) {
                    response.textContent = window.emtssTheme && window.emtssTheme.messages ? window.emtssTheme.messages.sending : 'Sending...';
                    response.classList.remove('is-error');
                }
            }

            if (submitButton) {
                submitButton.disabled = isLoading;
            }

            if (submitLabel) {
                submitLabel.textContent = isLoading && window.emtssTheme && window.emtssTheme.messages
                    ? window.emtssTheme.messages.sending
                    : defaultSubmitText;
            }
        }

        function phoneReady() {
            if (!phoneInstance || !phoneInstance.promise) {
                return Promise.resolve();
            }

            return phoneInstance.promise.catch(function () {
                return null;
            });
        }

        function buildFormData() {
            var formData = new FormData(form);

            if (phoneInstance) {
                var country = phoneInstance.getSelectedCountryData();

                if (!phoneInstance.isValidNumber()) {
                    throw new Error(window.emtssTheme && window.emtssTheme.messages ? window.emtssTheme.messages.phoneInvalid : 'Please enter a valid phone number.');
                }

                formData.set('phone', phoneInstance.getNumber());

                if (country && country.iso2) {
                    formData.set('phone_country', country.iso2);
                    if (phoneCountryInput) {
                        phoneCountryInput.value = country.iso2;
                    }
                }
            }

            return formData;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            if (phoneInput) {
                phoneInput.setCustomValidity('');
            }

            if (!form.reportValidity()) {
                return;
            }

            setLoading(true);

            phoneReady()
                .then(buildFormData)
                .then(function (formData) {
                    return fetch(window.emtssTheme.ajaxUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        body: formData
                    });
                })
                .then(function (res) {
                    return res.json();
                })
                .then(function (json) {
                    if (!json || !json.success) {
                        throw new Error(json && json.data && json.data.message ? json.data.message : '');
                    }

                    if (response) {
                        response.textContent = json.data && json.data.message ? json.data.message : window.emtssTheme.messages.success;
                    }

                    form.reset();

                    if (phoneInstance) {
                        phoneInstance.setCountry(phoneOptions.initialCountry || 'sa');
                    }
                })
                .catch(function (error) {
                    if (phoneInput && error.message === (window.emtssTheme && window.emtssTheme.messages ? window.emtssTheme.messages.phoneInvalid : 'Please enter a valid phone number.')) {
                        phoneInput.setCustomValidity(error.message);
                        phoneInput.reportValidity();
                    }

                    if (response) {
                        response.textContent = error.message || (window.emtssTheme && window.emtssTheme.messages ? window.emtssTheme.messages.error : 'Something went wrong.');
                        response.classList.add('is-error');
                    }
                })
                .finally(function () {
                    setLoading(false);
                });
        });
    });
}());
