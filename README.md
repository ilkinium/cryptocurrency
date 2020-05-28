## Installation

You must have [docker compose](https://docs.docker.com/compose/install/) and [npm](https://www.npmjs.com/get-npm) installed.

Enter to the docker folder:
Copy file `.env.example` to `.env`

**Pay attention before run !!! Your ports 8000, 3306, 44300 should be free.** `lsof -i -P -n | grep LISTEN`

Build and run images: `docker-compose up --build -d`

Run rate's fetcher: `./symfony-console exchange-api:get-rates`
Or wait for a minute while cron event fire.

## Docker helpers 

Run symfony console: `./symfony-console`

Run composer: `./composer install`

## API

Go to http://localhost:8000/api and look at documentation

Get all pairs:

    curl -X GET "http://localhost:8000/api/exchange_rates" -H "accept: application/json"
    
or via ld+json

    curl -X GET "http://localhost:8000/api/exchange_rates?page=1" -H "accept: application/ld+json"
    
Get rates for a given date period:

    curl -X GET "http://localhost:8000/api/exchange_rates?datetime[before]=2020-05-29T19:00:33+03:00&datetime[after]=2020-05-26T19:00:33+03:00&page=1" -H "accept: application/ld+json"
"
    
## Work flow

Command *exchange-api:get-rates* runs every minute by cron. It fetches rates from blockchain and stores to database.
Go to http://localhost:8000/api 

