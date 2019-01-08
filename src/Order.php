<?php

/*
 * This file is part of the boqii openapi shop client package.
 *
 * (c) liugj <liugj@boqii.com> curry.zheng<curry.zheng@boqii.com> wangyw<wangyw@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bqrd\OpenApi\PetStore;

use Bqrd\OpenApi\PetStore\Api;
class Order extends Api
{
    /**
     * __construct.
     *
     * @param string $baseUri
     * @param array  $options
     *
     * @return mixed
     */
    public function __construct(string $baseUri, array $options = [])
    {
        parent :: __construct($baseUri, $options);
    }

    public function updatePetStoreOrderStatus(array $input)
    {
        $input['Act'] = 'UpdatePetStoreOrderStatus';

        return $this->restClient->post('?UpdatePetStoreOrderStatus', $input)->toArray();
    }
}
