# SymfonyRealTime
Symfony real time example with mercury protocol.

## Description
You can push notification on other client on page `/rooms` and edit created rooms on page `/rooms/edit/{id}`. 

> In first version you **can't** create rooms from app.

## Screenshot
![](https://pp.userapi.com/c848528/v848528921/15189c/Xx8uxd8C1J0.jpg "Rooms page")

## Relations
[Mercure listener server](https://github.com/dunglas/mercure)

## Install
`composer install`

## Run
`bin/console s:r`

And go to rout: `/rooms`

## Run for `Hub server`
`JWT_KEY='myJWTKey' ADDR=':3000' DEMO=1 ALLOW_ANONYMOUS=1 CORS_ALLOWED_ORIGINS=* PUBLISH_ALLOWED_ORIGINS='http://localhost:3000' ./mercure`
