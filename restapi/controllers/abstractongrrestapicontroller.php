<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

abstract class AbstractOngrRestApiController extends oxUBase
{
    /**
     * {@inheritdoc}
     */
    public function index()
    {
        header('Content-Type: application/json');
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $secondMethod = isset($_GET['mtd']) ? ucfirst($_GET['mtd']) : '';

        if (method_exists($this, $method . $secondMethod)) {
            $this->{$method . $secondMethod}();
        } elseif (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            echo json_encode(['message' => 'Api endpoint not found!']);
        }

        exit();
    }
}
