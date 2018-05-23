
.. include:: ../lib.rst

中控门锁
---------------

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

门禁考勤记录
++++++++++++

**POST** /app/devices/locks/attendanceRecords

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "id", "Y", "string", "|theLockId|"

response:

.. code-block:: json

    {
        "code": 0,
        "data": {
            "list": [
                {
                    "user_pin": "15",
                    "attendance_time": "2018-03-30 18:16:00"
                },
                {
                    "user_pin": "18",
                    "attendance_time": "2018-03-30 16:24:06"
                },
                {
                    "user_pin": "18",
                    "attendance_time": "2018-03-30 15:08:16"
                }
            ]
        }
    }

门禁考勤用户列表
+++++++++++++++++++

**POST** /app/devices/locks/attendanceUsers

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "id", "Y", "string", "|theLockId|"

response:

.. code-block:: json

    {
        "code": 0,
        "data": {
            "list": [
                {
                    "pin": "15",
                    "name": "LiLei",
                    "finger_prints": [
                        {
                            "fid": "6",
                            "tmp": "xcT13kjm..",
                        },
                        {
                            "fid": "1",
                            "tmp": "ecT13kvm..",
                        }
                    ]
                },
                {
                    "pin": "2",
                    "name": "Jim",
                    "finger_prints": [
                        {
                            "fid": "2",
                            "tmp": "xcT13kjm..",
                        }
                    ]
                }

            ]
        }
    }


数据推送
+++++++++++++++++++

**POST** /应用端提供的推送url

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "data", "Y", "json", "推送的数据"
    "data.action", "Y", "string", "操作类型:attendance, update_user, insert_user, delete_users"
    "data.lock_id", "Y", "string", "门锁ID"
    "data.user", "", "object", "要添加或修改的门锁用户信息，当action为update_user或insert_user时"
    "data.user_pins", "", "array", "要删除的门锁用户工号列表，当action为delete_users时"
    "data.attendance", "", "array", "考勤数据，当action为attendance时"
    "data.user.pin", "", "string", "用户工号"
    "data.user.name", "", "string", "用户名称"
    "data.user.finger_prints", "", "array", "用户指纹数据"
    "data.user.finger_prints.fid", "", "string", "手指编号"
    "data.user.finger_prints.tmp", "", "string", "指纹模板数据"
    "data.attendance.user_pin", "", "string", "用户工号"
    "data.attendance.attendance_time", "", "string", "考勤时间"

params示例:

考勤数据推送：

.. code-block:: json

    {
        "action": "attendance",
        "lock_id": "xZodv1id&l",
        "attendance": {
            "user_pin": "18",
            "attendance_time": "2018-04-03 13:50:27"
        }
    }


删除用户：

.. code-block:: json

    {
        "action": "delete_users",
        "lock_id": "xZodv1id&l",
        "user_pins": [18, 3, 4]
    }


新增用户：

.. code-block:: json

    {
        "action": "insert_user",
        "lock_id": "xZodv1id&l",
        "user": {
            "pin": 4,
            "name": "Lucy",
            "finger_prints":[
                {"fid": 1, "tmp": "xxxxx"},
                {"fid": 9, "tmp": "yyyyy"}
            ]
        }
    }

修改用户：

.. code-block:: json

    {
        "action": "update_user",
        "lock_id": "xZodv1id&l",
        "user": {
            "pin": 4,
            "name": "Lucy",
            "finger_prints":[
                {"fid": 1, "tmp": "xxxxx"},
                {"fid": 9, "tmp": "yyyyy"}
            ]
        }
    }






response:

处理成功需返回json：

.. code-block:: json

    {"code": 0}

注册数据推送地址
++++++++++++++++++++
**POST** /app/devices/locks/registerPushUrl

params:

.. csv-table::
    :header: "name", "required", "type", "description"

    "url", "Y", "string", "客户端要接收推送的url"
    "lock_id", "Y", "string", "门锁ID"
