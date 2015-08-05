<?php

namespace Gourmet\SocialMeta\View\Helper;

use Cake\Routing\Router;
use Cake\View\Helper;
use Cake\View\View;

class CardHelper extends Helper
{
    use MetaTagAwareTrait;

    public $helpers = ['Html'];

    protected $_defaultConfig = [
        'viewBlockName' => 'smCards',
        'card' => 'summary',
        'url' => null,
        'tags' => []
    ];

    /**
     * Constructor
     *
     * @param \Cake\View\View $View View instance.
     * @param array $config Config
     */
    public function __construct(View $View, array $config = [])
    {
        $this->_defaultConfig['url'] = $View->request->here;
        parent::__construct($View, $config);

        $this->setCard($this->config('card'));
        $this->setUrl($this->config('url'));
        $this->setTitle($View->fetch('title'));
    }

    /**
     * Add tag
     *
     * @param string $tag Tag name
     * @param string $value Tag value
     * @param array $options Options
     * @return $this
     */
    public function addTag($tag, $value, array $options = [])
    {
        $this->config("tags.twitter.$tag", $options ? [$value, $options] : $value);
        return $this;
    }

    /**
     * Set URL.
     *
     * @param string|array $value URL
     * @return $this
     */
    public function setUrl($value)
    {
        return $this->addTag('url', Router::url($value, true));
    }

    /**
     * Magic method to handle calls to "set<Foo>" methods.
     *
     * @param string $tag Tag name
     * @param array $args Arguments
     * @return mixed
     */
    public function __call($tag, $args)
    {
        if (strpos($tag, 'set') !== 0) {
            return parent::__call($tag, $args);
        }

        $tag = strtolower(substr($tag, 3));

        switch ($tag) {
            case 'card':
            case 'title':
            case 'description':
            case 'data1':
            case 'label1':
            case 'data2':
            case 'label2':
                return $this->addTag($tag, array_shift($args));

            case 'site':
            case 'creator':
            case 'image':
            case 'player':
                if (count($args) < 2) {
                    $args[] = [];
                }
                list($value, $options) = $args;
                return $this->addTag($tag, $value, $options);

            default:
                return parent::__call($tag, $args);
        }
    }
}
