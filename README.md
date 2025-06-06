# data-collection-engine-app
Web Page that uses micro-services to accept user inputs and stores the results in a MySQL Database using MySQL, PHP, Nginx, and Docker.

# File Structure:

dc_engine/
│
├── docker/
│   ├── nginx/
│   │   └── default.conf          # nginx config
│   ├── php/
│   │   └── Dockerfile            # php-fpm with PDO support
│   └── mysql/
│       └── init.sql              # schema + initial user setup
│
├── html/                       # website files (html, css, js, php)
│   ├── index.php
|   ├── good_bye.php
│   ├── css/
|   |   └── good_bye.css
|   |   └── main.css
|   ├── images/
|   ├── includes/
|       └── dbh.inc.php
|       └── form_contr.inc.php
|       └── form_model.incl.php
|       └── formhandler.inc.php
|   └──main/
|      └── currentDate.js
|      └── populateStates.js
|
├── .env                          # credentials and secrets
├── docker-compose.yml
├── README.md
└── .gitignore
