# 项目预购


## 项目列表

> GET: crowdfunds

> Auth：玄尘

| 请求参数         | 类型    | 说明                     | 版本  |
| -------------- | ------ | ------------------------ | ----- |
| company_id      | string   |  企业id                 | 1.0.0 |

| 响应参数     | 类型   | 说明   | 版本  |
| ------------ | ------ | ------ | ----- |
| crowdfund_id | string | 项目id | 1.0.0 |
| title        | string | 项目名称 | 1.0.0 |
| cover        | string | 封面 | 1.0.0 |
| amount       | string | 目标金额 | 1.0.0 |
| all_total    | string | 已筹集金额 | 1.0.0 |
| all_users    | string | 参与人数 | 1.0.0 |
| city         | string | 城市 | 1.0.0 |
| category     | string | 分类 | 1.0.0 |
| status_text  | string | 状态名称 | 1.0.0 |
| status  | string | 状态 | 1.0.0 |
| diffDays     | string | 剩余天数 | 1.0.0 |
| openDiffDays     | string | 开启时间倒计时 | 1.0.0 |
| likes        | string | 关注人数 | 1.0.0 |

>stauts : 0 关闭 1 进行中 2 即将上线 3 已成功 4 已结束

```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": {
        "data": [
            {
                "crowdfund_id": 1,
                "title": "测试",
                "cover": "http://new.yuzhankeji.cn/storage/images/2020/12/03/065ea8c8a6cb7ac22ce4817d20497d90.jpg",
                "amount": "1.00",
                "all_total": 10,
                "all_users": 1,
                "city": "哈尔滨市",
                "category": "测试",
                "status_text": "进行中",
                "status": 1,
                "diffDays": 57,
                "openDiffDays": "1天前",
                "likes": 1,
            }
        ],
        "page": {
            "current": 1,
            "total_page": 1,
            "per_page": 15,
            "has_more": false,
            "total": 1
        }
    }
}
```

## 项目详情

> GET: crowdfunds/{项目id}

> Auth：玄尘

| 响应参数     | 类型   | 说明       | 版本  |
| ------------ | ------ | ---------- | ----- |
| crowdfund_id | string | 项目id     | 1.0.0 |
| title        | string | 项目名称   | 1.0.0 |
| pictures     | string | 封面图     | 1.0.0 |
| video_url    | string | 视频地址   | 1.0.0 |
| amount       | string | 目标金额   | 1.0.0 |
| all_total    | string | 已筹集金额 | 1.0.0 |
| all_users    | string | 参与人数   | 1.0.0 |
| description  | string | 城市       | 1.0.0 |
| content      | string | 详情       | 1.0.0 |
| status_text  | string | 状态名称   | 1.0.0 |
| status       | string | 状态       | 1.0.0 |
| diffDays     | string | 剩余天数   | 1.0.0 |
| province     | string | 省份       | 1.0.0 |
| city         | string | 城市       | 1.0.0 |
| likes        | string | 关注人数   | 1.0.0 |
| start_at     | string | 开始时间   | 1.0.0 |
| end_at       | string | 结束时间   | 1.0.0 |
| created_at   | string | 创建时间   | 1.0.0 |


```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": {
        "crowdfund_id": 1,
        "title": "测试",
        "pictures": [
            "http://new.yuzhankeji.cn/storage/images/2020/12/03/065ea8c8a6cb7ac22ce4817d20497d90.jpg",
            "http://new.yuzhankeji.cn/storage/images/2020/12/03/148e9ee8c1ba26502b9d4ddd688daa9b.jpg"
        ],
        "video_url": "",
        "amount": "1.00",
        "all_total": 10,
        "all_users": 1,
        "items": [
            {
                "crowdfund_item_id": 1,
                "title": "2121",
                "time": "21212",
                "remark": "<p><em><strong>21212</strong></em></p>",
                "shipping": "2121",
                "price": "100.00",
                "quantity": "不限制",
                "all_users": 1,
                "all_total": "10.00",
                "created_at": "2020-12-03 11:25:28"
            },
            {
                "crowdfund_item_id": 3,
                "title": "回报1",
                "time": "项目成功后一周",
                "remark": "<p>种瓜得瓜</p>",
                "shipping": "全配送",
                "price": "1000.00",
                "quantity": "不限制",
                "all_users": 0,
                "all_total": 0,
                "created_at": "2020-12-03 14:49:09"
            }
        ],
        "description": "测试",
        "content": "<p>范德萨发撒</p>",
        "status_text": "进行中",
        "status": 1,
        "diffDays": 57,
        "province": "黑龙江省",
        "city": "哈尔滨市",
        "likes": null,
        "start_at": "2020-12-03 00:00:00",
        "end_at": "2021-01-31 00:00:00",
        "created_at": "2020-12-03 14:49:09"
    }
}
```

