<?php

namespace LeyJusticiaBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use LeyJusticiaBundle\Entity\Category;
use LeyJusticiaBundle\Entity\User; 
use LeyJusticiaBundle\Entity\Tag; 

/**
 * Entry
 */
class Entry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \LeyJusticiaBundle\Entity\Categories
     */
    private $category;

    /**
     * @var \LeyJusticiaBundle\Entity\Users
     */
    private $user;
    
    
    protected $entryTag;
    
    public function __construct() {
        $this->entryTag = new ArrayCollection(); 
    }


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
     *
     * @return Entry
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Set content
     *
     * @param string $content
     *
     * @return Entry
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Entry
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Entry
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \LeyJusticiaBundle\Entity\Categories $category
     *
     * @return Entry
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \LeyJusticiaBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \LeyJusticiaBundle\Entity\User $user
     *
     * @return Entry
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \LeyJusticiaBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    public function addEntryTag(Tag $tag) {
        $this->entryTag[] = $tag;
        
        return $this;
    }
    
    public function getEntryTag() {
        return $this->entryTag; 
    }
    
    
    
    
}

