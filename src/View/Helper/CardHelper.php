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

    public function __construct(View $View, array $config = [])
    {
        $this->_defaultConfig['url'] = $View->request->here;
        parent::__construct($View, $config);

        $this->setCard($this->config('card'));
        $this->setUrl($this->config('url'));
        $this->setTitle($View->fetch('title'));
    }

    public function addTag($tag, $value, array $options = [])
    {
        $this->config("tags.twitter.$tag", $options ? [$value, $options] : $value);
        return $this;
    }

    public function setUrl($value)
    {
        return $this->addTag('url', Router::url($value, true));
    }

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
