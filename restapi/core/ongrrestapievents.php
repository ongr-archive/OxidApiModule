<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiEvents
{
    /**
     * @var array
     */
    private static $urls = [
        'index.php?cl=ongrrestapibasketcontroller&amp;fnc=index' => 'ongr/api/basket/',
        'index.php?cl=ongrrestapiarticlecontroller&amp;fnc=index' => 'ongr/api/articles/',
        'index.php?cl=ongrrestapiusercontroller&amp;fnc=index' => 'ongr/api/user/',
        'index.php?cl=ongrrestapiusercontroller&amp;fnc=index&amp;mtd=check' => 'ongr/api/user/check/',
        'index.php?cl=ongrrestapiusercontroller&amp;fnc=index&amp;mtd=login' => 'ongr/api/user/login/',
        'index.php?cl=ongrrestapiusercontroller&amp;fnc=index&amp;mtd=register' => 'ongr/api/user/register/',
        'index.php?cl=ongrrestapicheckoutcontroller&amp;fnc=index' => 'ongr/api/checkout/',
        'index.php?cl=ongrrestapicheckoutcontroller&amp;fnc=index&amp;mtd=delivery' => 'ongr/api/checkout/delivery/',
        'index.php?cl=ongrrestapicheckoutcontroller&amp;fnc=index&amp;mtd=payment' => 'ongr/api/checkout/payment/',
    ];

    /**
     * Executes method on module activation.
     */
    public static function onActivate()
    {
        self::loadSeo();
    }

    /**
     * Executes method on module deactivation.
     */
    public static function onDeactivate()
    {
        self::unloadSeo();
    }

    /**
     * Loads seo to database
     */
    private static function loadSeo()
    {
        $oDb = oxDb::getDb();
        foreach (self::$urls as $url => $seo) {
            $oDb->execute(
                "INSERT INTO `oxseo` (OXOBJECTID, OXIDENT, OXSHOPID, OXSTDURL, OXSEOURL, OXTYPE) VALUES(?,?,?,?,?,?)",
                [uniqid('', true), md5($seo), 'oxbaseshop', $url, $seo, 'static']
            );
        }

        self::resetSeo();
    }

    /**
     * Removes all seo rows inserted on activation
     */
    private static function unloadSeo()
    {
        $oDb = oxDb::getDb();
        foreach (self::$urls as $seo) {
            $oDb->execute("DELETE FROM `oxseo` WHERE OXSEOURL = ?", [$seo]);
        }

        self::resetSeo();
    }

    /**
     * Resets shop seo keys.
     */
    private static function resetSeo()
    {
        $shop = oxNew('shop_seo');
        $shop->dropSeoIds();
    }
}
