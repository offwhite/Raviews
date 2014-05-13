
## Review Components

Review Components are the individual elements that are used to generate each review.

_foundations.yml is required_

The process starts by selecting a Foundation using the rating of the movie supplied.
For example:

    If there are 10 entries in the Foundations array
    a movie with a rating of 1 will start with foundation[0]
    a movie with a rating of 50 will start with foundation[5]
    a movie with a rating of 99 will start with foundation[9]

Therefor foundations that generate better reviews should have a higher index in the foundation array

## Processing

Any placeholders found in foundations will require a corresponding array

## e.g.

If you write a new foundation entry which has a {hats_01} placeholder
you must create a hats.yml containing a hats array:


### src/Offwhite/RaviewBundle/Resources/reviewComponents/hats.yml

    hats:
        0: "Top hat"
        1: "Bowler hat"
        2: "Deerhunter"


### NOTE:

Reserved placeholder type names are:

    director
    actor
    character
    year
    runtime
    rating