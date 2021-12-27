<?php

return [
    'exchanges' => [
        'core' => [
            'name' => 'core.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'core.alternate.x',
                'type' => 'fanout',
                'queue' => 'core.alternate.q'
            ],
            'queue' => [
                'demo' => [
                    'name' => 'core.demo.q',
                    'binding' => 'core.demo',
                    'durable' => true,
                    'autoDelete' => false
                ]
            ],
        ],
        'institute' => [
            'name' => 'institute.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'institute.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'institute.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'institute.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'courseEnrollment' => [
                    'name' => 'institute.course.enrollment.q',
                    'binding' => 'institute.course.enrollment',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'institute.course.enrollment.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ],
                'batchCalender' => [
                    'name' => 'institute.batch.calender.q',
                    'binding' => 'institute.batch.calender',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'institute.batch.calender.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
        'organization' => [
            'name' => 'organization.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'organization.alternate.x',
                'type' => 'fanout',
                'queue' => 'organization.alternate.q'
            ],
            'queue' => [
                'demo' => [
                    'name' => 'organization.demo.q',
                    'binding' => 'organization.demo',
                    'durable' => true,
                    'autoDelete' => false
                ]
            ],
        ],
        'youth' => [
            'name' => 'youth.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'youth.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'youth.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'youth.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'courseEnrollment' => [
                    'name' => 'youth.course.enrollment.q',
                    'binding' => 'youth.course.enrollment',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'youth.course.enrollment.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
        'cms' => [
            'name' => 'cms.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'cms.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'cms.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'cms.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'batchCalender' => [
                    'name' => 'cms.batch.calender.q',
                    'binding' => 'cms.batch.calender',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'cms.batch.calender.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
        'mailSms' => [
            'name' => 'mail.sms.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'mail.sms.alternate.x',
                'type' => 'fanout',
                'queue' => 'mail.sms.alternate.q'
            ],
            'dlx' => [
                'name' => 'mail.sms.dlx',
                'type' => 'fanout'
            ],
            'queue' => [
                'mail' => [
                    'name' => 'mail.q',
                    'binding' => 'mail',
                    'durable' => true,
                    'autoDelete' => false,
                    'dlq' => [
                        'name' => 'mail.sms.dlq',
                        'x_message_ttl' => 50000
                    ],
                ],
                'sms' => [
                    'name' => 'sms.q',
                    'binding' => 'sms',
                    'durable' => true,
                    'autoDelete' => false,
                    'dlq' => [
                        'name' => 'mail.sms.dlq',
                        'x_message_ttl' => 50000
                    ],
                ]
            ]
        ]
    ],
    'consume' => ''
];
