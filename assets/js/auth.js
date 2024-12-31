// Timer
let interval = null
function startTimer (timer) {
    if(interval) {
        clearInterval(interval)
    }
    $('#timer').text(timer);
    interval = setInterval(function () {
        $('#timer').text(--timer);

        if (!timer) {
            clearInterval(interval)
            $('#timer').removeClass('active')
            $('#btn-resend').addClass('active')
        }
    }, 1000);
}

toastr.options = {
    "closeButton": false,
    "debug": true,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toastr-top-center",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

$(document).ready(function (){
    // form auth
    // change mobile or email
    $(document).on('click', '.form-auth-change-data', function (e){
        e.preventDefault()
        $('.form-auth-data-mode,.form-auth-change-data').removeClass('active')
        $(this).addClass('active')
        $('#form-auth-'+$(this).data('type')).addClass('active')
    })

    // submit form auth
    $(document).on('click', '#btn-next', function (e){
        e.preventDefault()
        $.ajax({
            url: localize.auth.route.request,
            method: 'post',
            dataType: 'json',
            data: {
                _token: getCsrfToken(),
                type: $('.form-auth-change-data.active').data('type'),
                mobile_prefix: $('#mobile-prefix').val(),
                mobile: $('#mobile').val(),
                email: $('#email').val(),
            },
            beforeSend: function(){
                // $('#loading').addClass('active')
                $('.form-error').removeClass('active').text('')
            },
            complete: function(){
                $('#loading').removeClass('active')
            },
            success: function(json){

            },
            error: function(res){
                toastr.error(res.responseJSON.message)
                $.each(res.responseJSON.errors, function (field, value){
                    $('#error-' + field).addClass('active').text(value)
                })
            },
        })
        // $('.form-data').removeClass('active')
        // $('#form-code').addClass('active')
        // $('#code-1').focus()
        // startTimer(5)
    })

    // form code
    $(document).on('click', '#back-form-auth', function (e){
        e.preventDefault()
        $('.form-data').removeClass('active')
        $('#form-auth').addClass('active')
    })

    // change code number
    let backspaceKey = 8, deleteKey = 46, tabKey = 9, enterKey = 13, escapeKey = 27, shiftKey = 16, leftKey = 37, rightKey = 39
    let validKeys = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 8, 46, 9, 13, 27, 16, 37, 39]
    let numberKeys = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]
    let maxCode = 5

    $(document).on('keydown', '.form-code-number', function (e){
        let element_number = $(this).data('code-number')
        if ($.inArray(e.keyCode, validKeys) === -1) {
            e.preventDefault()
            return
        }
        // shift + tab, backspace, delete
        if ((e.shiftKey && e.keyCode === tabKey)) {
            if (element_number > 1) {
                $('#code-' + (element_number - 1)).focus()
                e.preventDefault()
                return
            }
        }

        if (e.keyCode === backspaceKey || e.keyCode === deleteKey || e.keyCode === escapeKey) {
            $(this).val('')
            setTimeout(function (){
                if (element_number > 1) {
                    $('#code-' + (element_number - 1)).focus()
                    e.preventDefault()
                }
            }, 30)
            return
        }

        // left key
        if (e.keyCode === leftKey) {
            if (element_number > 1) {
                $('#code-' + (element_number - 1)).focus()
                e.preventDefault()
                return
            }
        }
        // right key
        if (e.keyCode === rightKey || e.keyCode === tabKey) {
            if (element_number < maxCode) {
                $('#code-' + (element_number + 1)).focus()
                e.preventDefault()
                return
            }
        }
        if (e.keyCode === enterKey && $(this).data('code-number') === 5) {
            // submit code
            e.preventDefault()
            return
        }

        if ($.inArray(e.keyCode, numberKeys) !== -1) {
            $(this).val($(this).val().substring(0, 0))
            setTimeout(function(){
                if (element_number < maxCode) {
                    $('#code-' + (element_number + 1)).focus()
                }
            },30)
        }
    })

    $(document).on('click', '#btn-resend', function (e){
        $('#btn-resend').removeClass('active')
        $('#timer').addClass('active')
        startTimer(5)

    })

    $(document).on('click', '#btn-login-by-password', function (e){
        $('.form-data').removeClass('active')
        $('#form-password').addClass('active')
    })

    // form password
    $(document).on('click', '#btn-login-by-code', function (e){
        $('.form-data').removeClass('active')
        $('#form-code').addClass('active')
    })

    $(document).on('click', '#btn-password', function (e){
        e.preventDefault()
        $('.form-data').removeClass('active')
        $('#form-authenticator').addClass('active')
    })

    $(document).on('click', '#change-type-password', function (e){
        let type = $('#password').attr('type')
        if (type === 'password') {
            $('#password').attr('type', 'text')
            $(this).html('<i class="ki-duotone ki-eye-slash fs-1">\n' +
                '             <span class="path1"></span>\n' +
                '             <span class="path2"></span>\n' +
                '             <span class="path3"></span>\n' +
                '             <span class="path4"></span>\n' +
                '         </i>')
        } else {
            $('#password').attr('type', 'password')
            $(this).html('<i class="ki-duotone ki-eye fs-1">\n' +
                '             <span class="path1"></span>\n' +
                '             <span class="path2"></span>\n' +
                '             <span class="path3"></span>\n' +
                '         </i>')
        }
    })

    $(document).on('keyup', '#password', function (e){
        if ($(this).val().length > 0) {
            $('#change-type-password').addClass('active')
        } else {
            $('#change-type-password').removeClass('active')
        }
    })

    // form authenticator

    // form selection
    $(document).on('click', '.btn-selection', function (e){
        $('#loading').addClass('active')
        setTimeout(function (){
            $('#loading').removeClass('active')
        }, 3000)
    })
})
