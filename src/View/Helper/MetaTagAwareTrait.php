<?php

namespace Gourmet\SocialMeta\View\Helper;

trait MetaTagAwareTrait
{

    /**
     * Render view block.
     *
     * @return string
     */
    public function render()
    {
        $block = $this->config('viewBlockName');

        foreach ((array)$this->config('tags') as $namespace => $values) {
            foreach ($values as $tag => $content) {
                $property = "$namespace:$tag";

                if (!is_array($content)) {
                    $this->Html->meta(null, null, compact('property', 'content', 'block'));
                    continue;
                }

                $options = array_pop($content);
                $content = array_shift($content);

                $this->Html->meta(null, null, compact('property', 'content', 'block'));

                foreach ($options as $key => $value) {
                    if (!is_array($value)) {
                        $this->Html->meta(null, null, [
                            'property' => "$property:$key",
                            'content' => $value,
                            'block' => $block
                        ]);
                        continue;
                    }

                    foreach ($value as $content) {
                        $this->Html->meta(null, null, [
                            'property' => "$property:$key",
                            'content' => $content,
                            'block' => $block
                        ]);
                    }
                }
            }
        }

        return $this->_View->fetch($block);
    }
}
