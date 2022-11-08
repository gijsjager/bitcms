<?php
return [
    /**
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
        ]
    ]
];
