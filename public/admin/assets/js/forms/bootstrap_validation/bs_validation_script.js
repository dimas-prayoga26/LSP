function snackBarAlert(message, alertBgColor) {
    Snackbar.show({
        text: message,
        actionTextColor: '#fff',
        backgroundColor: alertBgColor,
        showAction: false,
        pos: 'bottom-left',
        width: 'auto'
    });
}

(function() {
    'use strict';
    function validateCheckbox() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let isChecked = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                isChecked = true;
            }
        });
            return isChecked;
    }

    function validateRadioFRAPL01() {
        const radioButtons = document.querySelectorAll('input[type="radio"][name="tujuan_assesmen"]');
        let isSelected = false;
        for (let i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                isSelected = true;
                break;
            }
        }
        return isSelected;
    }

    function validateRadioGroupFRAPL01() {
        const radioGroups = document.querySelectorAll('input[type="radio"][name^="statusBerkasPemohon"]');
        const fileInputs = document.querySelectorAll('input[type="file"][name^="berkasFilePemohon"]');
        const checkedGroups = {};
        const fileGroups = {};

        // Check radio buttons
        radioGroups.forEach(function(radio) {
            const name = radio.name;
            if (!checkedGroups[name]) {
                checkedGroups[name] = false;
            }
            if (radio.checked) {
                checkedGroups[name] = true;
            }
        });

        // Check file inputs
        fileInputs.forEach(function(fileInput) {
            const name = fileInput.name;
            fileGroups[name] = fileInput.files.length > 0;
        });

        // Validate radio buttons
        for (const key in checkedGroups) {
            if (!checkedGroups[key]) {
                return false;
            }
        }

        // Validate file inputs
        for (const key in fileGroups) {
            if (!fileGroups[key]) {
                return false;
            }
        }

        return true;
    }

    function validateRadioGroupFRAPL02() {
        const radioGroups = document.querySelectorAll('input[type="radio"][name^="statusAssesmenMandiri"]');
        const fileInputs = document.querySelectorAll('input[type="file"][name^="berkasFilePemohon"]');
        const checkedGroups = {};
        const fileGroups = {};

        // Check radio buttons
        radioGroups.forEach(function(radio) {
            const name = radio.name;
            if (!checkedGroups[name]) {
                checkedGroups[name] = false;
            }
            if (radio.checked) {
                checkedGroups[name] = true;
            }
        });

        // Check file inputs
        fileInputs.forEach(function(fileInput) {
            const name = fileInput.name;
            fileGroups[name] = fileInput.files.length > 0;
        });

        // Validate radio buttons
        for (const key in checkedGroups) {
            if (!checkedGroups[key]) {
                return false;
            }
        }

        // Validate file inputs
        for (const key in fileGroups) {
            if (!fileGroups[key]) {
                return false;
            }
        }

        return true;
    }

    window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            var submitButton = form.querySelector('button[type="submit"]');
            const url = form.getAttribute('action');
            const currentUrl = new URL(window.location.href);

            if(!validateCheckbox() && currentUrl.pathname.includes('persetujuan-assesmen')) {
                event.preventDefault();
                snackBarAlert('Centang minimal satu checkbox berkas', '#e7515a');
                event.stopPropagation();
                return false;
            }
            if(!validateRadioFRAPL01() && currentUrl.pathname.includes('frapl01-assesmen')) {
                event.preventDefault();
                snackBarAlert('Pilih salah satu tujuan assesmen', '#e7515a');
                event.stopPropagation();
                return false;
            }
            if(!validateRadioGroupFRAPL01() && currentUrl.pathname.includes('frapl01-assesmen')) {
                event.preventDefault();
                snackBarAlert('Pilih persyaratan pemohon minimal satu dan upload setiap berkasnya', '#e7515a');
                event.stopPropagation();
                return false;
            }

            if(!validateRadioGroupFRAPL02() && currentUrl.pathname.includes('frapl02-assesmen')) {
                event.preventDefault();
                snackBarAlert('Pilih elemen minimal satu dan upload berkas di setiap elemennya', '#e7515a');
                event.stopPropagation();
                return false;
            }

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            event.preventDefault();
            form.classList.add('was-validated');

            const formData = new FormData(form);
            const keyModal = $(event.target).closest('.modal').data('key-modal');
            const isUpdate = form.getAttribute('data-method') === 'PUT';
            const buttonTextLoading = isUpdate ? 'Updating...' : 'Saving...';
            const buttonTextDone = isUpdate ? 'Update' : 'Simpan';

            submitButton.textContent = buttonTextLoading;
            submitButton.disabled = true;
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                statusCode: {
                    422: function(response) {
                        let errors = response.responseJSON.errors;
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errors[field].forEach(function(error) {
                                    snackBarAlert(error, '#e7515a');
                                });
                            }
                        }
                    },
                    500: function() {
                        snackBarAlert('Internal server error', '#e7515a');
                    }
                },
                success: function(response) {
                    snackBarAlert(response.message, '#1abc9c');
                    submitButton.textContent = buttonTextDone;
                    submitButton.disabled = false;
                    if(!url.includes('pengaturan')) {
                        form.reset();
                    }
                    getData();
                    $('#' + keyModal).modal('hide');
                },
                error: function(xhr, status, error) {
                    submitButton.textContent = buttonTextDone;
                    submitButton.disabled = false;
                    snackBarAlert('Internal server error', '#e7515a');
                },
                complete: function() {
                    submitButton.textContent = buttonTextDone;
                    submitButton.disabled = false;
                }
            });
        }, false);
      });
    }, false);

    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('simple-example');
      var invalid = document.querySelector('.simple-example .invalid-feedback');
      Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            invalid.style.display = 'block';
        } else {
            invalid.style.display = 'none';
            form.classList.add('was-validated');
          }
        }, false);
      });

    }, false);

  })();
