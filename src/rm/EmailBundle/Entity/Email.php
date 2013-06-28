<?php

namespace rm\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rm\EmailBundle\Entity\EmailRepository")
 */
class Email
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255)
     * @Assert\Length(min="2", minMessage="L'objet doit faire au moins {{ limit }} caractères.")
     */
    private $object;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isFavorite", type="boolean")
     */
    private $isFavorite;

    /**
     * @ORM\ManyToMany(targetEntity="rm\EmailBundle\Entity\Categorie", cascade={"persist"}, inversedBy="emails")
     * @Assert\Valid()
     */
    private $categories;


    public function __construct()
    {
        $this->date = new \DateTime();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Email
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set object
     *
     * @param string $object
     * @return Email
     */
    public function setObject($object)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return string 
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Email
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
     * Set isFavorite
     *
     * @param boolean $isFavorite
     * @return Email
     */
    public function setIsFavorite($isFavorite)
    {
        $this->isFavorite = $isFavorite;
    
        return $this;
    }

    /**
     * Get isFavorite
     *
     * @return boolean 
     */
    public function getIsFavorite()
    {
        return $this->isFavorite;
    }

    /**
     * Add categories
     *
     * @param \rm\EmailBundle\Entity\Categorie $categories
     * @return Email
     */
    public function addCategorie(\rm\EmailBundle\Entity\Categorie $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \rm\EmailBundle\Entity\Categorie $categories
     */
    public function removeCategorie(\rm\EmailBundle\Entity\Categorie $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}