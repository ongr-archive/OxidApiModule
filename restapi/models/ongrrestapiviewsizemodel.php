<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiViewSizeModel
{
    /**
     * @var string
     */
    protected $sDefaultConfigListSize;

    /**
     * @var string
     */
    protected $sDefaultProfileListValue;

    /**
     * @var string
     */
    protected $limit;

    public function setFullArticlesListView($oArticlesList, $limit = 15)
    {
        $this->limit = $limit;
        $myConfig = $oArticlesList->getConfig();
        $this->sDefaultConfigListSize = $myConfig->getConfigParam('iAdminListSize');
        $myConfig->setConfigParam('iAdminListSize', $this->limit);


        if ($aProfile = oxRegistry::getSession()->getVariable('profile')) {
            if (isset($aProfile[1]) && ($aProfile[1] != $this->limit)) {
                $this->sDefaultProfileListValue = $aProfile[1];
                $aProfile[1] = $this->limit;
                oxRegistry::getSession()->deleteVariable('profile');
                oxRegistry::getSession()->setVariable('profile', $aProfile);
            }
        }
    }

    public function setDefaultArticlesListView($oArticlesList)
    {
        $myConfig = $oArticlesList->getConfig();

        if ($this->sDefaultConfigListSize) {
            $myConfig->setConfigParam('iAdminListSize', $this->sDefaultConfigListSize);
        }

        if ($this->sDefaultProfileListValue) {
            if ($aProfile = oxRegistry::getSession()->getVariable('profile')) {
                if (isset($aProfile[1])) {
                    $aProfile[1] = $this->sDefaultProfileListValue;
                    oxRegistry::getSession()->deleteVariable('profile');
                    oxRegistry::getSession()->setVariable('profile', $aProfile);
                }
            }
        }
    }
}
