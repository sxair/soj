<?php
return [
    'TEST_MAX' => 10000,
    'status' => [
        0 => 'Queuing',
        1 => 'Compiling',
        2 => 'Compilation error',
        3 => 'Accepted',
        4 => 'System Error',
        /*base of test_max*/
        5 => 'Running',
        6 => 'Wrong Answer',
        7 => 'Memory Limit Exceeded',
        8 => 'Output Limit Exceeded',
        9 => 'Time Limit Exceeded',
        10 => 'Presentation Error',
        11 => 'Runtime Error',
        12 => 'Runtime Error</br>(Segmentation fault)',
        13 => 'Runtime Error</br>(Floating Point Exception)',
        14 => 'Runtime Error</br>(NOT ALLOWED SYSTEM CALL)',
    ],
    'lang' => [
        1 => 'c',
        2 => 'c++',
        3 => 'java',
        4 => 'python2',
        5 => 'python3'
    ],
    'user' =>[
        'login' => 1,
        'submit' => 2,
    ],
    'admin' => [
        // base control
        'control' => 0x00000001,
        'addProblem' => 0x00000002,
    ]
];