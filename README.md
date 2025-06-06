# Data Collection Engine (DCE) - Dockerized Microservices Application
![Docker Build](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-009639?style=for-the-badge&logo=nginx&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

# Project Overview
Originally hosted on a home system using Apache and exposed via a Cloudflare Tunnel, the application served a crucial role in **gathering real estate agent data for a local roofing company**, storing it in a MySQL database for marketing purposes.

#Purpose:
This transformation serves as a practical learning exercise focused scalability, isolation, portability, lightweight deployment, and hardware independence for web applications.  Creating distinct services (Nginx, PHP-FPM, MySQL) demostrates the advantages of containerization and microservices principles over monolithic applications.

## Features

* **Data Collection:** Gathers realtor contact information via a web form.
* **Database Storage:** Stores collected data in a MySQL database.
* **Microservices Architecture:** Deployed as independent Nginx, PHP-FPM, and MySQL Docker containers.
* **Containerized Environment:** Ensures portability and consistent behavior across different host environments.
* **Scalability:** Individual services can be scaled independently.
* **Isolation:** Services run in isolated environments, preventing dependency conflicts.
* **Lightweight & Portable:** Reduced resource footprint compared to traditional VM deployments.

---

## Getting Started

These instructions will get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Before you begin, ensure you have the following installed:

* **Docker Desktop:** [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
* **Git:** For cloning the repository.

### Installation and Setup

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/jlarry77/data-collection-engine-app.git](https://github.com/jlarry77/data-collection-engine-app.git)
    cd data-collection-engine-app
    ```

2.  **Configure Environment Variables:**
    Copy the example environment file (below) and update it with your desired credentials.
    ```bash
    cp .env.example .env
    ```
    Open `.env` and fill in the `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, and `MYSQL_PASSWORD` variables. These credentials will be used by the MySQL service and for connecting from the PHP application.

    *Example `.env`:*
    ```
    # Docker Compose Environment Variables
    # --- MySQL Configuration ---
    MYSQL_ROOT_PASSWORD=your_secure_root_password
    MYSQL_DATABASE=realtor_data
    MYSQL_USER=dce_user
    MYSQL_PASSWORD=your_dce_password

    # --- Nginx Configuration ---
    NGINX_PORT=80
    ```

3.  **Build and Run Docker Containers:**
    Navigate to the project root directory (where `docker-compose.yml` is located) and run:
    ```bash
    docker-compose up --build -d
    ```
    * `--build`: Builds images if they don't exist or have changed.
    * `-d`: Runs containers in detached mode (in the background).

4.  **Access the Application:**
    Once the containers are up and running, you can access the web page in your browser:
    ```
    http://localhost
    ```


# File Structure:

`dc_engine/
│
├── docker/                       # Docker build context for services
│   ├── nginx/                    # Nginx web server configuration
│   │   └── default.conf          # Nginx Server block to proxy PHP requests
│   ├── php/                      # PHP-FPM service config
│   │   └── Dockerfile            # Custom PHP-FPM image with required extensions (PDO support)
│   └── mysql/                    # MySQL Database setup
│       └── init.sql              # SQL script to initialize db, schema, and users
│
├── html/                         # Source cod for the web app (html, css, js, php)
│   ├── index.php                 # Main entry point for the web page
|   ├── good_bye.php              # Exit/user-entry confirmation page for website
│   ├── css/                      # Stylesheets
|   |   └── good_bye.css
|   |   └── main.css
|   ├── images/                   # Static image assets
|   ├── includes/                 # PHP includes for database connection and form handling (styled as an MVC)
|       └── dbh.inc.php           # Database connection handler, using PDO as an object
|       └── form_contr.inc.php    # Form Controller Logic
|       └── form_model.incl.php   # Form Data Model
|       └── formhandler.inc.php   # Main form submission handler
|   └──main/                      # JavaScript Files
|      └── currentDate.js
|      └── populateStates.js
|
├── .env                          # Environment Variables for Docker Compose (credentials and secrets)
├── docker-compose.yml            # Defines and configures multi-container Docker app
├── README.md                     # Project Documentation File
└── .gitignore                    # Untracked files to ignore`

# Use Case:
---

## 🛠️ Usage

After starting the Docker containers:

1.  Navigate to `http://localhost` in your web browser. (
2.  Fill out the data collection form with realtor information.
3.  Submit the form. The data will be stored in the MySQL database.
4.  *(Optional: If you have a way to view the collected data, mention it here, e.g., via a separate admin interface or by connecting to the database.)*

---

## Management

* **Stop containers:**
    `docker-compose down`
* **Restart containers:**
    `docker-compose restart`
* **View container logs:**
    `docker-compose logs -f`  (add service name, e.g., `docker-compose logs -f php`)
* **Connect to MySQL database:**
    ```bash
    docker-compose exec mysql mysql -u root -p
    # Enter your MYSQL_ROOT_PASSWORD when prompted
    ```

---

## Contributing

Contributions are welcome! If you have suggestions for improvements or find any issues, please open an issue or submit a pull request.

1.  Fork the repository.
2.  Create your feature branch (`git checkout -b feature/Feature`).
3.  Commit your changes (`git commit -m 'Add some Feature'`).
4.  Push to the branch (`git push origin feature/Feature`).
5.  Open a Pull Request.

---

## Contact

Justyn Larry - justynlarry@gmail.com
Project Link: [https://github.com/jlarry77/data-collection-engine-app](https://github.com/jlarry77/data-collection-engine-app)

---

## Acknowledgments

* [Docker Documentation](https://docs.docker.com/)
* [PHP Documentation](https://www.php.net/docs.php)
* [Nginx Documentation](https://nginx.org/en/docs/)
* [MySQL Documentation](https://dev.mysql.com/doc/)

