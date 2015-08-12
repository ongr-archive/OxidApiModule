<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiBasketController extends AbstractOngrRestApiController
{
    /**
     * Get basket content.
     */
    public function get()
    {
        $items = $this->getSession()->getBasket()->getContents();
        $out = [];

        foreach ($items as $id => $oBasketitem) {
            $out[$id] = [
                'id' => $oBasketitem->getProductId(),
                'title' => $oBasketitem->getTitle(),
                'link' => $oBasketitem->getLink(),
                'price' => $this->normalizePrice($oBasketitem->getPrice()),
                'unit_price' => $this->normalizePrice($oBasketitem->getUnitPrice()),
                'regular_unit_price' => $this->normalizePrice($oBasketitem->getRegularUnitPrice()),
                'amount' => $oBasketitem->getAmount(),
                'weight' => $oBasketitem->getWeight(),
                'in_stock' => $oBasketitem->getStockCheckStatus(),
            ];
        }

        echo json_encode($out);
    }

    /**
     * Insert article to basket.
     */
    public function post()
    {
        $article = oxNew('ongrRestApiRequestModel')->getDecodedContent();
        $session = $this->getSession();
        $basket = $session->getBasket();

        $basket->addToBasket(
            $article['id'],
            $article['amount'],
            null,
            null,
            true
        );

        $basket->calculateBasket(true);
        $session->freeze();
    }

    /**
     * Delete basket.
     */
    public function delete()
    {
        $this->getSession()->delBasket();
    }

    /**
     * @param oxPrice $price
     *
     * @return array
     */
    private function normalizePrice(oxPrice $price = null)
    {
        return $price !== null ? [
            'netto' => $price->getNettoPrice(),
            'brutto' => $price->getBruttoPrice(),
            'price' => $price->getPrice(),
            'vat' => $price->getVat()
        ] : [];
    }
}
