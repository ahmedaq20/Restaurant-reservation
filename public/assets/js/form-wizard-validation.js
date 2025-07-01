/**
 *  Form Wizard
 */

'use strict';

(function () {
  const select2 = $('.select2'),
    selectPicker = $('.selectpicker');

  // Wizard Validation
  // --------------------------------------------------------------------
  const wizardValidation = document.querySelector('#wizard-validation');
  if (typeof wizardValidation !== undefined && wizardValidation !== null) {
    // Wizard form
    const wizardValidationForm = wizardValidation.querySelector('#wizard-validation-form');
    // Wizard steps
    const wizardValidationFormStep1 = wizardValidationForm.querySelector('#account-details-validation');
    const wizardValidationFormStep2 = wizardValidationForm.querySelector('#personal-info-validation');
    const wizardValidationFormStep3 = wizardValidationForm.querySelector('#social-links-validation');
    // Wizard next prev button
    const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
    const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));

    const validationStepper = new Stepper(wizardValidation, {
      linear: true
    });

    // Account details
    const FormValidation1 = FormValidation.formValidation(wizardValidationFormStep1, {
      fields: {
          id_number: {
          validators: {
            notEmpty: {
              message: 'رقم الهوية مطلوب'
            },
            stringLength: {
              min: 9,
              max: 9,
              message: 'يجب أن يكون طول رقم الهوية 9 ارقام'
            },
            regexp: {
              regexp: /^[ 0-9 ]+$/,
              message: 'رقم الهوية فقط أرقام'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-6'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          //* Move the error message out of the `input-group` element
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    }).on('core.form.valid', function () {
      // Jump to the next step when all fields in the current step are valid
      validationStepper.next();
    });


      // Personal info
      const FormValidation2 = FormValidation.formValidation(wizardValidationFormStep2, {
          fields: {
              health_status: {
                  validators: {
                      notEmpty: {
                          message: 'الحالة الصحية مطلوبة'
                      }
                  }
              },
              social_status: {
                  validators: {
                      notEmpty: {
                          message: 'الحالة الإجتماعية مطلوبة'
                      }
                  }
              },

              // family_number: {
              //     validators: {
              //         notEmpty: {
              //             message: 'عدد أفراد الاسرة مطلوب'
              //         }
              //     }
              // },
              //   male_number: {
              //       validators: {
              //           notEmpty: {
              //               message: 'عدد الذكور مطلوب'
              //           },
              //           regexp: {
              //               regexp: /^[ 0-9 ]+$/,
              //               message: 'عدد الذكور أرقام'
              //           }
              //       }
              //   },
              //   female_number: {
              //       validators: {
              //           notEmpty: {
              //               message: 'عدد الإناث مطلوب'
              //           },
              //           regexp: {
              //               regexp: /^[ 0-9 ]+$/,
              //               message: 'عدد الإناث أرقام'
              //           }
              //       }
              //   },
              //   number_of_children_0_2: {
              //       validators: {
              //           notEmpty: {
              //               message: 'عدد الأطفال مطلوب'
              //           },
              //           regexp: {
              //               regexp: /^[ 0-9 ]+$/,
              //               message: 'عدد الأطفال أرقام'
              //           }
              //       }
              //   },
              //   number_of_children_2_6: {
              //       validators: {
              //           notEmpty: {
              //               message: 'عدد الأطفال مطلوب'
              //           },
              //           regexp: {
              //               regexp: /^[ 0-9 ]+$/,
              //               message: 'عدد الأطفال أرقام'
              //           }
              //       }
              //   },
              //   number_of_children_6_18: {
              //       validators: {
              //           notEmpty: {
              //               message: 'عدد الأطفال مطلوب'
              //           },
              //           regexp: {
              //               regexp: /^[ 0-9 ]+$/,
              //               message: 'عدد الأطفال أرقام'
              //           }
              //       }
              //   },
              //   older_number: {
              //       validators: {
              //           notEmpty: {
              //               message: 'عدد المسننين مطلوب'
              //           },
              //           regexp: {
              //               regexp: /^[ 0-9 ]+$/,
              //               message: 'عدد المسننين أرقام'
              //           }
              //       }
              //   },
          },
          plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              bootstrap5: new FormValidation.plugins.Bootstrap5({
                  // Use this for enabling/changing valid/invalid class
                  // eleInvalidClass: '',
                  eleValidClass: '',
                  rowSelector: '.col-sm-6'
              }),
              autoFocus: new FormValidation.plugins.AutoFocus(),
              submitButton: new FormValidation.plugins.SubmitButton()
          }
      }).on('core.form.valid', function () {
          // Jump to the next step when all fields in the current step are valid
          validationStepper.next();
      });


    // select2
    if (select2.length) {
      select2.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this
          .select2({
            placeholder: 'إختر',
            dropdownParent: $this.parent()
          })
          .on('change', function () {
            // Revalidate the color field when an option is chosen
            FormValidation2.revalidateField('social_status');
          });
      });
    }

    // Social links
    const FormValidation3 = FormValidation.formValidation(wizardValidationFormStep3, {
      fields: {
          phone: {
              validators: {
                  notEmpty: {
                      message: 'رقم الهاتف مطلوب'
                  },
                  stringLength: {
                      min: 10,
                      max: 10,
                      message: 'يجب أن يكون طول رقم الهاتف 10 ارقام'
                  },
                  regexp: {
                      regexp: /^(059|056)\d{7}$/,
                      message: 'رقم الهاتف يبدأ بـ 059 , 056'
                  }
              }
          },
          area_id: {
              validators: {
                  notEmpty: {
                      message: 'حقل المنطقة مطلوب'
                  },
                  regexp: {
                      regexp: /^[ 0-9 ]+$/,
                      message: '*******'
                  }
              }
          },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-6'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // You can submit the form
      // wizardValidationForm.submit()
      // or send the form data to server via an Ajax request
      // To make the demo simple, I just placed an alert
      // alert('Submitted..!!');


        event.preventDefault(); // Prevent the default form submission

        var peopleStoreUrl = $('#app').data('people-store-url');
        // Create a FormData object from the form
        var formData = new FormData(wizardValidationForm);

        // Append CSRF token to the formData if you're using Laravel
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        var namePerson = document.querySelector('input[name="getingName"]').value;

        $.ajax({
            url: peopleStoreUrl, // Ensure this is in a blade file or is dynamically set
            type: 'POST',
            data: formData,
            contentType: false, // Important for FormData
            processData: false, // Important for FormData
            success: function (response) {
                var timerInterval;
                Swal.fire({
                    title: 'تمت الإضافة بنجاح',
                    html: 'تمت إضافة المستفيد  <strong></strong> بنجاح.',
                    timer: 2000,
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false,
                    willOpen: function () {
                        Swal.showLoading();
                        timerInterval = setInterval(function () {
                            Swal.getHtmlContainer().querySelector('strong').textContent = namePerson;
                        }, 100);
                    },
                    willClose: function () {
                        clearInterval(timerInterval);
                    }
                }).then(function (result) {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = document.referrer;
                    }
                });
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
                console.error(xhr.responseText);
            }
        });


    });

    wizardValidationNext.forEach(item => {
      item.addEventListener('click', event => {
        // When click the Next button, we will validate the current step
        switch (validationStepper._currentIndex) {
          case 0:
            FormValidation1.validate();
            break;

          case 1:
            FormValidation2.validate();
            break;

          case 2:
            FormValidation3.validate();
            break;

          default:
            break;
        }
      });
    });

    wizardValidationPrev.forEach(item => {
      item.addEventListener('click', event => {
        switch (validationStepper._currentIndex) {
          case 2:
            validationStepper.previous();
            break;

          case 1:
            validationStepper.previous();
            break;

          case 0:

          default:
            break;
        }
      });
    });
  }
})();
