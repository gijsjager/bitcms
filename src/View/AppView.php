<?php
namespace Bitcms\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        die('here');

        // Bootstrap helpers
        $this->loadHelper('Breadcrumbs', [
            'className' => 'Bootstrap.Breadcrumbs',
        ]);
        $this->loadHelper('Html', [
            'className' => 'Bootstrap.Html',
            'buttons' => ['type' => 'primary'],
        ]);
        $this->loadHelper('Form', [
            'className' => 'Bootstrap.Form',
            'buttons' => ['type' => 'primary'],
            'templates' => [
                'inputContainer' => '<div class="form-group {{attrs}}{{type}}{{required}}">{{content}}</div>',
                'checkboxWrapper' => '<div class="custom-control custom-checkbox ">{{label}}</div>',
                'checkboxContainer' => '<div class="custom-control custom-checkbox {{required}}">{{content}}</div>',
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}><span class="custom-control-indicator custom-control-color"></span>',
                'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>'],
        ]);
        $this->loadHelper('Paginator', [
            'className' => 'Bootstrap.Paginator',
            'templates' => [
                'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'nextDisabled' => '<li class="page-item disabled"><a class="page-link">{{text}}</a></li>',
                'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'prevDisabled' => '<li class="page-item disabled"><a class="page-link">{{text}}</a></li>',
                'first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            ]
        ]);

        $this->loadHelper('Time');
        $this->loadHelper('Content');

    }
}
