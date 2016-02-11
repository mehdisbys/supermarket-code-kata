<?php
namespace SamBurns\SupermarketCodeKata;

use SamBurns\SupermarketCodeKata\Item\Crisps;
use SamBurns\SupermarketCodeKata\Item\Drink;
use SamBurns\SupermarketCodeKata\Item\Sandwich;

class BasketPriceCalculator
{
    /** @var Crisps[] */
    private $crisps = [];

    /** @var Drink[] */
    private $drinks = [];

    /** @var Sandwich[] */
    private $sandwiches = [];

    public function addItem(ItemInterface $item)
    {
        if ($item instanceof Crisps) {
            $this->crisps[] = $item;
        }
        if ($item instanceof Drink) {
            $this->drinks[] = $item;
        }
        if ($item instanceof Sandwich) {
            $this->sandwiches[] = $item;
        }
    }

    public function getAllItems()
    {
        return array_merge($this->crisps, $this->drinks, $this->sandwiches);
    }

    public function getTotalWithoutOffers()
    {
        $items = $this->getAllItems();
        $sum = 0.0;

        foreach ($items as $item) { $sum += $item->getUnitCost(); }

        return $sum;
    }

    public function getTotalPrice() : float
    {
        $sum = $this->getTotalWithoutOffers();

        $discounts = new DiscountPipeline($this->getAllItems());

        $sum -= $discounts->getTotalDiscount();

        return $sum;
    }
}
