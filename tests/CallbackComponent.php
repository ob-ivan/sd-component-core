<?php
namespace tests;

use SD\ComponentCore\TwigComponent;

class CallbackComponent extends TwigComponent
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function getData()
    {
        return call_user_func($this->callback);
    }
}
