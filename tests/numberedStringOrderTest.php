<?php

namespace Awssat\numberedStringOrder\Test;

use Awssat\numberedStringOrder\numberedStringOrder;
use PHPUnit\Framework\TestCase;

class numberedStringOrderTest extends TestCase
{
    /** @var Awssat\numberedStringOrder\numberedStringOrder */
    protected $numberedStringOrder;

    protected function setUp()
    {
        $this->numberedStringOrder = new numberedStringOrder();
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
            'episode 20',
        ]);

        //last
        $this->assertEquals('billion new', $orderedArray[count($orderedArray) - 1]);

        //in middle
        $this->assertEquals('episode 100', $orderedArray[2]);

        //first
        $this->assertEquals('episode 1', $orderedArray[0]);
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
}
