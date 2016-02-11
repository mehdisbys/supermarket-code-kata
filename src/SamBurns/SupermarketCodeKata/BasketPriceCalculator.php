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

    public function getTotalPrice() : float
    {
        $items = array_merge($this->crisps, $this->drinks, $this->sandwiches);
        $sum = 0.0;

        foreach ($items as $item) {
            $sum += $item->getUnitCost();
        }
        $mealDeal = new Offer([new Crisps(), new Drink(), new Sandwich()], 3.00);
        $sum = $mealDeal->apply($items, $sum)->chain([new Crisps(), new Crisps(), new Crisps()], 1.00);

        return $sum;
    }
}
