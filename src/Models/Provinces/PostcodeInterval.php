<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces;

use Henrotaym\LaravelBelgianProvinceFinder\Contracts\Models\Provinces\PostcodeIntervalContract;

class PostcodeInterval implements PostcodeIntervalContract
{
    public function __construct(
        protected int $start,
        protected int $end
    ){
        
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function isPostcodeIncluded(int $postcode): bool
    {
        return $postcode >= $this->start
            && $postcode < $this->end; 
    }
}