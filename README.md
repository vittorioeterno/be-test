# Setup

    git clone https://github.com/vittorioeterno/be-test.git

    composer install


# Install symfony command:

    wget https://get.symfony.com/cli/installer -O - | bash


# Run local server

    symfony server:start

# Call API n. 1

    127.0.0.1:8000/my-api/products

# Call API n. 2

    127.0.0.1:8000/my-api/products?categoryId=2

# Run Tests

    php ./vendor/bin/phpunit