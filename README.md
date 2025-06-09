# Data Collection Engine (DCE) - Dockerized Microservices Application
![Docker Build](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-009639?style=for-the-badge&logo=nginx&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Kubernetes](https://img.shields.io/badge/Kubernetes-326CE5?style=for-the-badge&logo=kubernetes&logoColor=white)
![K3s](https://img.shields.io/badge/K3s-F1621E?style=for-the-badge&logo=k3s&logoColor=white)

# Project Overview
Originally hosted on a home system using Apache and exposed via a Cloudflare Tunnel, the application served a crucial role in **gathering real estate agent data for a local roofing company**, storing it in a MySQL database for marketing purposes.

#Purpose:
This transformation serves as a practical learning exercise focused scalability, isolation, portability, lightweight deployment, and hardware independence for web applications, extending from Docker Compose to Kubernetes (K3s) environment.  Creating distinct services (Nginx, PHP-FPM, MySQL) demostrates the advantages of containerization and microservices principles over monolithic applications.

## Features

* **Data Collection:** Gathers realtor contact information via a web form.
* **Database Storage:** Stores collected data in a MySQL database.
* **Microservices Architecture:** Deployed as independent Nginx, PHP-FPM, and MySQL Docker containers.
* **Containerized Environment:** Ensures portability and consistent behavior across different host environments.
* **Scalability:** Individual services can be scaled independently.
* **Isolation:** Services run in isolated environments, preventing dependency conflicts.
* **Lightweight & Portable:** Reduced resource footprint compared to traditional VM deployments.
* **Kubernetes Integration:** Designed for deployment on a Kubernetes cluster (specifically tested with K3s).
* **Load Balancing:** Implemented using **MetalLB** for external service exposure in bare-metal K3s clusters.


---

## Local Development (Docker Compose)

These instructions will get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites (Docker Compose)

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

---

## Kubernetes Deployment (K3s)

This section details how to deploy the Data Collection Engine application onto a K3s cluster.

### Prerequisites (K3s)

Before you begin, ensure you have the following installed and configured:

* **K3s Cluster:** A running K3s cluster on your desired host (e.g., a Raspberry Pi, a VM, or a dedicated server). Ensure your `kubeconfig` is properly set up to connect to your K3s cluster.
* **kubectl:** The Kubernetes command-line tool, configured to interact with your K3s cluster.
* **Docker:** Still required locally to build container images before loading them into K3s.
* **Git:** For cloning the repository.
* * **Dedicated IP Address Range for MetalLB:** A range of IP addresses on your local network that MetalLB can assign to `LoadBalancer` services. This range must be:
    * Outside your router's DHCP range.
    * Within the same subnet as your K3s node(s).
    * **Example:** If your K3s node is `192.168.1.100`, you might use `192.168.1.200-192.168.1.210`.

### Key Deployment Considerations (Important!)

Deploying containerized applications in Kubernetes often requires careful attention to how files are shared and served. In this project, we've specifically addressed common pitfalls:

* **Shared Volume Consistency:** Both Nginx and PHP-FPM pods use an `emptyDir` volume to share the application code. It is critical that the `git clone` command within the `initContainer` for both deployments clones the repository into the *exact same subdirectory structure* on this shared volume.
    * The `initContainers` are configured to clone the repository into `/app/repo` within the shared volume.
    * This ensures the application's `html` directory (containing `index.php`) is consistently located at `/var/www/html/repo/html/` for both Nginx and PHP-FPM.

* **Nginx Root Directive:** Nginx's `root` directive in `docker/nginx/default.conf` *must* precisely match this consistent path (`/var/www/html/repo/html/`) to correctly serve the application's entry point (`index.php`) and other static assets.

### * **Service Exposure (NodePort):** The Nginx service is exposed via a `NodePort` (default `30080`) to allow external access to the web application from your host's IP address. -> **** THIS SERVICE DEPRECTATED WHEN METALLB WAS CONFIGURED ****

* **Load Balancing with MetalLB:** The Nginx service is configured as `type: LoadBalancer`. MetalLB will automatically assign an external IP address from its configured pool, making the application accessible on that IP without needing to know NodePorts.


### Installation and Setup (K3s)

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/jlarry77/data-collection-engine-app.git](https://github.com/jlarry77/data-collection-engine-app.git)
    cd data-collection-engine-app
    ```

2.  **Configure Environment Variables and Secrets:**
    Copy the example environment file and populate it with your desired MySQL credentials. This `.env` file is used *locally* for `docker-compose`. For Kubernetes, these variables are consumed by `k3s/mysql-secret.yaml`.
    ```bash
    cp .env.example .env
    ```
    Open `.env` and fill in the `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, and `MYSQL_PASSWORD` variables.

    * **Create Kubernetes Secret:** Before deploying, create the Kubernetes Secret for MySQL credentials. This secret is referenced by the `mysql-deployment.yaml`.
        ```bash
        kubectl create secret generic mysql-credentials \
          --from-literal=mysql-root-password=$MYSQL_ROOT_PASSWORD \
          --from-literal=mysql-database=$MYSQL_DATABASE \
          --from-literal=mysql-user=$MYSQL_USER \
          --from-literal=mysql-password=$MYSQL_PASSWORD
        ```
        (Replace `$MYSQL_ROOT_PASSWORD` etc. with the values from your `.env` file, or ensure they are in your shell environment.)

3.  **Install and Configure MetalLB:**
    ```bash
    # Create the metallb-system namespace
    kubectl create namespace metallb-system

    # Apply the MetalLB manifests
    kubectl apply -f [https://raw.githubusercontent.com/metallb/metallb/v0.13.7/config/manifests/metallb-native.yaml](https://raw.githubusercontent.com/metallb/metallb/v0.13.7/config/manifests/metallb-native.yaml)

    # Apply MetalLB IP address pool configuration (replace with your IP range!)
    # Create k3s/metallb-ipaddress-pool.yaml with content below:
    # ---
    # apiVersion: metallb.io/v1beta1
    # kind: IPAddressPool
    # metadata:
    #   name: default-pool
    #   namespace: metallb-system
    # spec:
    #   addresses:
    #     - 192.168.1.200-192.168.1.210 # <--- IMPORTANT: REPLACE THIS RANGE
    # ---
    # apiVersion: metallb.io/v1beta1
    # kind: L2Advertisement
    # metadata:
    #   name: default-advertisement
    #   namespace: metallb-system
    # spec:
    #   ipAddressPools:
    #     - default-pool
    kubectl apply -f k3s/metallb-ipaddress-pool.yaml
    ```

4.  **Build and Push Docker Images to Docker Hub:**
    These images will be pulled by K3s during deployment. **Remember to replace `yourusername` with your actual Docker Hub username.**
    ```bash
    # Build and push Nginx image
    docker build -t yourusername/my-nginx:latest docker/nginx/
    docker push yourusername/my-nginx:latest

    # Build and push PHP-FPM image
    docker build -t yourusername/my-php-fpm:latest docker/php/
    docker push yourusername/my-php-fpm:latest
    ```

5.  **Deploy Kubernetes Manifests:**
    Apply all the Kubernetes manifest files from the `k3s/` directory.

    ```bash
    cd k3s/
    kubectl apply -f .
    cd .. # Go back to root directory
    ```

6.  **Verify Pod and Service Status:**
    Ensure all pods are running and Nginx service has an external IP:
    ```bash
    kubectl get pods
    kubectl get svc nginx-service -o wide
    ```
    Look for the `EXTERNAL-IP` for `nginx-service`; this will be the address provided by MetalLB.

7.  **Access the Application:**
    Open your web browser and navigate to the MetalLB assigned IP address:
    ```
    http://<MetalLB_Assigned_IP_Address>
    ```

# File Structure:

```
dc_engine/
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
├── .gitignore                    # Untracked files to ignore
└── k3s/
    ├── mysql-deployment.yaml         # Defines the MySQL Pod and its configuration
    ├── mysql-pvc.yaml                # Defines a Persistent Volume Claim for MySQL Data
    ├── mysql-secret.yaml             # Stores sensitive MySQL credentials securely
    ├── mysql-service.yaml            # Exposes the MySQL database within the cluster
    ├── nginx-deployment.yaml         # Defines the Nginx Pod, including initContianer for code cloning
    ├── nginx-service.yaml            # Exposes the Nginx web server via NodePort  
    ├── php-fpm-deployment.yaml       # Defines teh PHP-FPM Pod, including initContainer for code cloning
    └── php-fpm-service.yaml          # Exposes the PHP-FPM service to Nginx
    └── metallb-ipaddress-pool.yaml   # MetalLB IP address pool configuration


```

# Use Case:
---

## 🛠️ Usage

After starting the Docker containers (for Docker Compose) or deploying to K3s:

1.  **For Docker Compose:** Navigate to `http://localhost` in your web browser.
2.  **For K3s (MetalLB):** Navigate to the IP address assigned by MetalLB (e.g., `http://192.168.1.200`) in your web browser.
3.  Fill out the data collection form with realtor information.
4.  Submit the form. The data will be stored in the MySQL database.
5.  *(Optional: If you have a way to view the collected data, mention it here, e.g., via a separate admin interface or by connecting to the database.)*
   
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

### Kubernetes (K3s) Management

* **Check Pods status:**
    ```bash
    kubectl get pods
    ```
* **View logs for a specific pod (e.g., Nginx):**
    ```bash
    kubectl logs <nginx-pod-name>
    ```
    (Replace `<nginx-pod-name>` with the actual name from `kubectl get pods`)
* **Execute a command inside a running pod (e.g., list files in Nginx app directory):**
    ```bash
    kubectl exec -it <nginx-pod-name> -- ls -l /var/www/html/repo/html/
    ```
* **Delete all deployments and services (for a clean slate):**
    ```bash
    kubectl delete -f k3s/ # Run from your project root
    ```
* **Reapply all deployments and services:**
    ```bash
    kubectl apply -f k3s/ # Run from your project root
    ```

---


---

## Troubleshooting Common Issues

### "File Not Found" or "403 Forbidden" Errors

These errors often indicate a mismatch in file paths between Nginx and PHP-FPM or incorrect Nginx configuration.

* **Path Mismatch:** The most common cause is that Nginx is telling PHP-FPM to look for a script at a path where PHP-FPM doesn't actually see it.
    * **Verify consistent volume content:**
        * Get pod names: `kubectl get pods`
        * Check Nginx's view: `kubectl exec -it <nginx-pod-name> -- ls -l /var/www/html/repo/html/`
        * Check PHP-FPM's view: `kubectl exec -it <php-fpm-pod-name> -- ls -l /var/www/html/repo/html/`
        * **Both outputs MUST show your application files (`index.php`, `css/`, etc.).** If one is different, re-check your `initContainer` command in the respective deployment YAML (`command: ["git", "clone", "...", "/app/repo"]`) and re-apply the deployment.
    * **Verify Nginx `root` directive:** Ensure `docker/nginx/default.conf` has `root /var/www/html/repo/html/;` and that you've rebuilt the `my-nginx:latest` image and reapplied the Nginx deployment after any changes.

* **Check Nginx logs:** For "403 Forbidden" or other Nginx-specific errors:
    ```bash
    kubectl logs <nginx-pod-name>
    ```

* **Check PHP-FPM logs:** For "File Not Found" errors coming directly from PHP:
    ```bash
    kubectl logs <php-fpm-pod-name>
    ```

### Container CrashLoopBackOff

If a pod is repeatedly starting and crashing:

* **Check logs:** Immediately check the logs of the crashing pod to identify the error.
    ```bash
    kubectl logs <pod-name>
    ```
* **Check previous logs (if it exited quickly):**
    ```bash
    kubectl logs <pod-name> --previous
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
* [K3s Documentation](https://k3s.io/docs/)
* [Kubernetes Documentation](https://kubernetes.io/docs/)
* [MetalLB Documentation](https://metallb.universe.tf/concepts/)

