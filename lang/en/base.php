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

    "title" => "Login to user panel",
    "description" => "Enter your information to log in to your user panel",
    "keywords" => "login, user panel",

    "page" => [
        "auth" => [
            "title" => "Everything starts from here",
            "description" => "To access the information, please log in using one of the following methods.",
            "login_by" => "Login by:",
            "mobile" => "Mobile",
            "mobile_placeholder" => "Enter your mobile number.",
            "email" => "Email",
            "email_placeholder" => "Enter your email.",
            "social_login" => "Login with social networks",
        ],

        "code" => [
            "title" => "Authentication code",
            "description" => "Enter the code sent to your mobile in the box below.",
            "rules" => "By entering the website, you accept the rules and regulations."
        ],

        "password" => [
            "title" => "Password",
            "description" => "Enter your password in the box below."
        ],

        "authenticator" => [
            "title" => "Two-step login",
            "description" => "Enter your two-step login code in the box below."
        ],

        "selection" => [
            "title" => "Select two-step login method",
            "description" => "Select one of the two-step login methods.",
            "authenticator" => "Authentication app",
            "sms" => "SMS",
            "email" => "Email",
        ],

        "buttons" => [
            "next" => "Next",
            "change" => "Edit mobile number or email",
            "resend" => "Resend",
            "login_password" => "Login with password",
            "login_code" => "Login with authentication code",
            "login" => "Login",
        ],
    ],

    "exceptions" => [
        "user_deleted" => "User :name has been deleted.",
        "ip_not_match" => "Your IP does not match the IP registered for this user.",
        "expire_secret" => "The security code has expired.",
        "resend_try_count" => "The number of resends is exceeded.",
        "user_not_match" => "The user does not match the provided information.",
        "unauthorized" => "You are not authorized.",
        "password_not_found" => "Password not found.",
    ],

    "messages" => [
        "request" => "The check is done and you will go to the next step.",
        "login" => "You will be logged into your panel in a few moments.",
        "resend" => "The code has been sent again.",
        "locked" => "Please try again after :time seconds.",
    ],

    "rules" => [
        "mobile" => [
            "mobile_prefix_missing" => "The mobile prefix field :field is not specified.",
            "mobile_prefix_not_found" => "No country found with the prefix :prefix.",
            "validation_regex_missing" => "The numbering configuration for the country :country is incomplete.",
            "invalid_mobile_format" => "The provided mobile number does not match the numbering format of :country.",
        ],
        "secret_exists" => "The :attribute for this page is already used.",
    ],

];
