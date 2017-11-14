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
class Data extends ResponseWriter
{

    private $responseData = [
        "errno" => "0",
        "error" => ""
    ];

    /**
     * 数据构造
     *
     * @param int    $typeId 数据类型
     * @param array  $data 数据体
     * @param Paging $paging 分页设置
     */
    public function __construct($typeId, $data, $paging = null)
    {
        /**
         * 错误类型
         */
        if ($this->isErrorType($typeId)) {
            $this->responseData["error"] = $data["error"];
            $this->responseData["errno"] = (string) $data["errno"];
            return;
        }
        /**
         * 参数格式化
         */
        is_array($data) || $data = [];
        if ($this->isObjectType($typeId)) {
            /**
             * 对象数据
             */
            $this->responseData["data"] = $data;
        } else {
            /**
             * 列表数据
             */
            $this->responseData["data"] = ["body" => $data];
            if ($this->isPagingListType($typeId)) {
                $this->responseData["data"]["paging"] = ($paging instanceof Paging) ? $paging->getPaging() : [];
            }
        }
        /**
         * 数据类型转换
         */
        $this->convertValueType($this->responseData["data"]);
        /**
         * 返回类型
         */
        if ($this->isObjectType($typeId)) {
            $this->responseData["data"] = (object) $this->responseData["data"];
        } else {
            $this->responseData["data"]["body"] = (array) $this->responseData["data"]["body"];
            if ($this->isPagingListType($typeId)) {
                $this->responseData["data"]["paging"] = (object) $this->responseData["data"]["paging"];
            }
        }
    }

    /**
     * 获取返回结果
     * @return array
     */
    public function getData()
    {
        return $this->responseData;
    }

    /**
     * 获取Phalcon结果
     * @return \Phalcon\Http\Response
     */
    public function response()
    {
        $response = new \Phalcon\Http\Response();
        return $response->setJsonContent($this->responseData);
    }

    /**
     * 转换数据类型
     * 1. boolean
     * 2. null
     * 3. object
     */
    private function convertValueType(& $data)
    {
        if (is_array($data)) {
            foreach ($data as & $value) {
                /**
                 * 数组递归
                 */
                if (is_array($value)) {
                    $this->convertValueType($value);
                    continue;
                }
                /**
                 * 类型转换
                 */
                $type = strtolower(gettype($value));
                switch ($type) {
                    case "integer" :
                    case "float" :
                    case "double" :
                    case "null" :
                        $value = (string) $value;
                        break;
                    case "boolean" :
                        $value = $value ? "1" : "0";
                        break;
                }
            }
        }
    }
}