<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$sMetadataVersion = '1.0';

$aModule = array(
    'id' => 'ongrrestapi',
    'title' => 'ONGR RestAPI Module',
    'description' => array(
        'de' => 'OXID eShop bietet Möglichkeiten der REST-API',
        'en' => 'Provides OXID eShop capabilities of Rest API',
    ),
    'thumbnail' => 'ongr-logo.png',
    'version' => '0.0.1',
    'author' => 'ONGR',
    'url' => 'http://www.ongr.io/',
    'email' => 'lars@nfq.com',
    'extend' => array(),
    'files' => array(
        // Core
        'ongrRestApiEvents'        => 'ongr/restapi/core/ongrrestapievents.php',
        // Controllers
        'abstractOngrRestApiController'=> 'ongr/restapi/controllers/abstractongrrestapicontroller.php',
        'ongrRestApiBasketController'  => 'ongr/restapi/controllers/ongrrestapibasketcontroller.php',
        'ongrRestApiArticleController' => 'ongr/restapi/controllers/ongrrestapiarticlecontroller.php',
        'ongrRestApiUserController'    => 'ongr/restapi/controllers/ongrrestapiusercontroller.php',
        'ongrRestApiCheckoutController'=> 'ongr/restapi/controllers/ongrrestapicheckoutcontroller.php',
        'ongrRestApiPaymentController' => 'ongr/restapi/controllers/ongrrestapipaymentcontroller.php',
        'ongrRestApiShipmentController'=> 'ongr/restapi/controllers/ongrrestapishipmentcontroller.php',
        // Models
        'ongrRestApiRequestModel'  => 'ongr/restapi/models/ongrrestapirequestmodel.php',
        'ongrRestApiViewSizeModel' => 'ongr/restapi/models/ongrrestapiviewsizemodel.php',
    ),
    'events' => array(
        'onActivate'   => 'ongrRestApiEvents::onActivate',
        'onDeactivate' => 'ongrRestApiEvents::onDeactivate'
    ),
    'templates' => array(),
    'blocks' => array(),
    'settings' => array()
);
