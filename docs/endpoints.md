### Main endpoints
Below can be found the main endpoints of the application as per the requirements.

#### Authenticate
**URL** : `/api/auth`

**Method** : `POST`

**Auth required** : NO

**Permissions required** : -

**Data constraints** :
- **email***: `required|email`
- **password***: `required|string`
- **deviceName***: `required|string`

##### Response
**Code** : `200`

**Body**:
```json
{
    "token": "2|V0R3lfxeC8jSYH6d6bvJ9474I8mtkFqljEW5ipKW2c4c0e38"
}
```
<hr>

#### Create new travel model
**URL** : `/api/travel`

**Method** : `POST`

**Auth required** : `Bearer` token header

**Permissions required** : `admin` role

**Data constraints** :
- slug: `string|max:255`
- **name***: `required|string|max:255`
- description: `nullable|string`
- **numberOfDays***: `required|numeric|gt:0`
- moods: `array:nature,relax,history,culture,party`
##### Response
**Code** : `200`

**Body**:
```json
{
    "slug": "jordan-360",
    "name": "Jordan 360°",
    "description": "Jordan 360°: the perfect tour to discover the suggestive Wadi Rum desert, the ancient beauty of Petra, and much more.\n\nVisiting Jordan is one of the most fascinating things that everyone has to do once in their life.You are probably wondering \"Why?\". Well, that's easy: because this country keeps several passions! During our tour in Jordan, you can range from well-preserved archaeological masterpieces to trekkings, from natural wonders excursions to ancient historical sites, from camels trek in the desert to some time to relax.\nDo not forget to float in the Dead Sea and enjoy mineral-rich mud baths, it's one of the most peculiar attractions. It will be a tour like no other: this beautiful country leaves a memorable impression on everyone.",
    "numberOfDays": 8,
    "numberOfNights": 7,
    "moods": {
        "nature": 80,
        "relax": 20,
        "history": 90,
        "culture": 30,
        "party": 10
    },
    "public": true
}
```
<hr>

#### Update travel model
**URL** : `/api/travel/{travel:slug}`

**Method** : `PATCH`

**Auth required** : `Bearer` token header

**Permissions required** : `editor` role

**Data constraints** :
- slug: `string|max:255`
- **name***: `required|string|max:255`
- description: `nullable|string`
- **numberOfDays***: `required|numeric|gt:0`
- moods: `array:nature,relax,history,culture,party`

##### Response
**Code** : `200`

**Body**:
```json
{
    "slug": "jordan-360",
    "name": "Jordan 360°",
    "description": "Jordan 360°: the perfect tour to discover the suggestive Wadi Rum desert, the ancient beauty of Petra, and much more.\n\nVisiting Jordan is one of the most fascinating things that everyone has to do once in their life.You are probably wondering \"Why?\". Well, that's easy: because this country keeps several passions! During our tour in Jordan, you can range from well-preserved archaeological masterpieces to trekkings, from natural wonders excursions to ancient historical sites, from camels trek in the desert to some time to relax.\nDo not forget to float in the Dead Sea and enjoy mineral-rich mud baths, it's one of the most peculiar attractions. It will be a tour like no other: this beautiful country leaves a memorable impression on everyone.",
    "numberOfDays": 8,
    "numberOfNights": 7,
    "moods": {
        "nature": 80,
        "relax": 20,
        "history": 90,
        "culture": 30,
        "party": 10
    },
    "public": true
}
```
<hr>

#### Create new tours model
**URL** : `/api/travel/{travel:slug}/tour`

**Method** : `POST`

**Auth required** : `Bearer` token header

**Permissions required** : `admin` role

**Data constraints** :
- **name***: `required|string|max:255`
- **startingDate***: `required|date`
- endingDate: `date`
- price: `numeric`

##### Response
**Code** : `200`

**Body**:
```json
{
    "name": "ITJOR20211101",
    "startingDate": "2021-11-01T00:00:00.000000Z",
    "endingDate": "2021-11-08T00:00:00.000000Z",
    "price": 1999,
    "travel": "travel object from above"
}
```

#### Paginated tours by travel slug
**URL** : `/api/travel/{travel:slug}/tour`

**Method** : `GET`

**Auth required** : `Bearer` token header

**Permissions required** : -

**Query parameters** :
- filter:
  - priceFrom
  - priceTo
  - dateFrom
  - dateTo
- sort: `price` or `-price` for descending
- page:
  - size
  - number

For nested query parameters this is how they should be included as array. 

Example: `filter[priceFrom]=1999`

##### Response
**Code** : `200`

**Body**:
```json
{
    "data": [
        {
            "name": "ITJOR20211125",
            "startingDate": "2021-11-25T00:00:00.000000Z",
            "endingDate": "2021-12-02T00:00:00.000000Z",
            "price": 2149
        },
        {
            "name": "ITJOR20211101",
            "startingDate": "2021-11-01T00:00:00.000000Z",
            "endingDate": "2021-11-08T00:00:00.000000Z",
            "price": 1999
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/travel/jordan-360/tour?page%5Bsize%5D=2&filter%5BdateFrom%5D=2021-11-01&sort=-price&page%5Bnumber%5D=1",
        "last": "http://localhost:8000/api/travel/jordan-360/tour?page%5Bsize%5D=2&filter%5BdateFrom%5D=2021-11-01&sort=-price&page%5Bnumber%5D=2",
        "prev": null,
        "next": "http://localhost:8000/api/travel/jordan-360/tour?page%5Bsize%5D=2&filter%5BdateFrom%5D=2021-11-01&sort=-price&page%5Bnumber%5D=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/travel/jordan-360/tour?page%5Bsize%5D=2&filter%5BdateFrom%5D=2021-11-01&sort=-price&page%5Bnumber%5D=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://localhost:8000/api/travel/jordan-360/tour?page%5Bsize%5D=2&filter%5BdateFrom%5D=2021-11-01&sort=-price&page%5Bnumber%5D=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/travel/jordan-360/tour?page%5Bsize%5D=2&filter%5BdateFrom%5D=2021-11-01&sort=-price&page%5Bnumber%5D=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://localhost:8000/api/travel/jordan-360/tour",
        "per_page": 2,
        "to": 2,
        "total": 3
    }
}
```
