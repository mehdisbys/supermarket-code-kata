<?php

namespace SamBurns\SupermarketCodeKata;


class DiscountPipeline
{
    private $countItems = [];
    private $offers     = [];
    private $items      = [];
    private $sum        = 0.0;

    public function __construct(array $items, array $offers)
    {
        $this->items  = $items;
        $this->offers = $offers;
    }

    public function getTotalDiscount() : float
    {
        $this->countProducts($this->items);

        foreach ($this->offers as $offer)
        {
            $this->applyOffer($offer);
        }
        return $this->sum;
    }

    private function applyOffer(Offer $offer)
    {
        $diff = $offer->getDiscount();
        while ($this->removeOneOffer($offer->getMeal())) {
            $this->sum += $diff;
        }
    }

    private function countProducts(array $items)
    {
        foreach ($items as $key => $item) {
            $this->countItems[get_class($item)]['instance'] = $item;
            if (!isset($this->countItems[get_class($item)]['count']))
                $this->countItems[get_class($item)]['count'] = 0;
            $this->countItems[get_class($item)]['count']++;
        }
    }

    private function removeOneOffer(array $items) : bool
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
}