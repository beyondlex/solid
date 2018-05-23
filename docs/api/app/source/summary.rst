
说明
--------------

请求与响应
++++++++++++++

请求
======
请求时需要在header加上

1. 客户端 **client-id** 和签名 **sign** ，查看 :ref:`sign-generation`

2. **Accept**: application/json

响应
======
响应为json格式：

.. csv-table::
    :header: "name", "type", "description"

    "code", "int", "0：成功， 非0：失败"
    "message", "string", "失败时用于错误提示"
    "data", "object", "业务数据"


.. _sign-generation:

请求签名算法
++++++++++++++

对POST参数按键名升序排序，去掉空值的键值对后按 ``key1=value1;key2=value2;…keyN=valueN;`` 的形式拼接成字符串，

然后将client_secret拼接到字符串的前面, path_info拼接到后面，并进行sha1加密得到sign

将上一步得到的 ``sign`` ，与 ``client-id`` 一并放到header里发起请求

**path_info**:

如请求url为http://host/a/b/c?x=y, 则path_info为/a/b/c

::

    如：请求url: http://host/api/setProfile

    POST请求参数为
    name=lex
    age=18
    gender=M
    an_empty_param=

    去掉值为空的参数并对参数名按键名升序排序：
    age=18
    gender=M
    name=lex

    拼接后：age=18;gender=M;name=lex;

    若client_secret=hello

    则sha1加密后得到sign：

    sign = sha1('helloage=18;gender=M;name=lex;/api/setProfile')

    得到sign: 548518f8882e54a03eaa46af243fed9733d5577c
