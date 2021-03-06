# uniondrug service server

> UnionDrug微服务`MicroService`服务端`producer`。

* PHP `7.1+`
* Phalcon `3.2+`


### Methods

1. `withError`(`string`, `int`)
1. `withList`(`array`)
1. `withObject`(`array`)
1. `withPaging`(`array`, `ResponsePaging`)
1. `withSuccess`()
1. `setPaging`(`int`, `int`, `int`)

```php
public function postAction(){
    $total = 123;
    $page = 3;
    $limit = 15;
    $data = [
        ["id" => 1, "key" => "value"], 
        ["id" => 2, "key" => "value2"]
    ];
    $this->serviceServer->setPaging($total, $page, $limit)->withPaging($data);
}
```



*Directory*

```text
└── vendor
    └── uniondrug
        └── service-server
            ├── src
            │   └── Server.php
            └── README.md
```

*Composer*

```json
{
    "autoload" : {
        "psr-4" : {
            "UniondrugServiceServer\\" : "vendor/uniondrug/service-server/src"
        }
    }
}
```