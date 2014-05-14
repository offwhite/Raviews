# Raviews - Makes up Reviews

## Description

    A searchable database of randomly generated movie reviews.

### Live example

    [raviews.offwhitedesign.co.uk][http://raviews.offwhitedesign.co.uk/]

## Installing

    curl -s https://getcomposer.org/installer | php
    php composer.phar update

    cp app/config/parameters.yml.dist app/config/parameters.yml

    // If not prompted by composer update: update your database details:
    vi app/config/parameters.yml

    php app/console doctrine:database:create
    php app/console doctrine:migrations:migrate
    php app/console db:update

current todo:

    [ ] sort out a 404 page