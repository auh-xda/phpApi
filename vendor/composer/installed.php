<?php return array(
    'root' => array(
        'name' => 'root/php-api',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'root/php-api' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'xdr/phpmodel' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'e0151cf578f6765f2301cceb0201a05853eae834',
            'type' => 'project',
            'install_path' => __DIR__ . '/../xdr/phpmodel',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
    ),
);
