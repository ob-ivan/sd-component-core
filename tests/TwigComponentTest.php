<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use Twig_Environment;
use Twig_Loader_Array;

class TwigComponentTest extends TestCase
{
    public function testUnfold()
    {
        $itemCount = 3;
        $listing = new ListingComponent($itemCount);
        $listing->setTwig(
            new Twig_Environment(
                new Twig_Loader_Array([
                    'tests\CallbackComponent' => '',
                    'tests\ListingComponent' => '{% for item in items %}{{ include(item.template, item.data) }}{% endfor %}',
                ])
            )
        );
        $listing->render();
        $this->assertEquals($itemCount, $listing->getCallCount(), 'Call count must match item count');
    }
}
