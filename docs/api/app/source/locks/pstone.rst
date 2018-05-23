
.. include:: ../lib.rst

权石门锁
-------------------

获取智能锁列表
+++++++++++++++++++++

**GET** /app/devices/locks

response:

.. code-block:: json

    {
        "code": 0,
        "data": {
            "list": [
                {
                    "id": "aedd1wef",
                    "name": "Lock001",
                    "sn": "AIE001"
                }
            ]
        }
    }

下发密码
+++++++++++++

**POST** /app/devices/locks/actions/setPwd

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "id", "Y", "string", "|theLockId|"
    "password", "", "string", "要下发的密码，不提供则随机生成6位数字"
    "times", "", "int", "有效次数，1为有效开锁一次，-1为无数次"
    "s_time", "", "string", "开始时间 格式：2018-01-01 11:11:12"
    "e_time", "", "string", "结束时间 格式：2018-01-01 11:11:12"



response:

.. code-block:: json

    {
        "code": 0,
        "data": {
            "id": "a4d2d24b-c463-4898-962f-9359d1f5cc7e",
            "password": "1123",
            "times": 1,
            "s_time": "2018-03-13 18:00:03",
            "e_time": "2018-03-13 19:00:12"
        }
    }

更新密码
+++++++++++++

**POST** /app/devices/locks/updatePwd

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "id", "Y", "string", "密码ID"
    "password", "", "string", "要下发的密码，不提供则随机生成6位数字"
    "times", "", "int", "有效次数，1为有效开锁一次，-1为无数次"
    "s_time", "", "string", "开始时间 格式：2018-01-01 11:11:12"
    "e_time", "", "string", "结束时间 格式：2018-01-01 11:11:12"



response:

.. code-block:: json

    {
        "code": 0,
        "data": {
            "id": "a4d2d24b-c463-4898-962f-9359d1f5cc7e",
            "password": "1123",
            "times": 1,
            "s_time": "2018-03-13 18:00:03",
            "e_time": "2018-03-13 19:00:12"
        }
    }

删除密码
+++++++++++++

**POST** /app/devices/locks/delPwd

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "id", "Y", "string", "密码ID"



response:

.. code-block:: json

    {
        "code": 0,
        "data": []
    }



开锁
++++++

**POST** /app/devices/locks/actions/unlock

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "id", "Y", "string", "|theLockId|"
    "password", "Y", "string", "开锁密码"

response:

.. code-block:: json

    {
        "code": 0,
        "data": []
    }