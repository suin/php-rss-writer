<?php

namespace Suin\RSSWriter;

class ChannelTest extends \XoopsUnit\TestCase
{
	private $itemInterface = '\Suin\RSSWriter\ItemInterface';
	private $feedInterface = '\Suin\RSSWriter\FeedInterface';

	public function testTitle()
	{
		$title = uniqid();
		$channel = new Channel();
		$this->assertSame($channel, $channel->title($title));
		$this->assertAttributeSame($title, 'title', $channel);
	}

	public function testUrl()
	{
		$url = uniqid();
		$channel = new Channel();
		$this->assertSame($channel, $channel->url($url));
		$this->assertAttributeSame($url, 'url', $channel);
	}

	public function testDescription()
	{
		$description = uniqid();
		$channel = new Channel();
		$this->assertSame($channel, $channel->description($description));
		$this->assertAttributeSame($description, 'description', $channel);
	}

	public function testLanguage()
	{
		$language = uniqid();
		$channel = new Channel();
		$this->assertSame($channel, $channel->language($language));
		$this->assertAttributeSame($language, 'language', $channel);
	}

	public function testCopyright()
	{
		$copyright = uniqid();
		$channel = new Channel();
		$this->assertSame($channel, $channel->copyright($copyright));
		$this->assertAttributeSame($copyright, 'copyright', $channel);
	}

	public function testPubDate()
	{
		$pubDate = mt_rand(0, 9999999);
		$channel = new Channel();
		$this->assertSame($channel, $channel->pubDate($pubDate));
		$this->assertAttributeSame($pubDate, 'pubDate', $channel);
	}

	public function testLastBuildDate()
	{
		$lastBuildDate = mt_rand(0, 9999999);
		$channel = new Channel();
		$this->assertSame($channel, $channel->lastBuildDate($lastBuildDate));
		$this->assertAttributeSame($lastBuildDate, 'lastBuildDate', $channel);
	}

	public function testTtl()
	{
		$ttl = mt_rand(0, 99999999);
		$channel = new Channel();
		$this->assertSame($channel, $channel->ttl($ttl));
		$this->assertAttributeSame($ttl, 'ttl', $channel);
	}

	public function testAddItem()
	{
		$item = $this->getMock($this->itemInterface);
		$channel = new Channel();
		$this->assertSame($channel, $channel->addChild($item));
		$this->assertAttributeSame(array($item), 'items', $channel);
	}

	public function testAppendTo()
	{
		$channel = new Channel();
		$feed = $this->getMock($this->feedInterface);
		$feed->expects($this->once())->method('addChannel')->with($channel);
		$this->assertSame($channel, $channel->appendTo($feed));
	}

	/**
	 * @param       $expect
	 * @param array $data
	 * @dataProvider dataForAsXML
	 */
	public function testAsXML($expect, array $data)
	{
		$data = (object) $data;
		$channel = new Channel();

		foreach ( $data as $key => $value )
		{
			$this->reveal($channel)->attr($key, $value);
		}

        $document = new \DOMDocument('1.0', 'utf-8');
        $root = $document->createElement('rss');
        $document->appendChild($root);
        $document->formatOutput = true;
        $channel->buildXML($root);
		$this->assertXmlStringEqualsXmlString($expect, $document->saveXML());
	}

