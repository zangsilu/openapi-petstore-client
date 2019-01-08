<?php

/*
 * This file is part of the boqii openapi search client package.
 *
 * (c) qinjb <qinjb@boqii.com> liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bqrd\OpenApi\Order\PetStore;

class Product extends Api
{
    /**
     * __construct.
     *
     * @param string $baseUri
     * @param array  $options
     *
     * @return mixed
     */
    public function __construct(string $baseUri, array $options)
    {
        parent::__construct($baseUri, $options);
    }

    /**
     * 批量获取根据ID获取商品信息.
     *
     * @param array $params
     * @param array $headers
     *
     * @return mixed
     */
    public function multi(array $param, array $headers = [], string $uri = 'product/multi')
    {
        return $this->get($param, $headers, $uri);
    }

    /**
     * 获取某一品牌下商品数量.
     *
     * @param array $params
     * @param array $headers
     *
     * @return mixed
     */
    public function getBrandCount(array $param, array $headers = [])
    {
        return  $this->restClient->get('product/brand/count', $param, $headers)->toArray();
    }

    /**
     * get.
     *
     * @param array $params
     * @param array $headers
     *
     * @return mixed
     */
    public function get(array $param, array $headers = [], string $uri = 'product/search')
    {
        $query = array_intersect_key($param, array_flip([
                   'q', 'p', 'ps', 's', 'price', 'site_source', 'brandid', 'cateid', 'coupon',
                   'isstock', 'ifpromotion', 'isglobal', 'attrid', 'source', 'range', 'id',
                   'is_animal', 'tuike_source_type', 'facets', 'productid',
                   'ifnewgoods', 'is_purchase_in_advance', 'is_magicalcard','card_level' //测试使用
              ]));

        return  $this->restClient->get($uri, $query, $headers)->toArray();
    }

    /**
     * put.
     *
     * @param mixed $product
     *
     * @return mixed
     */
    public function put($product, array $headers = [])
    {
        return $this->restClient->put('product', $product, $headers)->toArray();
    }

    /**
     * thirdCateAndBrand.
     *
     * @param mixed $param
     * @param array $headers
     *
     * @return mixed
     */
    public function thirdCateAndBrand($param, array $headers = [])
    {
        return $this->restClient->get('product/thirdCateAndBrand', $param, $headers);
    }
}
