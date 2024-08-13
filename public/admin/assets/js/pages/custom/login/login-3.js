"use strict";

// Class Definition
var KTLogin = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

	var _handleFormSignin = function() {
		var form = KTUtil.getById('kt_login_singin_form');
		var formSubmitUrl = KTUtil.attr(form, 'action');
		var formSubmitButton = KTUtil.getById('kt_login_singin_form_submit_button');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						username: {
							validators: {
								notEmpty: {
									message: 'Username is required'
								}
							}
						},
						password: {
							validators: {
								notEmpty: {
									message: 'Password is required'
								}
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
	            		//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
						bootstrap: new FormValidation.plugins.Bootstrap({
						//	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
						//	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
						})
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
					KTUtil.btnRelease(formSubmitButton);
				}, 2000);

				// Form Validation & Ajax Submission: https://formvalidation.io/guide/examples/using-ajax-to-submit-the-form
				/**
		        FormValidation.utils.fetch(formSubmitUrl, {
		            method: 'POST',
					dataType: 'json',
		            params: {
		                name: form.querySelector('[name="username"]').value,
		                email: form.querySelector('[name="password"]').value,
		            },
		        }).then(function(response) { // Return valid JSON
					// Release button
					KTUtil.btnRelease(formSubmitButton);

					if (response && typeof response === 'object' && response.status && response.status == 'success') {
						Swal.fire({
			                text: "All is cool! Now you submit this form",
			                icon: "success",
			                buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light-primary"
							}
			            }).then(function() {
							KTUtil.scrollTop();
						});
					} else {
						Swal.fire({
			                text: "Sorry, something went wrong, please try again.",
			                icon: "error",
			                buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light-primary"
							}
			            }).then(function() {
							KTUtil.scrollTop();
						});
					}
		        });
				**/
		    })
			.on('core.form.invalid', function() {
				Swal.fire({
					text: "Sorry, looks like there are some errors detected, please try again.",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
				}).then(function() {
					KTUtil.scrollTop();
				});
		    });
    }

	var _handleFormForgot = function() {
		var form = KTUtil.getById('kt_login_forgot_form');
		var formSubmitUrl = KTUtil.attr(form, 'action');
		var formSubmitButton = KTUtil.getById('kt_login_forgot_form_submit_button');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						email: {
							validators: {
								notEmpty: {
									message: 'Email is required'
								},
								emailAddress: {
									message: 'The value is not a valid email address'
								}
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
	            		//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
						bootstrap: new FormValidation.plugins.Bootstrap({
						//	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
						//	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
						})
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
					KTUtil.btnRelease(formSubmitButton);
				}, 2000);
		    })
			.on('core.form.invalid', function() {
				Swal.fire({
					text: "Sorry, looks like there are some errors detected, please try again.",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
				}).then(function() {
					KTUtil.scrollTop();
				});
		    });
    }

	var _handleFormSignup = function() {
		// Base elements
		var wizardEl = KTUtil.getById('kt_login');
		var form = KTUtil.getById('kt_login_signup_form');
		var wizardObj;
		var validations = [];

		if (!form) {
			return;
		}

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					examType: {
						validators: {
							notEmpty: {
								message: 'Шалгалтын түвшингээ сонгоно уу'
							}
						}
					},
					examLoc: {
						validators: {
							notEmpty: {
								message: 'Шалгалт өгөх газараа сонгоно уу'
							}
						}
					},
					lname: {
						validators: {
							notEmpty: {
								message: 'Овогоо бичнэ үү'
							},
								regexp: {
                regexp: /^[A-Za-z\-]+$/i,
                message: 'Овогоо латинаар бичнэ үү'
              }
						}
					},
					fname: {
						validators: {
							notEmpty: {
								message: 'Нэрээ бичнэ үү'
							},
								regexp: {
                regexp: /^[A-Za-z\-]+$/i,
                message: 'Нэрээ латинаар бичнэ үү'
              }
						}
					},
					dob: {
						validators: {
							notEmpty: {
								message: 'Төрсөн он сар өдөрөө сонгоно уу'
							}
						}
					},
					gender: {
						validators: {
							notEmpty: {
								message: 'Хүйсээ сонгоно уу'
							}
						}
					},
					id1: {
						validators: {
							notEmpty: {
								message: 'Регистрээ сонгоно уу'
							}
						}
					},
					id2: {
						validators: {
							notEmpty: {
								message: 'Регистрээ сонгоно уу'
							}
						}
					},
					id3: {
						validators: {
							notEmpty: {
								message: 'Регистрийн дугаараа бичнэ үү'
							},
							digits: {
								message: 'Регистрийн дугаартаа тоо бичнэ үү'
							}
						}
					},
					phone: {
						validators: {
							notEmpty: {
								message: 'Холбоо барих утасны дугаараа бичнэ үү'
							},
								regexp: {
                regexp: /^[0-9 ]+$/i,
                message: 'Тоо болон зай ашиглаж болно'
              }
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					address: {
						validators: {
							notEmpty: {
								message: 'Дүүргээ бичнэ үү'
							},
								regexp: {
                regexp: /^[A-Za-z\-]+$/i,
                message: 'Хаягаа латинаар бичнэ үү'
              }
						}
					},
					city: {
						validators: {
							notEmpty: {
								message: 'Хотоо бичнэ үү'
							},
								regexp: {
                regexp: /^[A-Za-z\-]+$/i,
                message: 'Хотоо латинаар бичнэ үү'
              }
						}
					},
					country: {
						validators: {
							notEmpty: {
								message: 'Улсаа сонгоно уу'
							}
						}
					},
					institute: {
						validators: {
							notEmpty: {
								message: 'Тайлбар бичнэ үү'
							},
								regexp: {
                regexp: /^[A-Za-z\-]+$/i,
                message: 'Тайлбар латинаар бичнэ үү'
              }
						}
					},
					major: {
						validators: {
							notEmpty: {
								message: 'Сонголт хийнэ үү'
							}
						}
					},
					major2: {
						validators: {
							notEmpty: {
								message: 'Сонголт хийнэ үү'
							}
						}
					},
					learn: {
						validators: {
							notEmpty: {
								message: 'Сонголт хийнэ үү'
							}
						}
					},
					reason: {
						validators: {
							notEmpty: {
								message: 'Сонголт хийнэ үү'
							}
						}
					},
					mediacheck: {
						validators: {
							notEmpty: {
								message: 'Хамгийн багадаа нэг сонголт хийнэ үү'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					delivery: {
						validators: {
							notEmpty: {
								message: 'Delivery type is required'
							}
						}
					},
					packaging: {
						validators: {
							notEmpty: {
								message: 'Packaging type is required'
							}
						}
					},
					preferreddelivery: {
						validators: {
							notEmpty: {
								message: 'Preferred delivery window is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 4
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					ccname: {
						validators: {
							notEmpty: {
								message: 'Credit card name is required'
							}
						}
					},
					ccnumber: {
						validators: {
							notEmpty: {
								message: 'Credit card number is required'
							},
							creditCard: {
								message: 'The credit card number is not valid'
							}
						}
					},
					ccmonth: {
						validators: {
							notEmpty: {
								message: 'Credit card month is required'
							}
						}
					},
					ccyear: {
						validators: {
							notEmpty: {
								message: 'Credit card year is required'
							}
						}
					},
					cccvv: {
						validators: {
							notEmpty: {
								message: 'Credit card CVV is required'
							},
							digits: {
								message: 'The CVV value is not valid. Only numbers is allowed'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Initialize form wizard
		wizardObj = new KTWizard(wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true // to make steps clickable this set value true and add data-wizard-clickable="true" in HTML for class="wizard" element
		});

		// Validation before going to next page
		wizardObj.on('beforeNext', function (wizard) {
			validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					wizardObj.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Алдаатай мэдээлэл байна, ахин шалгана уу",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});

			wizardObj.stop();  // Don't go to the next step
		});

		// Change event
		wizardObj.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
    }

    // Public Functions
    return {
        init: function() {
            _handleFormSignin();
			_handleFormForgot();
			_handleFormSignup();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLogin.init();
});