	public static function dataForAsXML()
	{
		$now = time();
		$nowString = date(DATE_RSS, $now);

		return array(
			array(
				"
				<rss>
                    <channel>
                        <title>GoUpstate.com News Headlines</title>
                        <link>http://www.goupstate.com/</link>
                        <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                    </channel>
				</rss>
				",
				array(
					'title'         => "GoUpstate.com News Headlines",
					'url'           => 'http://www.goupstate.com/',
					'description'   => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
				)
			),
			array(
				"
                <rss>
                    <channel>
                        <title>GoUpstate.com News Headlines</title>
                        <link>http://www.goupstate.com/</link>
                        <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                        <language>en-us</language>
                    </channel>
				</rss>
				",
				array(
					'title'         => "GoUpstate.com News Headlines",
					'url'           => 'http://www.goupstate.com/',
					'description'   => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
					'language'      => 'en-us',
				)
			),
			array(
				"
				<rss>
                    <channel>
                        <title>GoUpstate.com News Headlines</title>
                        <link>http://www.goupstate.com/</link>
                        <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                        <pubDate>{$nowString}</pubDate>
                    </channel>
				</rss>
				",
				array(
					'title'         => "GoUpstate.com News Headlines",
					'url'           => 'http://www.goupstate.com/',
					'description'   => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
					'pubDate'       => $now,
				)
			),
			array(
				"
				<rss>
                    <channel>
                        <title>GoUpstate.com News Headlines</title>
                        <link>http://www.goupstate.com/</link>
                        <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                        <lastBuildDate>{$nowString}</lastBuildDate>
                    </channel>
				</rss>
				",
				array(
					'title'         => "GoUpstate.com News Headlines",
					'url'           => 'http://www.goupstate.com/',
					'description'   => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
					'lastBuildDate' => $now,
				)
			),
			array(
				"
				<rss>
                    <channel>
                        <title>GoUpstate.com News Headlines</title>
                        <link>http://www.goupstate.com/</link>
                        <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                        <ttl>60</ttl>
                    </channel>
                </rss>
				",
				array(
					'title'         => "GoUpstate.com News Headlines",
					'url'           => 'http://www.goupstate.com/',
					'description'   => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
					'ttl'           => 60,
				)
			),
			array(
				"
				<rss>
                    <channel>
                        <title>GoUpstate.com News Headlines</title>
                        <link>http://www.goupstate.com/</link>
                        <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                        <copyright>Copyright 2002, Spartanburg Herald-Journal</copyright>
                    </channel>
                </rss>
				",
				array(
					'title'         => "GoUpstate.com News Headlines",
					'url'           => 'http://www.goupstate.com/',
					'description'   => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
					'copyright'     => "Copyright 2002, Spartanburg Herald-Journal",
				)
			),
		);
	}


	public function testAppendTo_with_items()
	{
		$channel = new Channel();

		$item1 = $this->getMock($this->itemInterface);
		$item1->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
		$item2= $this->getMock($this->itemInterface);
		$item2->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));
		$item3 = $this->getMock($this->itemInterface);
		$item3->expects($this->once())->method('buildXML')->with($this->isInstanceOf('\DOMNode'));

		$this->reveal($channel)
			->attr('title', "GoUpstate.com News Headlines")
			->attr('url', 'http://www.goupstate.com/')
			->attr('description', "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.")
			->attr('items', array($item1, $item2, $item3));

		$expect = '<?xml version="1.0" encoding="utf-8" ?>
		    <rss>
                <channel>
                    <title>GoUpstate.com News Headlines</title>
                    <link>http://www.goupstate.com/</link>
                    <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                </channel>
		    </rss>
		';

        $document = new \DOMDocument('1.0', 'utf-8');
        $root = $document->createElement('rss');
        $document->appendChild($root);
        $document->formatOutput = true;
        $channel->buildXML($root);
		$this->assertXmlStringEqualsXmlString($expect, $document->saveXML());
	}

    public function testJapaneseTitle()
    {
        $channel = new Channel();
        $feed = new Feed();

        $channel1 = new Channel();
        $this->reveal($channel1)->attr('title', '日本語1');
        $channel2 = new Channel();
        $this->reveal($channel2)->attr('title', '日本語2');
        $channel3 = new Channel();
        $this->reveal($channel3)->attr('title', '日本語3');
        $this->reveal($feed)->attr('channels', array($channel1, $channel2, $channel3));
        $expect = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>日本語1</title>
    <link></link>
    <description></description>
  </channel>
  <channel>
    <title>日本語2</title>
    <link></link>
    <description></description>
  </channel>
  <channel>
    <title>日本語3</title>
    <link></link>
    <description></description>
  </channel>
</rss>

XML;
        $this->assertSame($expect, $feed->render());
    }
}