## 支持项目

> GET: crowdfunds/create

> Auth：玄尘

| 请求参数         | 类型    | 说明                     | 版本  |
| -------------- | ------ | ------------------------ | ----- |
| crowdfund_item_id      | string   |  回报id                 | 1.0.0 |

| 响应参数          | 类型   | 说明     | 版本  |
| ----------------- | ------ | -------- | ----- |
| crowdfund_item_id | string | 回报id   | 1.0.0 |
| title             | string | 回报名称 | 1.0.0 |
| time              | string | 回报时间 | 1.0.0 |
| remark            | string | 回报内容 | 1.0.0 |
| shipping          | string | 配送说明 | 1.0.0 |
| price             | string | 金额     | 1.0.0 |
| quantity          | string | 限制人数 | 1.0.0 |
| all_users         | string | 参与人数 | 1.0.0 |
| all_total         | string | 参与金额 | 1.0.0 |
| created_at        | string | 创建时间 | 1.0.0 |


| 响应参数   | 类型   | 说明     | 版本  |
| ---------- | ------ | -------- | ----- |
| address_id | string | 地址id   | 1.0.0 |
| name       | string | 姓名     | 1.0.0 |
| mobile     | string | 手机号   | 1.0.0 |
| province   | string | 省       | 1.0.0 |
| city       | string | 市       | 1.0.0 |
| district   | string | 区       | 1.0.0 |
| address    | string | 详细地址 | 1.0.0 |


```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": {
        "info": {
            "crowdfund_item_id": 1,
            "title": "2121",
            "time": "21212",
            "remark": "<p><em><strong>21212</strong></em></p>",
            "shipping": "2121",
            "price": "100.00",
            "quantity": "不限制",
            "all_users": 1,
            "all_total": "10.00",
            "created_at": "2020-12-03 11:25:28"
        },
        "address": [
            {
                "address_id": 9,
                "user_id": 1,
                "name": "json",
                "mobile": "15512341234",
                "province": "北京市",
                "city": "天津城区",
                "district": "科尔沁左翼中旗",
                "address": "255",
                "created_at": "2020-11-10 10:41:51"
            },
            {
                "address_id": 8,
                "user_id": 1,
                "name": "Jason",
                "mobile": "15512341234",
                "province": "北京市",
                "city": "天津城区",
                "district": "科尔沁左翼中旗",
                "address": "255",
                "created_at": "2020-11-10 10:41:19"
            }            
        ]
    }
}
```

## 支持项目-创建订单

> POST: crowdfunds

> Auth：玄尘

| 请求参数          | 类型   | 说明   | 版本  |
| ----------------- | ------ | ------ | ----- |
| crowdfund_item_id | string | 回报id | 1.0.0 |
| address_id        | string | 地址id | 1.0.0 |

```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": {
        "trade_no": "T2012041408437581800"
    }
}
```

## 关注项目

> POST: crowdfunds/like

> Auth：玄尘

| 请求参数          | 类型   | 说明   | 版本  |
| ----------------- | ------ | ------ | ----- |
| crowdfund_id | string | 项目id | 1.0.0 |



```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": "关注成功"
}
```

## 取消关注项目

> POST: crowdfunds/unlike

> Auth：玄尘

| 请求参数          | 类型   | 说明   | 版本  |
| ----------------- | ------ | ------ | ----- |
| crowdfund_id | string | 项目id | 1.0.0 |



```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": "取消关注成功"
}
```

## 项目分类列表

> GET: ajax/crowdfundcategory

> Auth：玄尘

| 请求参数          | 类型   | 说明   | 版本  |
| ----------------- | ------ | ------ | ----- |
| company_id | string | 企业id | 1.0.0 |

```
{
    "status": "SUCCESS",
    "status_code": 200,
    "data": [
        {
            "title": "测试",
            "id": 1
        }
    ]
}
```
