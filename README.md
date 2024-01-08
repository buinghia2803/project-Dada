# DOCKER
## Getting started

  1. Clone project back-end and front-end to a folder.

  **Example:**
  ```
  root folder
   ├── backend
   ├── front-end
   ├── docker
   ├── docker-compose.yml
  ```

  2. Copy ``.env`` from ``.env.example``

  3. Change value of ``.env``

## Running
  1. In root folder run ``docker-compose up -d``(if first build then add --build)
  2. Run ``docker exec -it base-api /bin/sh``
  3. Run ``composer install``
  3. Run ``php artisan key:generate``
  4. Run ``php artisan migrate --seed``
  5. Run ``php artisan passport:install --force``
