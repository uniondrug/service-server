<?php
/**
 * 微服务化服务端 / producer
 * uiondrug service server
 * @author wsfuyibing <websearch@163.com>
 * @date 2017-11-01
 * @link www.uniondrug.cn
 */

namespace UniondrugServiceServer;

use \UniondrugService\Exception;

/**
 * 分页结构
 * @package UniondrugServiceServer
 */
class Paging extends \stdClass
{

    private $pagingData = [ // 分页字段
        "first" => 0,       // 第1页编号
        "last" => 0,        // 末页编号
        "next" => 0,        // 下1页编号
        "page" => 0,        // 当前页码
        "pageSize" => 10,   // 每页数量
        "prev" => 0,        // 前1页编号
        "total" => 0,       // 总数
    ];

    /**
     * 分页构造
     *
     * @param int $total 总数
     * @param int $page 当前页码
     * @param int $pageSize 每页数量
     *
     * @throws Exception
     */
    public function __construct($total, $page = 1, $pageSize = 10)
    {
        /**
         * 每页
         */
        $pageSize = is_numeric($pageSize) && $pageSize > 0 ? (int) $pageSize : 0;
        if ($pageSize <= 0) {
            throw new Exception("每页数量不能小于'0'整数");
        }
        /**
         * 总数
         */
        $total = is_numeric($total) && $total > 0 ? (int) $total : 0;
        if ($total <= 0) {
            return;
        }

        /**
         * 基础值
         */
        $page = is_numeric($page) && $page > 1 ? (int) $page : 1;
        $this->pagingData["total"] = $total;
        $this->pagingData["page"] = $page;
        $this->pagingData["pageSize"] = $pageSize;
        $this->pagingData["first"] = 1;
        $this->pagingData["last"] = ceil($total / $pageSize);
        if ($this->pagingData["page"] > 1) {
            $this->pagingData["prev"] = $this->pagingData["page"] - 1;
        }
        if ($this->pagingData["page"] < $this->pagingData["last"]) {
            $this->pagingData["next"] = $this->pagingData["page"] + 1;
        }
    }

    /**
     * 读取分页结果
     * @return array
     */
    public function getPaging()
    {
        return $this->pagingData;
    }
}