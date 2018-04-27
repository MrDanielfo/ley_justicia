<?php

namespace LeyJusticiaBundle\Entity;
use LeyJusticiaBundle\Entity\Entry;
use LeyJusticiaBundle\Entity\Tag; 

/**
 * EntryTag
 */
class EntryTag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \LeyJusticiaBundle\Entity\Entries
     */
    private $entry;

    /**
     * @var \LeyJusticiaBundle\Entity\Tags
     */
    private $tag;


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
     * Set entry
     *
     * @param \LeyJusticiaBundle\Entity\Entry $entry
     *
     * @return EntryTag
     */
    public function setEntry(Entry $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \LeyJusticiaBundle\Entity\Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set tag
     *
     * @param \LeyJusticiaBundle\Entity\Tag $tag
     *
     * @return EntryTag
     */
    public function setTag(Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \LeyJusticiaBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}

