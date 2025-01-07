"use strict"

const auth = {
    init: {
        ready: function () {
            auth.config.toast()
        },
    },
    pages: {
        secret: null,
        has_password: false,
        source: null,
        login_type: null,
        auth: {
            type: 'mobile',
            changeType: function (element, e) {
                e.preventDefault()
                $('.form-auth-data-mode,.form-auth-change-data').removeClass('active')
                $(element).addClass('active')
                let elementType = $(element).data('type')
                $('#form-auth-' + elementType).addClass('active')
                auth.pages.auth.type = elementType
            },
            send: function (e) {
                e.preventDefault()
                $.ajax({
                    url: getLocalize('auth.route.request'),
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: getCsrfToken(),
                        type: auth.pages.auth.type,
                        mobile_prefix: $('#mobile-prefix').val(),
                        mobile: $('#mobile').val(),
                        email: $('#email').val(),
                    },
                    beforeSend: function () {
                        auth.loading.show()
                        $('.form-error').removeClass('active').text('')
                    },
                    complete: function () {
                        auth.loading.hide()
                    },
                    success: function (json) {
                        auth.pages.secret = json.data.secret
                        auth.pages.has_password = json.data.has_password
                        auth.pages.source = json.data.source
                        auth.pages.login_type = json.data.type

                        if (json.data.has_password) {
                            auth.pages.password.show()
                        } else {
                            auth.timer.start(json.data.code.timer)

                            auth.pages.code.show()
                        }
                    },
                    error: function (res) {
                        toastr.error(res.responseJSON.message)
                        $.each(res.responseJSON.errors, function (field, value) {
                            $('#error-' + field).addClass('active').text(value)
                        })
                    },
                })
            },
            backTo: function (e) {
                e.preventDefault()
                $('.form-data').removeClass('active')
                $('#form-auth').addClass('active')
            },
            enterKey: function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault()
                    auth.pages.auth.send(e)
                }
            },
        },
        code: {
            show: function () {
                $('.form-data').removeClass('active')
                $('#form-code').addClass('active')
                $('#code-1').focus()
            },
            fill: function (element, e) {
                let backspaceKey = 8;
                let deleteKey = 46;
                let tabKey = 9;
                let enterKey = 13;
                let escapeKey = 27;
                let leftKey = 37;
                let rightKey = 39;
                let validKeys = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 8, 46, 9, 13, 27, 16, 37, 39];
                let numberKeys = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];
                let maxCode = 5;

                let element_number = $(element).data('code-number')
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
                    $(element).val('')
                    setTimeout(function () {
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
                if (e.keyCode === enterKey && $(element).data('code-number') === 5) {
                    // submit code
                    e.preventDefault()
                    auth.pages.code.send(e)
                    return
                }

                if ($.inArray(e.keyCode, numberKeys) !== -1) {
                    $(element).val($(element).val().substring(0, 0))
                    setTimeout(function () {
                        if (element_number < maxCode) {
                            $('#code-' + (element_number + 1)).focus()
                        }
                    }, 30)
                }
            },
            getOtp: function () {
                let otp = '';
                for (let i = 1; i <= 5; i++) {
                    otp += $(`#code-${i}`).val();
                }
                return otp;
            },
            send: function (e) {
                e.preventDefault()
                $.ajax({
                    url: getLocalize('auth.route.otp'),
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: getCsrfToken(),
                        secret: auth.pages.secret,
                        otp: auth.pages.code.getOtp(),
                    },
                    beforeSend: function () {
                        auth.loading.show()
                        $('.form-error').removeClass('active').text('')
                    },
                    complete: function () {
                        auth.loading.hide()
                    },
                    success: function (json) {
                        toastr.success(json.message)

                        authio.token.set(json.data.token);

                        let backTo = getQueryParam('back')
                        if (backTo) {
                            window.location.href = backTo
                        } else {
                            window.location.href = '/'
                        }
                    },
                    error: function (res) {
                        toastr.error(res.responseJSON.message)
                        $.each(res.responseJSON.errors, function (field, value) {
                            $('#error-' + field).addClass('active').text(value)
                        })
                    },
                })
            },
            resend: function () {
                $.ajax({
                    url: getLocalize('auth.route.resend'),
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: getCsrfToken(),
                        secret: auth.pages.secret,
                    },
                    beforeSend: function () {
                        auth.loading.show()
                        $('.form-error').removeClass('active').text('')
                    },
                    complete: function () {
                        auth.loading.hide()
                    },
                    success: function (json) {
                        toastr.success(json.message)

                        auth.timer.start(json.data.code.timer)
                    },
                    error: function (res) {
                        toastr.error(res.responseJSON.message)
                        $.each(res.responseJSON.errors, function (field, value) {
                            $('#error-' + field).addClass('active').text(value)
                        })
                    },
                })
            },
        },
        password: {
            show: function () {
                $('.form-data').removeClass('active')
                $('#form-password').addClass('active')
                $('#password').focus()
            },
            changeType: {
                toggle: function (element) {
                    if ($(element).val().length > 0) {
                        $('#password + div').addClass('active')
                    } else {
                        $('#password + div').removeClass('active')
                    }
                },
                action: function (element) {
                    let type = $('#password').attr('type')
                    if (type === 'password') {
                        $('#password').attr('type', 'text')
                        $(element).html(`<i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>`)
                    } else {
                        $('#password').attr('type', 'password')
                        $(element).html(`<i class="ki-duotone ki-eye fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>`)
                    }
                },
            },
            send: function (e) {
                e.preventDefault()
                $.ajax({
                    url: getLocalize('auth.route.password'),
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: getCsrfToken(),
                        secret: auth.pages.secret,
                        password: $('#password').val(),
                    },
                    beforeSend: function () {
                        auth.loading.show()
                        $('.form-error').removeClass('active').text('')
                    },
                    complete: function () {
                        auth.loading.hide()
                    },
                    success: function (json) {
                        toastr.success(json.message)

                        authio.token.set(json.data.token);

                        let backTo = getQueryParam('back')
                        if (backTo) {
                            window.location.href = backTo
                        }
                    },
                    error: function (res) {
                        toastr.error(res.responseJSON.message)
                        $.each(res.responseJSON.errors, function (field, value) {
                            $('#error-' + field).addClass('active').text(value)
                        })
                    },
                })
            },
            enterKey: function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault()
                    auth.pages.password.send(e)
                }
            },
        },
        authenticator: {
            show: function () {
                $('.form-data').removeClass('active')
                $('#form-authenticator').addClass('active')
            },
        },
        selection: {
            show: function () {
                $('.form-data').removeClass('active')
                $('#form-selection').addClass('active')
            },
            select: function () {
                auth.loading.show()
                setTimeout(function () {
                    auth.loading.hide()
                }, 3000)
            },
        },
    },
    loading: {
        show: function () {
            $('#loading').addClass('active')
        },
        hide: function () {
            $('#loading').removeClass('active')
        }
    },
    timer: {
        interval: null,
        start: function (timer) {
            if (auth.timer.interval) {
                clearInterval(auth.timer.interval)
            }
            $('#timer').addClass('active').text(timer);
            auth.timer.interval = setInterval(function () {
                $('#timer').text(--timer);

                if (!timer) {
                    clearInterval(auth.timer.interval)
                    $('#timer').removeClass('active')
                }
            }, 1000);
        }
    },
    config: {
        toast: function () {
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
        },
    },
}

$(document).ready(function () {
    auth.init.ready()
})
