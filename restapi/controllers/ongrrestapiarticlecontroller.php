<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiArticleController extends AbstractOngrRestApiController
{
    /**
     * Get Oxid articles.
     * Acceptable url parameters: limit, jumppage
     */
    public function get()
    {
        $limit = oxRegistry::getConfig()->getRequestParameter("limit");

        $oArticlesList = oxNew("Article_List");
        $viewSizeModel = oxNew('ongrRestApiViewSizeModel');
        $viewSizeModel->setFullArticlesListView($oArticlesList, $limit);

        $articles = [];
        foreach ($oArticlesList->getItemList() as $sId => $oArticle) {
            foreach ($oArticle as $sFieldName => $oField) {
                $articles[$sId][$sFieldName] = $oField->value;
            }
        }

        echo json_encode($articles);
    }

    /**
     * Add article to Oxid.
     *
     * Post Example:
     * {"oxarticles__oxartnum":"91101","oxarticles__active":1,"oxarticles__oxtitle":"title","oxarticles__oxprice":"2"}
     *
     */
    public function post()
    {
        $article = oxNew('ongrRestApiRequestModel')->getDecodedContent();
        $aArticle = [];

        foreach ($article as $key => $value) {
            $aArticle[$key] = $value;
        }

        $oArticle = oxNew("oxarticle");
        $oArticle->assign($aArticle);
        $oArticle->save();
    }
}
