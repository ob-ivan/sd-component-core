<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use tests\Sub\Listing;
use Twig_Environment;
use Twig_Loader_Array;

class TwigComponentTest extends TestCase {
    public function testUnfold() {
        $itemCount = 3;
        $listing = new Listing($itemCount);
        $listing->setTwig(
            new Twig_Environment(
                new Twig_Loader_Array([
                    'tests\Sub\Callback' => '',
                    'tests\Sub\Listing' => '{% for item in items %}{{ include(item.template, item.data) }}{% endfor %}',
                ])
            )
        );
        $listing->render();
        $this->assertEquals($itemCount, $listing->getCallCount(), 'Call count must match item count');
    }
}
