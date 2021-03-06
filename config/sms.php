<?php

return [

    /**
     * url前半部分
     */
    'BASE_URL' => 'https://api.miaodiyun.com/20150822/',

    /**
     * url中的accountSid。如果接口验证级别是主账户则传网站“个人中心”页面的“账户ID”，
     */
    'ACCOUNT_SID' => '8e04a9aa081b46fb84033f803822ade8', // 主账户
    'AUTH_TOKEN' => '9893aeae14554fdb88ecf9a0c03d5c83',

    /**
     * 请求的内容类型，application/x-www-form-urlencoded
     */
    'CONTENT_TYPE' => 'application/x-www-form-urlencoded',

    /**
     * 期望服务器响应的内容类型，可以是application/json或application/xml
     */
    'ACCEPT' => 'application/json',

];
