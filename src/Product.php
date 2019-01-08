<?php

/*
 * This file is part of the boqii openapi search client package.
 *
 * (c) qinjb <qinjb@boqii.com> liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bqrd\OpenApi\Order;

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
     * 获取联想词.
     *
     * @param array $params
     * @param array $headers
     *
     * @return mixed
     */
    public function suggest(array $param, array $headers = [])
    {
        return  $this->restClient->get('product/suggest', $param, $headers)->toArray();
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

        $response = $this->restClient->get($uri, $query, $headers)->toArray();
        $fields = [
             'product' => [
                 'productid' => 'id', 'pname' => 'pname', 'subtitle' => 'subtitle',
                 'sales' => 'sales',  'commentnum' => 'commentnum', 'cast' => 'cast', 'newcast' => 'newcast',
                 'inventory' => 'stock', 'upstatus' => 'upstatus', 'price' => 'price',
                 'isglobal' => 'isglobal', 'is_replace' => 'is_replace', 'attr' => 'attr',
                 'pname_highlight' => 'pname_highlight', 'cretime' => 'cretime', 'month_sales' => 'month_sales',
                 'ifhotsale' => 'ifhotsale', 'ifnewgoods' => 'ifnewgoods', 'pcode' => 'pcode', 'views' => 'views',
                 'globalstorage' => 'globalstorage', 'globalcity' => 'globalcity', 'net_weight' => 'net_weight',
                 'purchase_agent_type' => 'purchase_agent_type', 'uptime' => 'uptime',
                 'is_magicalcard' => 'is_magicalcard',
				 'is_animal' => 'is_animal',
				 'first_uptime' => 'first_uptime',
              ],
              'brand' => ['brandid' => 'brandid', 'brandname' => 'brandname'],
              'product_category' => ['cid' => 'cid'],
              'photo' => ['pid' => 'pid', 'picpath' => 'picpath'],
              'cover' => ['img' => 'img', 'is_show' => 'is_show'],
        ];
        if ($response['type'] == 1) {
            return $response;
        }

        if (in_array($response['type'], [2, 3])) {
            $response['list'] = array_map(function ($products) use ($fields) {
                return $this->convert($products, $fields);
            }, $response['list']);
        } else {
            $response['list'] = $this->convert($response['list'], $fields);
        }

        return $response;
    }

    /**
     * Key 转化 covert.
     *
     * @param array $params 输入商品列表
     * @param array $fields keys 映射
     *
     * @return mixed
     */
    protected function convert(array $params = [], array $fields = []) : array
    {
        return  array_map(function ($product) use ($fields) {
            $value = [];
            foreach ($fields as $key => $columns) {
                if ($key == 'product') {
                    foreach ($columns as $from => $to) {
                        $value[$key][$to] = $product[$from] ?? '';
                    }
                } else {
                    foreach ($columns as $from => $to) {
                        $value[$key][$to] = $product[$key][$from];
                    }
                }
            }

            return $value;
        }, $params);
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
