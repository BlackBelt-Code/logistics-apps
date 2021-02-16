# Rest Api
## Logistik Api

## Requirment
- Lumen
- MYSQL
- Visual Editor

## Result Json

##  Users

```
{
   "message":"GET users",
   "data":{
      "current_page":1,
      "data":[
         {
            "id":8,
            "name":"asdasd",
            "identity_id":"123123",
            "gender":"1",
            "address":"asdasd",
            "photo":"\/tmp\/phpiiO2mM",
            "email":"aadas@gmail.com",
            "phone_number":"12323",
            "api_token":null,
            "role":"1",
            "status":1,
            "created_at":"2021-02-16T07:41:16.000000Z",
            "updated_at":"2021-02-16T07:41:16.000000Z"
         },
         {
            "id":7,
            "name":"ilyas",
            "identity_id":"022154",
            "gender":"1",
            "address":"Bandung",
            "photo":"\/home\/ilyas\/Pictures\/luffy.jpg",
            "email":"aa1@gmail.com",
            "phone_number":"12312",
            "api_token":null,
            "role":"1",
            "status":1,
            "created_at":"2021-02-16T07:36:23.000000Z",
            "updated_at":"2021-02-16T07:36:23.000000Z"
         },
         {
            "id":5,
            "name":"ilyas",
            "identity_id":"022154",
            "gender":"1",
            "address":"Bandung",
            "photo":"https:\/\/upload.wikimedia.org\/wikipedia\/commons\/f\/f9\/Phoenicopterus_ruber_in_S\u00e3o_Paulo_Zoo.jpg",
            "email":"aa@gmail.com",
            "phone_number":"12312",
            "api_token":null,
            "role":"1",
            "status":1,
            "created_at":"2021-02-16T07:34:59.000000Z",
            "updated_at":"2021-02-16T07:34:59.000000Z"
         }
      ],
      "first_page_url":"http:\/\/localhost:8002\/api\/user?page=1",
      "from":1,
      "last_page":1,
      "last_page_url":"http:\/\/localhost:8002\/api\/user?page=1",
      "links":[
         {
            "url":null,
            "label":"pagination.previous",
            "active":false
         },
         {
            "url":"http:\/\/localhost:8002\/api\/user?page=1",
            "label":1,
            "active":true
         },
         {
            "url":null,
            "label":"pagination.next",
            "active":false
         }
      ],
      "next_page_url":null,
      "path":"http:\/\/localhost:8002\/api\/user",
      "per_page":5,
      "prev_page_url":null,
      "to":3,
      "total":3
   },
   "code":200
}
```

## References 

Link [daengweb](https://daengweb.id/membuat-aplikasi-ekspedisi-lumen-6-2-authentication-manage-users)