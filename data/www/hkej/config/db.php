<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db1;dbname=hkej',
    'username' => 'hkej_admin',
    'password' => 'fr0nt1sql',
    'charset' => 'utf8mb4',


    // configuration for slaves
    'slaveConfig' => [
        'username' => 'hkej_admin',
        'password' => 'fr0nt1sql',
        'charset' => 'utf8mb4',
        'attributes' => [
            // use a smaller connection timeout
            PDO::ATTR_TIMEOUT => 10,
        ],
    ],

    // list of slave configurations
    'slaves' => [
        ['dsn' => 'mysql:host=db2;dbname=hkej'],
    ],
    //'
    //'schemaCachingDuration' => 86400,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

