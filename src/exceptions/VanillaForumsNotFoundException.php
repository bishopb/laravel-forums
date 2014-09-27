<?php

namespace BishopB\Forum;

class VanillaForumsNotFoundException extends \RuntimeException
{
    public function __construct($path)
    {
        parent::__construct(sprintf('Vanilla not found at %s', $path));
    }
}
