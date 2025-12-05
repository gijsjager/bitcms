<?php
declare(strict_types=1);

namespace Bitcms\View;

use Cake\View\StringTemplate;

/**
 * FlexibleStringTemplate class extends StringTemplate for Bootstrap helpers.
 */
class FlexibleStringTemplate extends StringTemplate
{
    /**
     * General callback function.
     *
     * @var callable|null
     */
    protected $_callback = null;

    /**
     * Array of callback function for specific templates.
     *
     * @var array|null
     */
    protected $_callbacks = null;

    /**
     * Constructor.
     *
     * @param array $config A set of templates to add.
     * @param callable|null $callback General callback function.
     * @param array|null $callbacks Array of callback functions for specific templates.
     */
    public function __construct(array $config = [], $callback = null, $callbacks = null)
    {
        parent::__construct($config);
        $this->_callback = $callback;
        $this->_callbacks = $callbacks;
    }
}

