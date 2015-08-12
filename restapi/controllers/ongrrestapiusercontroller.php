<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiUserController extends AbstractOngrRestApiController
{
    /**
     * Get Oxid users.
     * Acceptable url parameters: limit, jumppage
     */
    public function get()
    {
        $limit = oxRegistry::getConfig()->getRequestParameter("limit");

        $oUsersList = oxNew("User_List");
        $viewSizeModel = oxNew('ongrRestApiViewSizeModel');
        $viewSizeModel->setFullArticlesListView($oUsersList, $limit);

        $aUsers = [];
        foreach ($oUsersList->getItemList() as $sId => $oArticle) {
            foreach ($oArticle as $sFieldName => $oField) {
                $aUsers[$sId][$sFieldName] = $oField->value;
            }
        }

        echo json_encode($aUsers);
    }

    /**
     * Checks if session has logged in user.
     */
    public function getCheck()
    {
        $this->getUser();
        $response = ['logged_in' => $oUser->loadActiveUser()];

        if ($response['logged_in']) {
            $response['username'] = $oUser->getFieldData('oxusername');
        }

        echo json_encode($response);
    }

    /**
     * Login to website.
     */
    public function postLogin()
    {
        $user = oxNew('ongrRestApiRequestModel')->getDecodedContent();
        $oUser = $this->getUser();

        try {
            $oUser->login($user['username'], $user['password']);
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }
    }
}
