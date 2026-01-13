<?php
return [
    /*
     * Configure the visible modules within BitCMS
     *
     * @example
     * 'modules'=> [
     *     ['title' => 'Pages', 'controller' => 'Pages', 'icon' => 'portfolio'],
     *     ['title' => 'Media', 'controller' => 'Images', 'icon' => 'photo-gallery'],
     * ]
     * Possible icons see: webroot/lib/stroke-7/demo.html
     */
    'modules' => [
        [
            'title' => __('Pages'),
            'controller' => 'Pages',
            'icon' => 'portfolio',
        ],
        [
            'title' => __('Images'),
            'controller' => 'Images',
            'icon' => 'photo-gallery',
        ],
    ],

    /*
     * Set the possible crop ratios
     * This will be used while cropping an image
     * The keys are the ratios (example 16 / 9 = 1.7777)
     * The values are just labels
     */
    'images' => [
        '1.7777777777777777' => '16:9',
        '1.3333333333333333' => '4:3',
        '1' => '1:1',
        '2.6' => 'Headers',
        '' => 'Crop freely',
    ],

    /*
     * Configure the email templates used within BitCMS
     * Each key represents a template name located in templates/email/bitcms/
     */
    'mails' => [
        'recaptha' => false,
        'honeypot' => false,
        'mailtrap' => [
            'token' => '',
            'sandbox' => true,
        ],
        'contact' => [
            'fromName' => 'My Application',
            'subject' => __('New contact email'),
        ],
    ]
];
