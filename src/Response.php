<?php
/**
 * 微服务化服务端 / producer
 * uiondrug service server
 * @author wsfuyibing <websearch@163.com>
 * @date 2017-11-01
 * @link www.uniondrug.cn
 */

namespace UniondrugServiceServer;

use \UniondrugService\ResponseWriter;

/**
 * 在服务端将数据返回给客户端
 * @package UniondrugServiceServer
 */
class Response extends ResponseWriter
{

    private $lastPaging;

    /**
     * 返回错误消息
     * <code>
     * $response = new \UniondrugServiceServer\Response();
     * $result1 = $response->withError("错误原因");
     * $result2 = $response->withError("错误原因", 1000);
     * </code>
     *
     * @param string $error 错误原因
     * @param int    $errno 错误编号
     *
     * @return Data
     */
    public function withError($error, $errno = 1)
    {
        return new Data(parent::SERVICE_ERROR_TYPE, ["errno" => $errno, "error" => $error]);
    }

    /**
     * 返回普通的数据列表
     * <code>
     * $data = [
     *     ["id" => 1],
     *     ["id" => 2]
     * ];
     * $response = new \UniondrugServiceServer\Response();
     * $result = $response->withList($data);
     * </code>
     *
     * @param array $data 二维数组
     *
     * @return Data
     */
    public function withList($data)
    {
        return new Data(parent::SERVICE_LIST_TYPE, $data);
    }

    /**
     * 返回数据对像
     * <code>
     * $data = [
     *     "id" => 1,
     *     "key" => "value"
     * ];
     * $response = new \UniondrugServiceServer\Response();
     * $result = $response->withObject($data, $paging);
     * </code>
     *
     * @param array $data 一维数组
     *
     * @return Data
     */
    public function withObject($data)
    {
        return new Data(parent::SERVICE_OBJECT_TYPE, $data);
    }

    /**
     * 返回分页列表
     * <code>
     * $data = [
     *     ["id" => 1],
     *     ["id" => 2]
     * ];
     * $response = new \UniondrugServiceServer\Response();
     * $result = $response->setPaging(103, 1, 15)->withPaging($data);
     * </code>
     *
     * @param array $data 二维数组
     *
     * @return Data
     */
    public function withPaging($data)
    {
        return new Data(parent::SERVICE_PAGING_LIST_TYPE, $data, $this->lastPaging);
    }

    /**
     * @param     $total
     * @param     $page
     * @param int $pageSize
     *
     * @return $this
     */
    public function setPaging($total, $page, $pageSize = 10)
    {
        $this->lastPaging = new Paging($total, $page, $pageSize);
        return $this;
    }
}