<?php

namespace Awssat\numberedStringOrder\Test;

use PHPUnit\Framework\TestCase;
use Awssat\numberedStringOrder\numberedStringOrder;

class numberedStringOrderTest extends TestCase
{
    /** @var Awssat\numberedStringOrder\numberedStringOrder */
    protected $numberedStringOrder;

    protected function setUp()
    {
        $this->numberedStringOrder = new numberedStringOrder();
    }

    /** @test */
    public function english_words()
    {
        $orderdArray = $this->numberedStringOrder->sort([
                '30 hundreds',
                '30 millions, 24 thousands, 20 hundreds',
                '30 millions, 25 thousands, 20 hundreds',
                '20',
                '30',
                '14',
                '14 billions',
                '20 thousands',
                '30 millions, 25 thousands, 21 hundreds',
                '14 hundreds',
            ]);

        $expected = [
            14,
            20,
            30,
            '14 hundreds',
            '30 hundreds',
            '20 thousands',
            '30 millions, 24 thousands, 20 hundreds',
            '30 millions, 25 thousands, 20 hundreds',
            '30 millions, 25 thousands, 21 hundreds',
            '14 billions',
        ];

        $this->assertEquals($expected, $orderdArray);
    }

    /** @test */
    public function readme_examples()
    {
        $orderedArray = $this->numberedStringOrder->sort([
            'episode 5',
            'episode50',
            '499',
            'episode1',
            'episode two hundred',
            'episode one',
            'episode two',
            'episode eleven',
            'episode three',
        ]);

        $this->assertEquals(['episode1', 'episode one', 'episode two', 'episode three', 'episode 5', 'episode eleven', 'episode50', 'episode two hundred',
        499, ], $orderedArray);

        $orderedArray = $this->numberedStringOrder->sort([
            'حلقة 30',
            'حلقة33',
            'حلقة3٤',
            'حلقة ٥٥ ',
            'حلقه 2 جديدة',
            'حلقه الأولى جديدة',
            'حلقة الثانية جديدة',
            'episode 24',
            '4',
            'حلقة ثلاثة جديدة',
            'حلقة واحد جديدة',
            'حلقتنا اليوم 1',
            'حلقة الاخيرة',
        ]);

        $this->assertEquals(
            ['حلقة واحد جديدة', 'حلقه الأولى جديدة', 'حلقتنا اليوم 1', 'حلقه 2 جديدة', 'حلقة الثانية جديدة', 'حلقة ثلاثة جديدة', 4, 'episode 24', 'حلقة 30', 'حلقة33', 'حلقة3٤', 'حلقة ٥٥ ', 'حلقة الاخيرة'],
            $orderedArray
        );
    }

    /** @test */
    public function it_keeps_same_input_count()
    {
        $orderedArray = $this->numberedStringOrder->sort([
            'episode 100',
            'episode 1',
            'حلقة 2',
            'billion new',
        ]);

        $this->assertCount(4, $orderedArray);
    }

    /** @test */
    public function it_sort_english_words_well()
    {
        $orderedArray = $this->numberedStringOrder->sort([
            'episode 100',
            'billion new',
            'episode 1',
            'episodeTwo',
            'thirtyOne',
            'episode 20',
        ]);

        //last
        $this->assertEquals('billion new', $orderedArray[count($orderedArray) - 1]);

        //in middle
        $this->assertEquals('episode 100', $orderedArray[4]);
        $this->assertEquals('thirtyOne', $orderedArray[3]);
        $this->assertEquals('episode 20', $orderedArray[2]);

        //first
        $this->assertEquals('episode 1', $orderedArray[0]);

        //second
        $this->assertEquals('episodeTwo', $orderedArray[1]);
    }

    /** @test */
    public function it_sort_arabic_words_well()
    {
        $orderedArray = $this->numberedStringOrder->sort([
            '30 مليار',
            '١٠ ألاف',
            '٣٠ مليون',
            '٥٥ ألف',
            '٢ ',
            '١٠٠',
            '١',
        ]);

        //last
        $this->assertEquals('30 مليار', $orderedArray[count($orderedArray) - 1]);

        //in middle
        $this->assertEquals('١٠٠', $orderedArray[2]);

        //first
        $this->assertEquals('١', $orderedArray[0]);
    }

    /** @test */
    public function arabic_words()
    {
        $ordersArray = $this->numberedStringOrder->sort([
            '30 مليار',
            '١٠ ألاف',
            '٣٠ مليون',
            '٥٥ ألف',
            '٢ ',
            '١٠٠',
            '١',
            ' 24',
            '4 مليارات',
            '٣ ملايين',
            '١٠ ملايين و5 ألاف',
            '١٠ ألاف',
            '١٠ ملايين وتسع مئة ألف وخمس مئة',
            '١٠ ملايين وتسع مئة ألف',
        ]);

        $expected =
            [
                0 => '١',
                1 => '٢ ',
                2 => ' 24',
                3 => '١٠٠',
                4 => '١٠ ألاف',
                5 => '٥٥ ألف',
                6 => '٣ ملايين',
                7 => '١٠ ملايين و5 ألاف',
                8 => '١٠ ملايين وتسع مئة ألف',
                9 => '١٠ ملايين وتسع مئة ألف وخمس مئة',
                10 => '٣٠ مليون',
                11 => '4 مليارات',
                12 => '30 مليار',
            ];

        $this->assertEquals($expected, $ordersArray);
    }
}
