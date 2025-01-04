"use strict"

const authio = {
    init: {
        ready: function () {
            authio.config.toast()
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
                authio.pages.auth.type = elementType
            },
            send: function (e) {
                e.preventDefault()
                $.ajax({
                    url: localize.auth.route.request,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: getCsrfToken(),
                        type: authio.pages.auth.type,
                        mobile_prefix: $('#mobile-prefix').val(),
                        mobile: $('#mobile').val(),
                        email: $('#email').val(),
                    },
                    beforeSend: function () {
                        authio.loading.show()
                        $('.form-error').removeClass('active').text('')
                    },
                    complete: function () {
                        authio.loading.hide()
                    },
                    success: function (json) {
                        authio.pages.secret = json.data.secret
                        authio.pages.has_password = json.data.has_password
                        authio.pages.source = json.data.source
                        authio.pages.login_type = json.data.type

                        if (json.data.has_password) {
                            authio.pages.password.show()
                        } else {
                            authio.pages.code.show()
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
                    authio.pages.auth.send(e)
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
            send: function () {
            },
            resend: function () {
                $('#btn-resend').removeClass('active')
                $('#timer').addClass('active')
                authio.timer.start(60)
            }
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
                authio.pages.selection.show()
            }
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
                authio.loading.show()
                setTimeout(function () {
                    authio.loading.hide()
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
            if (authio.timer.interval) {
                clearInterval(authio.timer.interval)
            }
            $('#timer').text(timer);
            authio.timer.interval = setInterval(function () {
                $('#timer').text(--timer);

                if (!timer) {
                    clearInterval(authio.timer.interval)
                    $('#timer').removeClass('active')
                    $('#btn-resend').addClass('active')
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
    authio.init.ready()
})
