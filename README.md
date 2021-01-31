### Step 1
How to install and run:
```
composer install
cp .env .env.local
```
Then update .env.local with Weater API key and run:
```
bin/console forecast:print
```

### Step 2

```
GET /api/v3/cities/{id}/forecast/{date}
```
Endpoint will return weather forecast for provided date and city. With a single endpoint we can fetch forecast for 
today, tomorrow or any other day.  
Reponses:  
200 - when forecast for given date was found. Example response payload:
```
{
  "weatherConditions": "Clear sky"
}
```
404 - when foreacast was not found

------------

```
POST /api/v3/cities/{id}/forecast/{date}
```
Endpoint will save given forecast for provided date and city. Again with a single endpoint we can store forecasts for 
today, tomorrow or any other day.

Responses:  
201 - when forecast was saved successfully  
400 - when there were errors while saving forecast

Example request payload:
```
{
  "weatherConditions": "Clear sky"
}
```
