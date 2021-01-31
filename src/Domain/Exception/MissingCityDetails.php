<?php

namespace App\Domain\Exception;

use Throwable;

class MissingCityDetails extends \Exception
{
    public function __construct(string $field, Throwable $previous = null)
    {
        parent::__construct(sprintf('Missing parameter "%s" when creating city.', $field), 0, $previous);
    }
}
