<?php

namespace BinaryCastle\Boilerplate\Static;

class Installer
{
    public static string $VERIFY_FILE_NAME = 'verify.txt';

    public static string $VERIFIER_URL = 'https://erp.binarycastle.net/purchase-verifier';

    public static array $WHITELISTED_URLS = [
        'installer', 'installer/requirements', 'installer/verify', 'installer/permissions',
        'installer/intro',
    ];

    public static string $VERIFY_REDIRECT_URL = '/installer/verify';

    public static string $BASE_INSTALL_URL = '/installer';
}
