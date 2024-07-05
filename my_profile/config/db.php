<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhostまたはDBのホスト名;dbname=作成したDB名',
    'username' => 'DBのユーザー名',
    'password' => 'DBのユーザーパスワード',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
