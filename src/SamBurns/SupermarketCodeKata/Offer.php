<?php
namespace SamBurns\SupermarketCodeKata;


use SamBurns\SupermarketCodeKata\Item\Crisps;
use SamBurns\SupermarketCodeKata\Item\Drink;
use SamBurns\SupermarketCodeKata\Item\Sandwich;

class Offer
{
    private $meal;
    private $deal;
    private $countItems = [];
    private $priceDifference;
    private $sum;

    public function __construct(array $meal, float $deal)
    {
        $this->meal = $meal;
        $this->deal = $deal;
    }

    public function apply(array $items, float &$sum)
    {
        $this->countProducts($items);
        $this->calculateDifference();

        while ($this->customRemoveOneDeal($this->meal)) {
            $sum -= $this->priceDifference;
        }
        $this->sum = $sum;
        return $this;
    }

    public function chain(array $meal, float $deal)
    {
        $diff = $this->__difference($meal, $deal);

        if ($this->customRemoveOneDeal($meal)) {
            $this->sum -= $diff;
        }
        return $this->sum;
    }

    private function customRemoveOneDeal(array $items) : bool
    {
        $expectedCount = count($items);
        $count = 0;

        foreach ($items as $item) {
            foreach ($this->countItems as &$product) {
                if (isset($product['instance']) and $product['instance'] instanceof $item) {
                    if ($product['count'] == 0) {
                        return false;
                    }
                    $count++;
                }
            }
        }

        if ($expectedCount == $count) {
            foreach ($items as $item) {
                foreach ($this->countItems as &$product) {
                    if (isset($product['instance']) and $product['instance'] instanceof $item) {
                        if ($product['count'] == 0) {
                            return false;
                        }
                        $product['count']--;
                    }
                }
            }
            return true;
        }
        return false;
    }

    private function countProducts(array $items)
    {
        foreach ($items as $key => $item) {
            $this->countItems[get_class($item)]['instance'] = $item;
            if(!isset($this->countItems[get_class($item)]['count']))
                $this->countItems[get_class($item)]['count'] = 0;
                $this->countItems[get_class($item)]['count']++;
        }
    }


    private function calculateDifference()
    {
        $this->priceDifference = $this->__difference($this->meal, $this->deal);
    }

    private function __difference(array $meal, float $deal)
    {
        $normalPrice = 0;

        foreach ($meal as $item) {
            $normalPrice += $item->getUnitCost();
        }
        return $normalPrice - $deal;
    }
}