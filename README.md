# Raviews - Makes up Reviews

## Description

    A searchable database of randomly generated movie reviews.

## Installing

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

    cp app/config/parameters.yml.dist app/config/parameters.yml

    // update your database details:
    vi app/config/parameters.yml

    php app/console doctrine:database:create
    php app/console doctrine:migrations:migrate
    php app/console db:update

current todo:

    [ ] get extra search results by ajax and add a "more results found - load now?" button
    [ ] sort out a 404 page

