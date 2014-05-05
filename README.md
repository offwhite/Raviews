# Raviews - Makes up Reviews

## Description

    A searchable database of randomly generated movie reviews.

## Installing

    curl -s https://getcomposer.org/installer | php  // you might need curl -s https://getcomposer.org/installer | sudo php
    php composer.phar install

    cp app/config/parameters.yml.dist app/config/parameters.yml

    // update database details:
    vi app/config/parameters.yml

    php app/console doctrine:database:create
    php app/console doctrine:migrations:migrate
    php app/console db:update

current todo:

[y] add random movie to homepage
[y] sort out director population
[y] add year of release
[y] check symfony version - ensure 2.4
[ ] get extra search results by ajax and add a "more results found - load now?" button
[ ] unit tests
[y] add movie title to url
[x] full text searching for movie by title
[ ] sort out a 404 page
[y] add cast to movie entity

