<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Authio Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Authio for
    | various messages that we need to display to the user.
    |
    */

    "title" => "ورود به پنل کاربری",
    "description" => "برای ورود به پنل کاربری خود اطلاعات خود را وارد کنید",
    "keywords" => "ورود, پنل کاربری",

    "page" => [
        "auth" => [
            "title" => "همه چی از اینجا شروع میشه",
            "description" => "برای دسترسی به اطلاعات لطفا به یکی از روش های زیر وارد شوید.",
            "login_by" => "ورود با استفاده از:",
            "mobile" => "موبایل",
            "mobile_placeholder" => "موبایل را وارد کنید.",
            "email" => "ایمیل",
            "email_placeholder" => "ایمیل را وارد کنید.",
            "social_login" => "ورود با شبکه های اجتماعی",
        ],

        "code" => [
            "title" => "کد احراز هویت",
            "description" => "کد ارسال شده به موبایل خود را در باکس زیر وارد کنید.",
            "rules" => "با ورود به وبسایت قوانین و مقررات را می پذیرید."
        ],

        "password" => [
            "title" => "رمز عبور",
            "description" => "رمز عبور خود را در باکس زیر وارد کنید."
        ],

        "authenticator" => [
            "title" => "ورود دو مرحله ای",
            "description" => "کد ورود دو مرحله ای خود را در باکس زیر وارد کنید."
        ],

        "selection" => [
            "title" => "انتخاب روش ورود دو مرحله ای",
            "description" => "یکی از روش های ورود دو مرحله ای را انتخاب کنید.",
            "authenticator" => "اپلیکیشن احراز هویت",
            "sms" => "پیامک",
            "email" => "ایمیل",
        ],

        "buttons" => [
            "next" => "بعدی",
            "change" => "ویرایش شماره موبایل یا ایمیل",
            "resend" => "ارسال مجدد",
            "login_password" => "ورود با رمز عبور",
            "login_code" => "ورود با کد احراز هویت",
            "login" => "ورود",
        ],
    ],

    "exceptions" => [
        "user_deleted" => "کاربر :name حذف شده است."
    ],

    "rules" => [
        "mobile" => [
            "mobile_prefix_missing" => "فیلد پیش شماره موبایل :field مشخص نشده است.",
            "mobile_prefix_not_found" => "کشوری با پیش شماره :prefix پیدا نشد.",
            "validation_regex_missing" => "تنظیمات شماره‌گذاری کشور :country هنوز کامل نشده است.",
            "invalid_mobile_format" => "شماره موبایل وارد شده با الگوی شماره‌گذاری کشور :country مطابقت ندارد.",
        ]
    ],

];
