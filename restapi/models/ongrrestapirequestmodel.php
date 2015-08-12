<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class OngrRestApiRequestModel
{
    /**
     * Returns current request body.
     *
     * @return string
     */
    public function getContent()
    {
        return file_get_contents('php://input');
    }

    /**
     * Returns json decoded request body.
     *
     * @param bool|true $assoc
     *
     * @return object|array
     */
    public function getDecodedContent($assoc = true)
    {
        return json_decode($this->getContent(), $assoc);
    }
}
