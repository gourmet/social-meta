<?php

namespace Gourmet\SocialMeta\View\Helper;

use Cake\Routing\Router;
use Cake\View\Helper;

class OpenGraphHelper extends Helper
{
    use MetaTagAwareTrait;

    /**
     * Helpers used by this helper.
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * Default config.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'viewBlockName' => 'smOpenGraph',
        'app_id' => null,
        'type' => 'website',
        'uri' => null,
        'namespaces' => [],
        'tags' => [],
    ];

    /**
     * Generate HTML tag.
     *
     * @param array $options Options
     * @param array $namespaces Namespaces
     * @return string
     */
    public function html(array $options = [], array $namespaces = [])
    {
        $this->addNamespace('og', 'http://ogp.me/ns#');
        $this->addNamespace('fb', 'http://ogp.me/ns/fb#');

        if ($namespaces) {
            foreach ($namespaces as $ns => $url) {
                $this->addNamespace($ns, $url);
            }
        }

        $this->setType($this->config('type'));
        $this->setUri($this->request->here);
        $this->setTitle($this->_View->fetch('title'));

        if ($appId = $this->config('app_id')) {
            $this->setAppId($appId);
        }

        return $this->Html->tag('html', null, $this->config('namespaces') + $options);
    }

    /**
     * Add namespace
     *
     * @param string $namespace Namespace
     * @param string|array $url URL
     */
    public function addNamespace($namespace, $url)
    {
        if (strpos($namespace, 'xmlns') !== 0) {
            $namespace = 'xmlns:' . $namespace;
        }

        $this->config("namespaces.$namespace", $url);
        return $this;
    }

    /**
     * Add tag
     *
     * @param string $namepsace Namespace
     * @param string $tag Tag name
     * @param string $value Tag value
     * @param array $options
     * @return $this
     */
    public function addTag($namespace, $tag, $value, array $options = [])
    {
        $this->config("tags.$namespace.$tag", $options ? [$value, $options] : $value);
        return $this;
    }

    /**
     * Set App Id
     *
     * @param string $id Facebook App ID
     * @return $this
     */
    public function setAppId($id)
    {
        return $this->addTag('fb', 'app_id', $id);
    }

    /**
     * Set Admins
     *
     * @param string|array $id Admin user IDs
     * @return $this
     */
    public function setAdmins($id)
    {
        if (is_array($id)) {
            $id = implode(',', $id);
        }

        return $this->addTag('fb', 'admins', $id);
    }

    /**
     * Set locale
     *
     * @param string|array $value Locale(s)
     * @param string $namespace Namespace. Defaults to "og"
     * @return $this
     */
    public function setLocale($value, $namespace = 'og')
    {
        $value = array_unique((array)$value);

        foreach ($value as &$v) {
            if (strpos($v, '-') !== false) {
                list($l, $r) = explode('-', $v);
                $v = strtolower($l) . '_' . strtoupper($r);
            }
        }

        $locale = array_shift($value);
        $options = [];

        if ($value) {
            $options['alternate'] = $value;
        }

        return $this->addTag($namespace, 'locale', $locale, $options);
    }

    /**
     * Set URL.
     *
     * @param string|array $value URL
     * @return $this
     */
    public function setUri($value, $namespace = 'og')
    {
        return $this->addTag($namespace, 'uri', Router::url($value, true));
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
            case 'name':
            case 'title':
            case 'description':
            case 'type':
                if (count($args) < 2) {
                    $args[] = 'og';
                }
                list($value, $namespace) = $args;
                return $this->addTag($namespace, $tag, $value);

            case 'image':
            case 'video':
                if (count($args) < 2) {
                    $args[] = [];
                }
                if (count($args) < 3) {
                    $args[] = 'og';
                }
                list($value, $options, $namespace) = $args;
                return $this->addTag($namespace, $tag, $value, $options);

            default:
                return parent::__call($tag, $args);
        }
    }
}
