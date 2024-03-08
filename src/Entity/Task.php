<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Task
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->isDone = false;
    }

    /**
     * Get id
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get created_at
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created_at
     * @param $createdAt created at
     *
     * @return void
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get title
     *
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set title
     * @param $title title
     *
     * @return void
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * Get content
     *
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set content
     * @param $content content
     *
     * @return void
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * Get isDone
     */
    public function isDone()
    {
        return $this->isDone;
    }

    /**
     * Set isDone
     * @param $flag flag
     *
     * @return void
     */
    public function toggle($flag): void
    {
        $this->isDone = $flag;
    }

    /**
     * Get user
     *
     * @return ?User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set user
     * @param ?User $user user
     *
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
