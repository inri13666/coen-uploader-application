1. composer create-project akuma/coen-uploader:dev-master
2. cd coen-uploader
3. composer install
4. modify "config.yml" ( you can add new options at "parameters.yml" and use them at "config.yml")
5. php app/console doctrine:database:create
5. php app/console doctrine:schema:update --force
5. configure web server
