<?php
return [
    'Dns' => [
        'handler' => process\DnsProcess::class,
        'listen'  => 'Dns://0.0.0.0:53',
        'transport'  => 'udp',
        'count' => cpu_count() * 4
    ],
];