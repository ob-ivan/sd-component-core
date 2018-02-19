<?php
namespace tests;

use SD\ComponentCore\TwigComponent;

class ListingComponent extends TwigComponent
{
    private $itemCount;
    private $callCount = 0;

    public function __construct(int $itemCount)
    {
        $this->itemCount = $itemCount;
    }

    public function getData()
    {
        return [
            'items' => array_map(
                function ($i) {
                    return new CallbackComponent(function () {
                        ++$this->callCount;
                        return [
                            'callCount' => $this->callCount,
                        ];
                    });
                },
                range(0, $this->itemCount - 1)
            )
        ];
    }

    public function getCallCount()
    {
        return $this->callCount;
    }
}
