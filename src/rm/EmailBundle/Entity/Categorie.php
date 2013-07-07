<?php

namespace rm\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rm\EmailBundle\Entity\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min="2", minMessage="L'objet doit faire au moins {{ limit }} caractères.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     * @Assert\Regex(pattern="/^#(?:[0-9a-f]{3}){1,2}$/", message="La couleur doit être au format hexadécimale")
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity="rm\EmailBundle\Entity\Email", mappedBy="categories")
     * @Assert\Valid()
     */
    private $emails;

    /**
     * @ORM\ManyToOne(targetEntity="rm\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $user;


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
     * @return Categorie
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
     * Constructor
     */
    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add emails
     *
     * @param \rm\EmailBundle\Entity\Email $emails
     * @return Categorie
     */
    public function addEmail(\rm\EmailBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;
    
        return $this;
    }

    /**
     * Remove emails
     *
     * @param \rm\EmailBundle\Entity\Email $emails
     */
    public function removeEmail(\rm\EmailBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Categorie
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set user
     *
     * @param \rm\UserBundle\Entity\User $user
     * @return Categorie
     */
    public function setUser(\rm\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \rm\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}