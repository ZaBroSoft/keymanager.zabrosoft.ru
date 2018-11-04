<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=localhost;dbname=yii2_basic_tests';

return $db;

/*
'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'zaikinnv@mail.ru',
                'password' => 'Drakoola101522',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl', // It is often used, check your provider or mail server specs
            ],
 */