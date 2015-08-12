<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiCheckoutController extends AbstractOngrRestApiController
{
    const DELIVERY = 'ongr_delivery';
    const PAYMENT = 'ongr_payment';

    /**
     * Checkout. Default delivery and payment will be used if none set.
     */
    public function post()
    {
        $session = $this->getSession();
        $basket = $session->getBasket();

        if ($session->hasVariable(self::PAYMENT)) {
            $basket->setPayment($session->getVariable(self::PAYMENT));
        }

        if ($session->hasVariable(self::DELIVERY)) {
            $basket->setShipping($session->getVariable(self::DELIVERY));
        }

        $user = $this->getUser();
        if (!$user->loadActiveUser()) {
            echo json_encode(['message' => 'No one is logged in!']);
            return;
        }

        /** @var oxorder $order */
        $order = oxNew('oxorder');
        list($aAllSets, $sActShipSet, $aPaymentList) = oxRegistry::get('oxDeliverySetList')
            ->getDeliverySetData(
                $session->hasVariable(self::DELIVERY) ? $session->getVariable(self::DELIVERY) : null,
                $user,
                $basket
            );

        $orderObject = oxNew('order');
        $_POST['sDeliveryAddressMD5'] = $orderObject->getDeliveryAddressMD5();

        if ($order->finalizeOrder($basket, $user)) {
            $basket->deleteBasket();
            $session->deleteVariable(self::PAYMENT);
            $session->deleteVariable(self::ORDER);
        }

        $session->freeze();
    }

    /**
     * Outputs delivery list.
     */
    public function getDelivery()
    {
        $user = $this->getUser();
        $user->loadActiveUser();

        $list = oxRegistry::get('oxDeliverySetList')
            ->getDeliverySetList($user, $user->getActiveCountry());

        echo json_encode($this->normalizeList($list));
    }

    /**
     * Sets delivery for checkout.
     */
    public function postDelivery()
    {
        $body = oxNew('ongrRestApiRequestModel')->getDecodedContent();

        $session = $this->getSession();
        $session->setVariable(self::DELIVERY, $body['id']);
        $session->freeze();
    }

    /**
     * Outputs payment list. Only available when delivery is set.
     */
    public function getPayment()
    {
        $session = $this->getSession();

        if ($session->hasVariable(self::DELIVERY)) {
            $delivery = $session->getVariable(self::DELIVERY);
        } else {
            echo json_encode(['message' => 'Please set delivery first!']);
            return;
        }

        /** @var oxPaymentList $paymentList */
        $paymentList = oxRegistry::get("oxPaymentList");
        $price = $session->getBasket()->getPriceForPayment() / $this->getConfig()->getActShopCurrencyObject();

        $user = $this->getUser();
        $user->loadActiveUser();

        echo json_encode($this->normalizeList($paymentList->getPaymentList($delivery, $price, $user)));
    }

    /**
     * Sets payment.
     */
    public function postPayment()
    {
        $body = oxNew('ongrRestApiRequestModel')->getDecodedContent();

        $session = $this->getSession();
        $session->setVariable(self::PAYMENT, $body['id']);
        $session->freeze();
    }

    /**
     * Normalizes oxid list.
     *
     * @param array|\Traversable $list
     *
     * @return array
     */
    private function normalizeList($list)
    {
        $out = [];
        foreach ($list as $key => $object) {
            foreach ($object->getFieldNames() as $name) {
                $out[$key][$name] = $object->getFieldData($name);
            }
        }

        return $out;
    }
}
