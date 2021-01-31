<?php

namespace App\Infrastructure;

interface Musement
{
    /**
     * @return array<mixed>
     */
    public function getCities() : array;
}
