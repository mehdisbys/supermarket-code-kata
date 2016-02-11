<?php
namespace SamBurns\SupermarketCodeKata;

class Offer
{
    private $meal;
    private $deal;
    private $difference = 0;

    public function __construct(array $meal, float $deal)
    {
        $this->meal = $meal;
        $this->deal = $deal;
    }

    public function getMeal()
    {
        return $this->meal;
    }

    public function getDiscount() : float
    {
        if ($this->difference != 0)
            return $this->difference;

        return $this->__difference($this->meal, $this->deal);
    }

    private function __difference(array $meal, float $deal)
    {
        $normalPrice = 0;

        foreach ($meal as $item) {
            $normalPrice += $item->getUnitCost();
        }
        $this->difference = $normalPrice - $deal;
        return $this->difference;
    }
}