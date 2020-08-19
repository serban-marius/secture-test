# secture-test
API REST que permite gestionar los jugadores y equipos a los que pertenecen.

### How to start
1. Clone the project from the repository: `$ git clone https://github.com/serban-marius/secture-test.git`
2. The project uses an SQLite database, it's located on `/var/secture-test.db`
3. In order to set up Symfony & Start the project you can seek for guidance here: https://symfony.com/doc/current/setup.html

### DDBB Squema

* Position Table
    * ID integer, autoincrement, PK 
    * NAME varchar(255)
    
* Team Table
    * ID integer, autoincrement, PK 
    * NAME varchar(255)
    
* Players Table
    * ID integer, autoincrement, PK 
    * NAME varchar(255)
    * TEAM_ID (team.id) integer
    * POSITION_ID (position.id) integer
    * PRICE integer

### API REST Requests

Add postion POST `http://127.0.0.1:8000/api/position` Send alike JSON.
```
{
    "name": "forward"
}
```
Get postion GET `http://127.0.0.1:8000/api/position/1` Response example.
```
{
    "id": 1,
    "name": "goalkeeper"
}
```
Get All postions GET `http://127.0.0.1:8000/api/positions` Response example.
```
[
    {
        "id": 1,
        "name": "goalkeeper"
    },
    {
        "id": 2,
        "name": "defender"
    },
    {
        "id": 3,
        "name": "midfield"
    },
    {
        "id": 4,
        "name": "forward"
    }
]
```
Delete position DELETE `http://127.0.0.1:8000/api/position/2` Response example.
```
{
    "status": "Position removed!"
}
```
Add team POST `http://127.0.0.1:8000/api/team` Send alike JSON.
```
{
    "name": "Villareal"
}
```
Get team GET `http://127.0.0.1:8000/api/team/1` Response example.
```
{
    "id": 1,
    "name": "Villareal"
}
```
Get All teams GET `http://127.0.0.1:8000/api/teams` Response example.
```
[
    {
        "id": 1,
        "name": "Villareal"
    },
    {
        "id": 2,
        "name": "Rayo"
    }
]
```
Delete team DELETE `http://127.0.0.1:8000/api/team/2` Response example.
```
{
    "status": "Team removed!"
}
```
Add player POST `http://127.0.0.1:8000/api/player` Send alike JSON.
```
{
    "name": "Casillas",
    "position": "1",
    "team": "1",
    "price": "1000000"
}
```
Get player GET `http://127.0.0.1:8000/api/player/1` Response example.
```
{
    "id": 1,
    "name": "Casillas",
    "position": "goalkeeper",
    "team": "Villareal",
    "price": 1000000
}
```
Get All players GET `http://127.0.0.1:8000/api/players` Response example.
```
[
    {
        "id": 1,
        "name": "Casillas",
        "position": "goalkeeper",
        "team": "Villareal",
        "price": 1000000
    },
    {
        "id": 2,
        "name": "Buffon",
        "position": "goalkeeper",
        "team": "Rayo",
        "price": 200000
    }
]
```
Delete player DELETE `http://127.0.0.1:8000/api/player/1` Response example.
```
{
    "status": "Player removed!"
}
```
Get Team_Id Players GET `http://127.0.0.1:8000/api/team_id/players/1` Response example.
```
[
    {
        "id": 1,
        "name": "Casillas",
        "position": "goalkeeper",
        "team": "Villareal",
        "price": 1000000
    },
    {
        "id": 5,
        "name": "Pique",
        "position": "defender",
        "team": "Villareal",
        "price": 5600000
    },
    {
        "id": 8,
        "name": "Iniesta",
        "position": "midfield",
        "team": "Villareal",
        "price": 2300000
    },
    {
        "id": 9,
        "name": "Silva",
        "position": "midfield",
        "team": "Villareal",
        "price": 4350000
    },
    {
        "id": 11,
        "name": "Cristiano",
        "position": "forward",
        "team": "Villareal",
        "price": 2000000
    }
]
```
Get Position_Id Players GET `http://127.0.0.1:8000/api/position_id/players/4` Response example.
```
[
    {
        "id": 10,
        "name": "Messi",
        "position": "forward",
        "team": "Rayo",
        "price": 15000000
    },
    {
        "id": 11,
        "name": "Cristiano",
        "position": "forward",
        "team": "Villareal",
        "price": 2000000
    }
]
```
Get Team_Id & Position_Id Players GET `http://127.0.0.1:8000/api/team_position_id/players/position_id=4&team_id=2` Response example.
```
[
    {
        "id": 3,
        "name": "Pepe",
        "position": "defender",
        "team": "Rayo",
        "price": 1500000
    },
    {
        "id": 4,
        "name": "Ramos",
        "position": "defender",
        "team": "Rayo",
        "price": 4000000
    }
]
```
####All player request could be modified as follows in order to get the price in USD.
Modify the request method to `POST` & add `&currency=USD` to the url. (Default currency is EUR.)

Get Player USD POST `http://127.0.0.1:8000/api/player/2&currency=USD` Response example.
```
{
    "id": 2,
    "name": "Buffon",
    "position": "goalkeeper",
    "team": "Rayo",
    "price": 238660
}
```
Get All Players USD POST `http://127.0.0.1:8000/api/players&currency=USD`

Get Team_ID Players USD POST `http://127.0.0.1:8000/api/team_id/players/1&currency=USD`

Get Position_Id Players USD POST `http://127.0.0.1:8000/api/position_id/players/1&currency=USD`

Get Team_Id & Position_Id Players USD POST `http://127.0.0.1:8000/api/team_position_id/players/position_id=4&team_id=2&currency=USD`







