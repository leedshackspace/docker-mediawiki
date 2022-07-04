<?php

$config = [
    // This is a authentication source which handles admin authentication.
    'admin' => [
        'core:AdminPassword',
    ],


    // An authentication source which can authenticate against both SAML 2.0
    // and Shibboleth 1.3 IdPs.
    'default-sp' => [
        'saml:SP',

        'entityID' => null,

        'idp' => null,

        'discoURL' => null,
    ],
];