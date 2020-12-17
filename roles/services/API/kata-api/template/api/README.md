# CURL REQUESTS

## GET

### get beers list
```bash
curl -X GET http://86.119.30.245:1337/beers.php
```

### get beers list by id
```bash
curl -X GET http://86.119.30.245:1337/beers.php?id=YOUR_ID_HERE
```

## PUT

### modify beer
```bash
curl -X PUT http://86.119.30.245:1337/beers.php -H "Content-Type: application/json" -d "{\"id\": \"1\", \"brewery_id\": \"812\", \"name\": \"Hocus Pocus2\", \"cat_id\": \"11\", \"style_id\": \"116\", \"abv\": \"4.5\", \"ibu\": \"0\", \"srm\": \"0\", \"upc\": \"0\", \"filepath\": \"\", \"descript\": \"Our take on a classic summer ale.  A toast to weeds, rays, and summer haze.  A light, crisp ale for mowing lawns, hitting lazy fly balls, and communing with nature, Hocus Pocus is offered up as a summer sacrifice to clodless days.\r\n\r\nIts malty sweetness finishes tart and crisp and is best apprediated with a wedge of orange.\", \"add_user\": \"0\", \"last_mod\": \"2020-12-10 00:00:00\"}"
```

## POST

### add beer

```bash
curl -X POST http://86.119.30.245:1337/beers.php -H "Content-Type: application/json" -d "{\"brewery_id\": \"812\", \"name\": \"test\", \"cat_id\": \"11\", \"style_id\": \"116\", \"abv\": \"4.5\", \"ibu\": \"0\", \"srm\": \"0\", \"upc\": \"0\", \"filepath\": \"\", \"descript\": \"Toto tutu\", \"add_user\": \"0\", \"last_mod\": \"2020-12-10 00:00:00\"}"
```
