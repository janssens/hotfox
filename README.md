# Hotfox
## _a way smarter than a hotdog_

open source php tool to notify people of an upcoming file to handle.  
let them reply by choosing an option in there mail  
build for the French triathlon / adventure race federation

## Installation

First of all, start containers
```bash
docker-compose up -d
```
Then you will need to install dependencies using composer
```bash
docker-compose exec php composer install
```

app run at http://localhost/ and
mailcatcher run at http://localhost:8080/


todo :
https://stackoverflow.com/questions/41748006/symfony-persisting-manytomany-relation