<?php
declare(strict_types=1);

namespace Bitcms\View\Helper;

/**
 * Html Helper class for easy use of HTML widgets with Bootstrap 4 styling.
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class HtmlHelper extends \Cake\View\Helper\HtmlHelper
{
    use ClassTrait;
    use EasyIconTrait;

    /**
     * Default config for the helper.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'meta' => '<meta{{attrs}}/>',
            'metalink' => '<link href="{{url}}"{{attrs}}/>',
            'link' => '<a href="{{url}}"{{attrs}}>{{content}}</a>',
            'mailto' => '<a href="mailto:{{url}}"{{attrs}}>{{content}}</a>',
            'image' => '<img src="{{url}}"{{attrs}}/>',
            'tableheader' => '<th{{attrs}}>{{content}}</th>',
            'tableheaderrow' => '<tr{{attrs}}>{{content}}</tr>',
            'tablecell' => '<td{{attrs}}>{{content}}</td>',
            'tablerow' => '<tr{{attrs}}>{{content}}</tr>',
            'block' => '<div{{attrs}}>{{content}}</div>',
            'blockstart' => '<div{{attrs}}>',
            'blockend' => '</div>',
            'tag' => '<{{tag}}{{attrs}}>{{content}}</{{tag}}>',
            'tagstart' => '<{{tag}}{{attrs}}>',
            'tagend' => '</{{tag}}>',
            'tagselfclosing' => '<{{tag}}{{attrs}}/>',
            'para' => '<p{{attrs}}>{{content}}</p>',
            'parastart' => '<p{{attrs}}>',
            'css' => '<link rel="{{rel}}" href="{{url}}"{{attrs}}/>',
            'style' => '<style{{attrs}}>{{content}}</style>',
            'charset' => '<meta charset="{{charset}}"/>',
            'ul' => '<ul{{attrs}}>{{content}}</ul>',
            'ol' => '<ol{{attrs}}>{{content}}</ol>',
            'li' => '<li{{attrs}}>{{content}}</li>',
            'javascriptblock' => '<script{{attrs}}>{{content}}</script>',
            'javascriptstart' => '<script>',
            'javascriptlink' => '<script src="{{url}}"{{attrs}}></script>',
            'javascriptend' => '</script>',

            // New templates for Bootstrap
            'icon' => '<i aria-hidden="true" class="fa fa-{{type}}{{attrs.class}}"{{attrs}}></i>',
            'badge' => '<span class="badge badge-{{type}}{{attrs.class}}"{{attrs}}>{{content}}</span>',
            'alert' => '<div class="alert alert-{{type}}{{attrs.class}}" role="alert"{{attrs}}>{{close}}{{content}}</div>',
            'alertCloseButton' =>
                '<button type="button" class="close{{attrs.class}}" data-dismiss="alert" aria-label="{{label}}"{{attrs}}>{{content}}</button>',
            'alertCloseContent' => '<span aria-hidden="true">&times;</span>',
            'tooltip' => '<{{tag}} data-toggle="{{toggle}}" data-placement="{{placement}}" title="{{tooltip}}"{{attrs}}>{{content}}</{{tag}}>',
            'progressBar' =>
    '<div class="progress-bar bg-{{type}}{{attrs.class}}" role="progressbar"
aria-valuenow="{{width}}" aria-valuemin="{{min}}" aria-valuemax="{{max}}" style="width: {{width}}%;"{{attrs}}>{{inner}}</div>',
            'progressBarInner' => '<span class="sr-only">{{width}}%</span>',
            'progressBarContainer' => '<div class="progress{{attrs.class}}"{{attrs}}>{{content}}</div>',
            'dropdownMenu' => '<div class="dropdown-menu{{attrs.class}}"{{attrs}}>{{content}}</div>',
            'dropdownMenuItem' => '<a href="{{url}}" class="dropdown-item{{attrs.class}}"{{attrs}}>{{content}}</a>',
            'dropdownMenuHeader' => '<h6 class="dropdown-header{{attrs.class}}"{{attrs}}>{{content}}</h6>',
            'dropdownMenuDivider' => '<div role="separator" class="dropdown-divider{{attrs.class}}"{{attrs}}></div>',
            'confirmJs' => '{{confirm}}',
        ],
        'templateClass' => 'Bitcms\View\EnhancedStringTemplate',
        'tooltip' => [
            'tag' => 'span',
            'placement' => 'right',
            'toggle' => 'tooltip',
        ],
        'badge' => [
            'type' => 'default',
        ],
        'alert' => [
            'type' => 'warning',
            'close' => true,
        ],
        'progress' => [
            'type' => 'primary',
        ],
        'buttons' => [
            'type' => 'primary',
        ],
    ];

    /**
     * Create an icon using the template `icon`.
     *
     * @param string $icon Name of the icon.
     * @param array $options Array of options.
     * @return string The HTML icon.
     */
    public function icon(string $icon, array $options = []): string
    {
        $options += [
            'templateVars' => [],
        ];

        return $this->formatTemplate('icon', [
            'type' => $icon,
            'attrs' => $this->templater()->formatAttributes($options),
            'templateVars' => $options['templateVars'],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function link($title, $url = null, array $options = []): string
    {
        [$options, $easyIcon] = $this->_easyIconOption($options);

        return $this->_injectIcon(parent::link($title, $url, $options), $easyIcon);
    }

    /**
     * Create a Twitter Bootstrap badge.
     *
     * @param string $text The badge text.
     * @param string|array|null $type The badge type or the array of options.
     * @param array $options Array of options.
     * @return string
     */
    public function badge(string $text, $type = null, array $options = []): string
    {
        if (is_string($type)) {
            $options['type'] = $type;
        } elseif (is_array($type)) {
            $options = $type;
        }
        $options += $this->getConfig('badge') + [
           'templateVars' => [],
        ];

        return $this->formatTemplate('badge', [
           'type' => $options['type'],
           'content' => $text,
           'attrs' => $this->templater()->formatAttributes($options, ['type']),
           'templateVars' => $options['templateVars'],
        ]);
    }

    /**
     * Create a Twitter Bootstrap style alert block.
     *
     * @param string $text The alert text.
     * @param string|array|null $type The type of the alert.
     * @param array $options Array of options.
     * @return string A HTML bootstrap alert element.
     */
    public function alert(string $text, $type = null, array $options = []): string
    {
        if (is_string($type)) {
            $options['type'] = $type;
        } elseif (is_array($type)) {
            $options = $type;
        }
        $options += $this->getConfig('alert') + [
            'templateVars' => [],
        ];
        $close = null;
        if ($options['close']) {
            $closeContent = $this->formatTemplate('alertCloseContent', [
                'templateVars' => $options['templateVars'],
            ]);
            $close = $this->formatTemplate('alertCloseButton', [
                'label' => __('Close'),
                'content' => $closeContent,
                'attrs' => $this->templater()->formatAttributes([]),
                'templateVars' => $options['templateVars'],
            ]);
            $options = $this->addClass($options, 'alert-dismissible');
        }

        return $this->formatTemplate('alert', [
            'type' => $options['type'],
            'close' => $close,
            'content' => $text,
            'attrs' => $this->templater()->formatAttributes($options, ['close', 'type']),
            'templateVars' => $options['templateVars'],
        ]);
    }

    /**
     * Create a Twitter Bootstrap style tooltip.
     *
     * @param string $text The HTML tag inner text.
     * @param string $tooltip The tooltip text.
     * @param array  $options Array of options.
     * @return string The text wrapped in the specified HTML tag with a tooltip.
     */
    public function tooltip(string $text, string $tooltip, array $options = []): string
    {
        $options += $this->getConfig('tooltip') + [
            'tooltip' => $tooltip,
            'templateVars' => [],
        ];

        return $this->formatTemplate('tooltip', [
            'content' => $text,
            'attrs' => $this->templater()->formatAttributes($options, ['tag', 'toggle', 'placement', 'tooltip']),
            'templateVars' => array_merge($options, $options['templateVars']),
        ]);
    }

    /**
     * Create a Twitter Bootstrap style progress bar.
     *
     * @param int|array $widths Progress width
     * @param array $options Array of options.
     * @return string The HTML bootstrap progress bar.
     */
    public function progress($widths, array $options = []): string
    {
        $options += $this->getConfig('progress') + [
            'striped' => false,
            'active' => false,
            'min' => 0,
            'max' => 100,
            'templateVars' => [],
        ];
        if (!is_array($widths)) {
            $widths = [
                ['width' => $widths],
            ];
        }
        $bars = '';
        foreach ($widths as $width) {
            $width += $options;
            if ($width['striped']) {
                $width = $this->addClass($width, 'progress-bar-striped');
            }
            if ($width['active']) {
                $width = $this->addClass($width, 'progress-bar-striped progress-bar-animated');
            }
            $inner = $this->formatTemplate('progressBarInner', [
                'width' => $width['width'],
            ]);

            $bars .= $this->formatTemplate('progressBar', [
                'inner' => $inner,
                'type' => $width['type'],
                'min' => $width['min'],
                'max' => $width['max'],
                'width' => $width['width'],
                'attrs' => $this->templater()->formatAttributes(
                    $width,
                    ['striped', 'active', 'min', 'max', 'type', 'width']
                ),
                'templateVars' => $width['templateVars'],
            ]);
        }

        return $this->formatTemplate('progressBarContainer', [
            'content' => $bars,
            'attrs' => $this->templater()->formatAttributes([]),
            'templateVars' => $options['templateVars'],
        ]);
    }
}

