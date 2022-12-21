<?php
return [
    'owner' => [
        'avatar' => 'Avatar',
        'sub_avatar' => 'Display avatar in user site.'
    ],
    'profile' => [
        'change_language' => 'Change language',
        'sub_change_language' => 'Change language for system',
        "sub_profile_info" => "Update your account's profile information and email address.",
        'sub_password' => 'Ensure your account is using a long, random password to stay secure.',
        'sub_two_authen' => 'Add additional security to your account using two factor authentication.',
        'two_authen' => [
            "title" => "You have not enabled two factor authentication.",
            'description' => "When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.",
            'title_sesion1' => 'Finish enabling two factor authentication.',
            'title_sesion2' => 'You have enabled two factor authentication.'
        ],
        'browser_session' => [
            'sub' => "Manage and log out your active sessions on other browsers and devices.",
            "description" => "If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.",
        ],
        "delete_owner" => [
            'sub' => 'Permanently delete your account.',
            'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'
        ]
    ],
    'description' => [
        'sub' => 'Briefly describe yourself such as goals, interests, ...'
    ]
];