<?php
declare(strict_types=1);

namespace Bitcms\View\Helper;

use Bitcms\View\FlexibleStringTemplateTrait;

/**
 * Form helper library with Bootstrap 4 styling.
 *
 * @property \Bitcms\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class FormHelper extends \Cake\View\Helper\FormHelper
{
    use ClassTrait;
    use EasyIconTrait;
    use FlexibleStringTemplateTrait;

    /**
     * Other helpers used by FormHelper.
     *
     * @var array
     */
    protected array $helpers = [
        'Url',
        'Html' => ['className' => 'Bitcms.Html'],
    ];

    /**
     * Default configuration for the helper.
     *
     * @var array
     */
    protected array $_defaultConfig = [
        'idPrefix' => null,
        'errorClass' => 'is-invalid',
        'typeMap' => [
            'string' => 'text', 'datetime' => 'datetime', 'boolean' => 'checkbox',
            'timestamp' => 'datetime', 'text' => 'textarea', 'time' => 'time',
            'date' => 'date', 'float' => 'number', 'integer' => 'number',
            'decimal' => 'number', 'binary' => 'file', 'uuid' => 'string',
        ],

        'templates' => [
            'button' => '<button{{attrs}}>{{text}}</button>',
            'checkbox' => '<input type="checkbox" class="form-check-input{{attrs.class}}" name="{{name}}" value="{{value}}"{{attrs}}>',
            'checkboxFormGroup' => '{{label}}',
            'checkboxWrapper' => '<div class="form-check">{{label}}</div>',
            'checkboxContainer' => '<div class="form-check checkbox{{required}}">{{content}}</div>',
            'checkboxContainerHorizontal' => '<div class="form-group row"><div class="{{labelColumnClass}}"></div><div class="{{inputColumnClass}}"><div class="form-check checkbox{{required}}">{{content}}</div></div></div>',
            'multicheckboxContainer' => '<fieldset class="form-group {{type}}{{required}}">{{content}}</fieldset>',
            'multicheckboxContainerHorizontal' => '<fieldset class="form-group {{type}}{{required}}"><div class="row">{{content}}</div></fieldset>',
            'dateWidget' => '<div class="row">{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}</div>',
            'error' => '<div class="error-message invalid-feedback">{{content}}</div>',
            'errorInline' => '<div class="error-message invalid-feedback">{{content}}</div>',
            'errorList' => '<ul>{{content}}</ul>',
            'errorItem' => '<li>{{text}}</li>',
            'file' => '<input type="file" name="{{name}}" {{attrs}}>',
            'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
            'formStart' => '<form{{attrs}}>',
            'formEnd' => '</form>',
            'formGroup' => '{{label}}{{prepend}}{{input}}{{append}}',
            'formGroupHorizontal' => '{{label}}<div class="{{inputColumnClass}}">{{prepend}}{{input}}{{append}}{{error}}</div>',
            'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
            'input' => '<input type="{{type}}" name="{{name}}" class="form-control{{attrs.class}}" {{attrs}} />',
            'inputSubmit' => '<input type="{{type}}"{{attrs}}>',
            'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
            'inputContainerHorizontal' => '<div class="form-group row {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="form-group has-error {{type}}{{required}}">{{content}}{{error}}</div>',
            'inputContainerErrorHorizontal' => '<div class="form-group row has-error {{type}}{{required}}">{{content}}</div>',
            'label' => '<label{{attrs}}>{{text}}</label>',
            'labelHorizontal' => '<label class="col-form-label {{labelColumnClass}}{{attrs.class}}"{{attrs}}>{{text}}</label>',
            'labelInline' => '<label class="sr-only{{attrs.class}}"{{attrs}}>{{text}}</label>',
            'nestingLabel' => '{{hidden}}<label class="form-check-label{{attrs.class}}"{{attrs}}>{{input}} {{text}}</label>',
            'legend' => '<legend>{{text}}</legend>',
            'labelLegend' => '<label{{attrs}}>{{text}}</label>',
            'labelLegendHorizontal' => '<legend class="col-form-label pt-0 {{labelColumnClass}}{{attrs.class}}"{{attrs}}>{{text}}</legend>',
            'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
            'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
            'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
            'selectMultiple' => '<select name="{{name}}[]" multiple="multiple" class="form-control{{attrs.class}}" {{attrs}}>{{content}}</select>',
            'radio' => '<input type="radio" class="form-check-input{{attrs.class}}" name="{{name}}" value="{{value}}"{{attrs}}>',
            'radioWrapper' => '<div class="form-check">{{label}}</div>',
            'radioContainer' => '<fieldset class="form-group {{type}}{{required}}">{{content}}</fieldset>',
            'radioContainerHorizontal' => '<fieldset class="form-group {{type}}{{required}}"><div class="row">{{content}}</div></fieldset>',
            'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
            'submitContainer' => '<div class="form-group">{{content}}</div>',
            'submitContainerHorizontal' => '<div class="form-group row"><div class="{{labelColumnClass}}"></div><div class="{{inputColumnClass}}">{{content}}</div></div>',

            'inputGroup' => '{{inputGroupStart}}{{input}}{{inputGroupEnd}}',
            'inputGroupStart' => '<div class="input-group">{{prepend}}',
            'inputGroupEnd' => '{{append}}</div>',
            'inputGroupAddons' => '<div class="input-group-{{type}}">{{content}}</div>',
            'inputGroupText' => '<span class="input-group-text">{{content}}</span>',
            'helpBlock' => '<small class="help-block form-text text-muted">{{content}}</small>',
            'buttonGroup' => '<div class="btn-group{{attrs.class}}" role="group"{{attrs}}>{{content}}</div>',
            'buttonGroupVertical' => '<div class="btn-group-vertical{{attrs.class}}" role="group"{{attrs}}>{{content}}</div>',
            'buttonToolbar' => '<div class="btn-toolbar{{attrs.class}}" role="toolbar"{{attrs}}>{{content}}</div>',
            'confirmJs' => '{{confirm}}',
        ],
        'buttons' => [
            'type' => 'primary',
        ],
        'columns' => [
            'md' => [
                'label' => 2,
                'input' => 10,
            ],
        ],
    ];

    /**
     * Indicates if horizontal mode is enabled.
     *
     * @var bool
     */
    public bool $horizontal = false;

    /**
     * Indicates if inline mode is enabled.
     *
     * @var bool
     */
    public bool $inline = false;

    /**
     * {@inheritDoc}
     */
    public function __construct(\Cake\View\View $View, array $config = [])
    {
        if (!isset($config['templateCallback'])) {
            $that = $this;
            $config['templateCallback'] = function ($name, $data) use ($that) {
                $data['templateName'] = $name;
                if ($that->horizontal) {
                    $data['templateName'] .= 'Horizontal';
                } elseif ($that->inline) {
                    $data['templateName'] .= 'Inline';
                }
                $data += [
                    'inputColumnClass' => $this->_getColumnClass('input'),
                    'labelColumnClass' => $this->_getColumnClass('label'),
                ];
                if (!$that->getTemplates($data['templateName'])) {
                    $data['templateName'] = $name;
                }

                return $data;
            };
        }
        parent::__construct($View, $config);
    }

    /**
     * Returns an HTML form element.
     *
     * @param mixed $context The context for which the form is being defined.
     * @param array $options An array of html attributes and options.
     * @return string An formatted opening FORM tag.
     */
    public function create($context = null, array $options = []): string
    {
        $options += [
            'horizontal' => false,
            'inline' => false,
        ];
        $this->horizontal = $options['horizontal'];
        $this->inline = $options['inline'];
        unset($options['horizontal'], $options['inline']);
        if ($this->horizontal) {
            $options = $this->addClass($options, 'form-horizontal');
        } elseif ($this->inline) {
            $options = $this->addClass($options, 'form-inline');
        }
        $options['role'] = 'form';

        return parent::create($context, $options);
    }

    /**
     * Get the column sizes configuration.
     *
     * @return array
     */
    public function getColumnSizes(): array
    {
        return $this->getConfig('columns');
    }

    /**
     * Set the column sizes configuration.
     *
     * @param array $columns Array of columns options to set
     * @return $this
     */
    public function setColumnSizes(array $columns)
    {
        $this->setConfig('columns', $columns, false);
        return $this;
    }

    /**
     * Retrieve classes for the size of the specified column.
     *
     * @param string $what The type of the column (`'label'`, `'input'`, `'error'`).
     * @return string The classes for the size or offset of the specified column.
     */
    protected function _getColumnClass(string $what): string
    {
        $columns = $this->getConfig('columns');
        $classes = [];
        foreach ($columns as $cl => $arr) {
            if (!isset($arr[$what])) {
                continue;
            }
            $value = $arr[$what];
            $classes[] = 'col-' . $cl . '-' . $value;
        }

        return implode(' ', $classes);
    }

    /**
     * Wraps the given string inside a HTML wrapper element.
     *
     * @param string|array|null $addonOrButtons Content to be wrapped.
     * @param string $type Input group type
     * @return string|null The elements wrapped in a suitable HTML element.
     */
    protected function _wrapInputGroup($addonOrButtons, string $type): ?string
    {
        if ($addonOrButtons) {
            if (is_array($addonOrButtons)) {
                $addonOrButtons = implode('', $addonOrButtons);
            } else {
                $addonOrButtons = $this->_makeIcon($addonOrButtons);
            }

            $isButton = strpos($addonOrButtons, '<button') === 0;
            $isDropdown = strpos($addonOrButtons, 'data-toggle="dropdown"') !== false;
            if (!$isButton && !$isDropdown) {
                $addonOrButtons = $this->formatTemplate('inputGroupText', [
                    'content' => $addonOrButtons,
                ]);
            }

            $addonOrButtons = $this->formatTemplate('inputGroupAddons', [
                'type' => strtolower($type),
                'content' => $addonOrButtons,
            ]);
        }

        return $addonOrButtons;
    }

    /**
     * Concatenates and wraps input, prepend and append inside an input group.
     *
     * @param string $input The input content.
     * @param string|null $prepend The content to prepend to input.
     * @param string|null $append The content to append to input.
     * @return string A string containing the three elements concatenated.
     */
    protected function _wrap(string $input, ?string $prepend, ?string $append): string
    {
        return $this->formatTemplate('inputGroup', [
            'inputGroupStart' => $this->formatTemplate('inputGroupStart', [
                'prepend' => $prepend,
            ]),
            'input' => $input,
            'inputGroupEnd' => $this->formatTemplate('inputGroupEnd', [
                'append' => $append,
            ]),
        ]);
    }

    /**
     * Prepend the given content to the given input.
     *
     * @param string|null $input Input to which prepend will be prepend.
     * @param string|array $prepend The content to prepend.
     * @return string The input with the content prepended.
     */
    public function prepend(?string $input, $prepend): string
    {
        $prepend = $this->_wrapInputGroup($prepend, 'prepend');
        if ($input === null) {
            return $this->formatTemplate('inputGroupStart', ['prepend' => $prepend]);
        }

        return $this->_wrap($input, $prepend, null);
    }

    /**
     * Append the given content to the given input.
     *
     * @param string|null $input Input to which append will be append.
     * @param string|array|null $append The content to append.
     * @return string The input with the content appended.
     */
    public function append(?string $input, $append = null): string
    {
        $append = $this->_wrapInputGroup($append, 'append');
        if ($input === null) {
            return $this->formatTemplate('inputGroupEnd', ['append' => $append]);
        }

        return $this->_wrap($input, null, $append);
    }

    /**
     * Wrap the given input between prepend and append.
     *
     * @param string $input The input to be wrapped.
     * @param string|array $prepend The content to prepend.
     * @param string|array $append The content to append.
     * @return string A string containing the given input wrapped.
     */
    public function wrap(string $input, $prepend, $append): string
    {
        return $this->prepend(null, $prepend) . $input . $this->append(null, $append);
    }

    /**
     * Generates a form input element complete with label and wrapper div.
     *
     * @param string $fieldName This should be "modelname.fieldname"
     * @param array $options Each type of input takes different options.
     * @return string Completed form widget.
     */
    public function control(string $fieldName, array $options = []): string
    {
        $options += [
            'prepend' => null,
            'append' => null,
            'help' => null,
            'templateVars' => [],
        ];

        $prepend = $options['prepend'];
        $append = $options['append'];
        $help = $options['help'];
        unset(
            $options['prepend'],
            $options['append'],
            $options['help']
        );

        if ($prepend || $append) {
            $prepend = $this->prepend(null, $prepend);
            $append = $this->append(null, $append);
        }

        if ($help) {
            $append .= $this->formatTemplate('helpBlock', ['content' => $help]);
        }

        $options['templateVars'] += [
            'prepend' => $prepend,
            'append' => $append,
        ];

        return parent::control($fieldName, $options);
    }

    /**
     * Creates a textarea widget.
     *
     * @param string $fieldName Name attribute of the textarea
     * @param array $options Array of HTML attributes, and special options above.
     * @return string A generated HTML text input element
     */
    public function textarea(string $fieldName, array $options = []): string
    {
        $options = $this->addClass($options, 'form-control');
        return parent::textarea($fieldName, $options);
    }

    /**
     * Creates a select widget.
     *
     * @param string $fieldName Name attribute of the textarea
     * @param iterable $options Array of HTML attributes, and special options above.
     * @return string A generated HTML text input element
     */
    public function select(string $fieldName, iterable $options = [], array $attributes = []): string
    {
        $attributes = $this->addClass($attributes, 'form-control');
        return parent::select($fieldName, $options, $attributes);
    }


    /**
     * Creates a button tag.
     *
     * @param string $title The button's caption.
     * @param array $options Button options
     * @return string A HTML button tag.
     */
    public function button(string $title, array $options = []): string
    {
        [$options, $easyIcon] = $this->_easyIconOption($options);

        return $this->_injectIcon(parent::button($title, $this->_addButtonClasses($options)), $easyIcon);
    }

    /**
     * Creates a submit button element.
     *
     * @param string|null $caption The label appearing on the button OR if string contains :// or the
     *  extension .jpg, .jpe, .jpeg, .gif, .png use an image if the extension
     *  exists, AND the first character is /, image is relative to webroot,
     *  OR if the first character is not /, image is relative to webroot/img.
     * @param array $options Array of options.
     * @return string A HTML submit button
     */
    public function submit(?string $caption = null, array $options = []): string
    {
        return parent::submit($caption, $this->_addButtonClasses($options));
    }

    /**
     * Creates a button group using the given buttons.
     *
     * @param array $buttons Array of buttons for the group.
     * @param array $options Array of options.
     * @return string A HTML string containing the button group.
     */
    public function buttonGroup(array $buttons, array $options = []): string
    {
        $options += [
            'vertical' => false,
            'templateVars' => [],
        ];
        $template = 'buttonGroup';
        if ($options['vertical']) {
            $template = 'buttonGroupVertical';
        }

        return $this->formatTemplate($template, [
            'content' => implode('', $buttons),
            'attrs' => $this->templater()->formatAttributes($options, ['vertical']),
            'templateVars' => $options['templateVars'],
        ]);
    }

    /**
     * Creates a button toolbar using the given button groups.
     *
     * @param array $buttonGroups Array of groups for the toolbar
     * @param array $options Array of options.
     * @return string A HTML string containing the button toolbar.
     */
    public function buttonToolbar(array $buttonGroups, array $options = []): string
    {
        $options += [
            'templateVars' => [],
        ];

        return $this->formatTemplate('buttonToolbar', [
            'content' => implode('', $buttonGroups),
            'attrs' => $this->templater()->formatAttributes($options, ['vertical']),
            'templateVars' => $options['templateVars'],
        ]);
    }
}

