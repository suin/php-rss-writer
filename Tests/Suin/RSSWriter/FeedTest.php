<?php

namespace Suin\RSSWriter;

use \Mockery;

class FeedTest extends \XoopsUnit\TestCase
{
	private $channelInterface = '\Suin\RSSWriter\ChannelInterface';

	public function testAddChannel()
	{
		$channel = Mockery::mock($this->channelInterface);
		$feed = new Feed();
		$this->assertSame($feed, $feed->addChannel($channel));
		$this->assertAttributeSame(array($channel), 'channels', $feed);
	}

	public function testRender()
	{
		$feed = new Feed();
		$channel1 = $this->getMock($this->channelInterface);
		$channel1->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
		$channel2 = $this->getMock($this->channelInterface);
		$channel2->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
		$channel3 = $this->getMock($this->channelInterface);
		$channel3->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
		$this->reveal($feed)->attr('channels', array($channel1, $channel2, $channel3));
		$expect = '<?xml version="1.0" encoding="utf-8" ?>
			<rss version="2.0" />
		';
		$this->assertXmlStringEqualsXmlString($expect, $feed->render());
	}

	public function test__toString()
	{
		$feed = new Feed();
		$channel1 = $this->getMock($this->channelInterface);
        $channel1->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
        $channel2 = $this->getMock($this->channelInterface);
        $channel2->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
        $channel3 = $this->getMock($this->channelInterface);
        $channel3->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
		$this->reveal($feed)->attr('channels', array($channel1, $channel2, $channel3));
		$expect = '<?xml version="1.0" encoding="utf-8" ?>
			<rss version="2.0" />
		';
		$this->assertXmlStringEqualsXmlString($expect, $feed);
	}
}
