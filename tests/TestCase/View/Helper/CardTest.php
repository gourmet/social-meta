<?php

namespace Gourmet\SocialMeta\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Gourmet\SocialMeta\View\Helper\CardHelper;

class CardTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->View = new View();
        $this->Card = new CardHelper($this->View);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->Card, $this->View);
    }

    public function testConstructor()
    {
        $result = $this->Card->config();
        $this->assertEquals('summary', $result['card']);
        $this->assertEquals($this->View->request->here, $result['url']);
    }

    public function testSetCard()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setCard('photo'));

        $result = $this->Card->config('tags.twitter.card');
        $expected = 'photo';
        $this->assertEquals($expected, $result);
    }

    public function testSetUrl()
    {
        $url = ['controller' => 'pages', 'action' => 'display', 'home'];
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setUrl($url));

        $result = $this->Card->config('tags.twitter.url');
        $expected = 'http://localhost/pages/display/home';
        $this->assertEquals($expected, $result);
    }

    public function testSetTitle()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setTitle('foo'));

        $result = $this->Card->config('tags.twitter.title');
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    public function testSetDescription()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setDescription('foo'));

        $result = $this->Card->config('tags.twitter.description');
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    public function testSetData1()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setData1('foo'));

        $result = $this->Card->config('tags.twitter.data1');
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    public function testSetLabel1()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setLabel1('foo'));

        $result = $this->Card->config('tags.twitter.label1');
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    public function testSetData2()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setData2('foo'));

        $result = $this->Card->config('tags.twitter.data2');
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    public function testSetLabel2()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setLabel2('foo'));

        $result = $this->Card->config('tags.twitter.label2');
        $expected = 'foo';
        $this->assertEquals($expected, $result);
    }

    public function testSetSite()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setSite('foobar', ['foo' => 'bar']));

        $result = $this->Card->config('tags.twitter.site');
        $expected = ['foobar', ['foo' => 'bar']];
        $this->assertEquals($expected, $result);
    }

    public function testSetCreator()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setCreator('foobar', ['foo' => 'bar']));

        $result = $this->Card->config('tags.twitter.creator');
        $expected = ['foobar', ['foo' => 'bar']];
        $this->assertEquals($expected, $result);
    }

    public function testSetImage()
    {
        $image = 'http://farm8.staticflickr.com/7334/11858349453_e3f18e5881_z.jpg';
        $height = '100px';
        $width = '50px';
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setImage($image, compact('height', 'width')));

        $result = $this->Card->config('tags.twitter.image');
        $expected = [$image, compact('height', 'width')];
        $this->assertEquals($expected, $result);
    }

    public function testSetPlayer()
    {
        $this->assertInstanceOf('Gourmet\SocialMeta\View\Helper\CardHelper', $this->Card->setPlayer('foobar', ['foo' => 'bar']));

        $result = $this->Card->config('tags.twitter.player');
        $expected = ['foobar', ['foo' => 'bar']];
        $this->assertEquals($expected, $result);
    }

    public function testRender()
    {
        $this->Card->setTitle('foo');
        $result = $this->Card->render();
        $expected = [
            ['meta' => ['property' => 'twitter:card', 'content' => 'summary']],
            ['meta' => ['property' => 'twitter:url', 'content' => 'http://localhost/']],
            ['meta' => ['property' => 'twitter:title', 'content' => 'foo']],
        ];
        $this->assertHtml($expected, $result);
    }
}
