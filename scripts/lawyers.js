(() => {
    'use strict'
    window.addEventListener(
        'load',
        () => {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            let forms = document.getElementsByClassName('needs-validation')
            // Loop over them and prevent submission
            let validation = Array.prototype.filter.call(forms, form => {
                form.addEventListener(
                    'submit',
                    event => {
                        if (form.checkValidity() === false) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    },
                    false
                )
            })
        },
        false
    )
})()

$(document).ready(() => {
    // DOM is fully loaded
    // Capitalize the first letter of First Name
    $('#firstName').on('change', function (e) {
        let $this = $(this),
            val = $this.val()
        RegExp = /\b[a-z]/g

        val = val.charAt(0).toUpperCase() + val.substr(1)
    })

    // Capitalize the first letter of Middle Name
    $('#middleName').on('change', function (e) {
        let $this = $(this)

        let val = $this.val()
        RegExp = /\b[a-z]/g

        val = val.charAt(0).toUpperCase() + val.substr(1)
    })

    // Capitalize the first letter of Last Name
    $('#lastName').on('change', function (e) {
        let $this = $(this),
            val = $this.val()
        RegExp = /\b[a-z]/g

        val = val.charAt(0).toUpperCase() + val.substr(1)
    })

    // change the email to lowercase
    $('#email').on('change', function (e) {
        let $this = $(this),
            val = $this.val()
        val = val.toLowerCase()
    })

    $('form').submit(event => {
        // stop the button from submitting
        event.preventDefault()

        // Make the submit button load
        $('button').removeClass('btn-danger')
        $('button').toggleClass('btn-primary')
        $('button').html(
            'Loading <span class="spinner"></span><i class="fa fa-spinner fa-spin"></i></span>'
        )

        if (form.checkValidity() === true) {
            // put form data into variables
            let firstName = $.trim(document.getElementById('firstName').value)
            let middleName = $.trim(document.getElementById('middleName').value)
            let lastName = $.trim(document.getElementById('lastName').value)
            let email = $.trim(document.getElementById('email').value)
            let phone = $.trim(document.getElementById('phone').value)
            let location = $.trim(document.getElementById('location').value)
            let service = document.querySelector('input[name="service"]:checked').value
            let handledCases = document.querySelector('input[name="handledCases"]:checked').value
            let probonoCases = document.querySelector('input[name="probonoCases"]:checked').value
            let available = document.querySelector('input[name="available"]:checked').value
            let familiarCases = document.querySelector('input[name="familiarCases"]:checked').value
            let requireMentor = document.querySelector('input[name="requireMentor"]:checked').value
            let mentorNeededFor = $.trim(document.getElementById('mentorNeededFor').value)
            let agree = document.getElementById('agree').value

            let postData = JSON.stringify({
                firstName: firstName,
                middleName: middleName,
                lastName: lastName,
                email: email,
                phone: phone,
                location: location,
                service: service,
                handledCases: handledCases,
                probonoCases: probonoCases,
                available: available,
                familiarCases: familiarCases,
                requireMentor: requireMentor,
                mentorNeededFor: mentorNeededFor,
                agree: agree
            })

            // console.log(postData)

            fetch('scripts/lawyer_processor.php', {
                    method: 'post',
                    mode: 'same-origin',
                    credentials: 'same-origin',
                    body: postData
                })
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    if(data === 'user_exists') {
                        swal(
                            'Already Signed Up',
                            'You\'re already signed up!',
                            'warning'
                        )
                        setTimeout(function () {
                            window.location = 'https://hopebehindbarsafrica.org/'
                        }, 3000)
                    } else if (data === 'success') {
                        swal(
                            'Successful Sign Up',
                            'Your signup was successful!',
                            'success'
                        )
                        setTimeout(function () {
                            window.location = 'https://hopebehindbarsafrica.org/'
                        }, 3000)
                    }
                    // console.log(data);
                })
                .catch(error => {
                    console.log('The Request Failed', error)
                })
        }
    })
})
