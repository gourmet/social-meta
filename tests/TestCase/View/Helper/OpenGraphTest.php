<?php

namespace Gourmet\SocialMeta\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Gourmet\SocialMeta\View\Helper\OpenGraphHelper;

class OpenGraphTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->View = new View();
        $this->OpenGraph = new OpenGraphHelper($this->View);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->OpenGraph, $this->View);
    }

    public function testHtml()
    {
        $result = $this->OpenGraph->html();
        $expected = [
            'html' => ['xmlns:og' => 'http://ogp.me/ns#', 'xmlns:fb' => 'http://ogp.me/ns/fb#']
        ];
        $this->assertHtml($expected, $result);
    }

    public function testRender()
    {
        $this->OpenGraph->setAppId('foo')
            ->setTitle('bar')
            ->setName('foobar', 'something');
        $result = $this->OpenGraph->render();
        $expected = [
            ['meta' => ['property' => 'fb:app_id', 'content' => 'foo']],
            ['meta' => ['property' => 'og:title', 'content' => 'bar']],
            ['meta' => ['property' => 'something:name', 'content' => 'foobar']],
        ];
        $this->assertHtml($expected, $result);
    }
}
