<?php
declare(strict_types=1);

namespace Bitcms\View\Helper;

/**
 * BreadcrumbsHelper to register and display a breadcrumb trail for your views
 * with Bootstrap 4 styling.
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class BreadcrumbsHelper extends \Cake\View\Helper\BreadcrumbsHelper
{
    /**
     * Default config for the helper.
     *
     * @var array
     */
    protected array $_defaultConfig = [
        'templates' => [
            'wrapper' => '<ol class="breadcrumb{{attrs.class}}"{{attrs}}>{{content}}</ol>',
            'item' => '<li class="breadcrumb-item{{attrs.class}}"{{attrs}}><a href="{{url}}"{{innerAttrs}}>{{title}}</a></li>',
            'itemWithoutLink' => '<li class="breadcrumb-item active{{attrs.class}}" aria-current="page"{{attrs}}>{{title}}</li>',
            'separator' => '',
        ],
        'templateClass' => 'Bitcms\View\EnhancedStringTemplate',
    ];
}

