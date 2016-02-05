<?php
namespace SamBurns\SupermarketCodeKata;


use SamBurns\SupermarketCodeKata\Item\Crisps;
use SamBurns\SupermarketCodeKata\Item\Drink;
use SamBurns\SupermarketCodeKata\Item\Sandwich;

class MealDeal
{
    private $meal;
    private $deal;
    private $countItems = [];
    private $priceDifference;

    public function __construct(array $meal, float $deal)
    {
        $this->meal = $meal;
        $this->deal = $deal;
    }

    public function apply(array $items, float &$sum)
    {
        $this->countProducts($items);
        $this->calculateDifference();

        while ($this->removeOneDeal())
        {
            $sum -= $this->priceDifference;
        }
    }

    private function removeOneDeal() : bool
    {
        foreach ($this->countItems as &$product) {
            if ($product == 0) {
                return false;
            }
             $product--;
        }
        return true;
    }

    private function countProducts(array $items)
    {
        $this->countItems['crisps'] = 0;
        $this->countItems['drinks'] = 0;
        $this->countItems['sandwich'] = 0;

        foreach ($items as $key => $item) {
            if ($item instanceof Crisps) {
                $this->countItems['crisps']++;
            }
            if ($item instanceof Drink) {
                $this->countItems['drinks']++;
            }
            if ($item instanceof Sandwich) {
                $this->countItems['sandwich']++;
            }
        }
    }


    private function calculateDifference()
    {
        $normalPrice = 0;

        foreach ($this->meal as $item) {
            $normalPrice += $item->getUnitCost();
        }
        $this->priceDifference = $normalPrice - $this->deal;
    }


}