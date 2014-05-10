<?php

namespace Offwhite\RaviewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="Offwhite\RaviewBundle\Entity\Repository\MovieRepository")
 * @ORM\Table(name="movie")
 * @ORM\HasLifecycleCallbacks()
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $raview;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $director = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $runtime = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tagLine = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $overview;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $imagePoster;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $imageBackground;

    /**
     * @ORM\Column(type="string", length=16, nullable=true, unique=true)
     */
    protected $imdbId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $cast;

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;


    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;



    public function __construct()
    {
        $this->cast = new ArrayCollection();

        $this->setCreated(new \DateTime());
    }


    /*
     * generate a url safe slug
     *
     * @require $text string
     *
     * @return $text string
     */
    public function generateSlug($text)
    {

        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    /*
     * ==============================
     *  AUTO GENERATED METHODS BELOW
     * ==============================
     */

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        $this->setSlug($this->title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Movie
     */
    public function setSlug($slug)
    {
        $this->slug = $this->generateSlug($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set raview
     *
     * @param string $raview
     * @return Movie
     */
    public function setRaview($raview)
    {
        $this->raview = $raview;

        return $this;
    }

    /**
     * Get raview
     *
     * @return string 
     */
    public function getRaview()
    {
        return $this->raview;
    }

    /**
     * Set director
     *
     * @param string $director
     * @return Movie
     */
    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return string 
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set runtime
     *
     * @param integer $runtime
     * @return Movie
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return integer 
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set tagLine
     *
     * @param string $tagLine
     * @return Movie
     */
    public function setTagLine($tagLine)
    {
        $this->tagLine = $tagLine;

        return $this;
    }

    /**
     * Get tagLine
     *
     * @return string 
     */
    public function getTagLine()
    {
        return $this->tagLine;
    }

    /**
     * Set overview
     *
     * @param string $overview
     * @return Movie
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return string 
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Set imagePoster
     *
     * @param string $imagePoster
     * @return Movie
     */
    public function setImagePoster($imagePoster)
    {
        $this->imagePoster = $imagePoster;

        return $this;
    }

    /**
     * Get imagePoster
     *
     * @return string 
     */
    public function getImagePoster()
    {
        return $this->imagePoster;
    }

    /**
     * Set imageBackground
     *
     * @param string $imageBackground
     * @return Movie
     */
    public function setImageBackground($imageBackground)
    {
        $this->imageBackground = $imageBackground;

        return $this;
    }

    /**
     * Get imageBackground
     *
     * @return string 
     */
    public function getImageBackground()
    {
        return $this->imageBackground;
    }

    /**
     * Set imdbId
     *
     * @param integer $imdbId
     * @return Movie
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return integer 
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Movie
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Movie
     */
    public function setRating( $rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set cast
     *
     * @param string $cast
     * @return Movie
     */
    public function setCast($cast)
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * Get cast
     *
     * @return array
     */
    public function getCast()
    {
        $cast = explode('||',$this->cast);

        return $cast;
    }
}
