<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;

use Gedmo\Mapping\Annotation as Gedmo; // this will be like an alias for Gedmo extensions annotations

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * @AttributeOverrides({
 *     @AttributeOverride(name="email",
 *         column=@ORM\Column(
 *             name="email",
 *             type="string",
 *             length=180,
 *             unique=true,
 *             nullable=true
 *         )
 *     ),
 *
 *     @AttributeOverride(name="emailCanonical",
 *         column=@ORM\Column(
 *             name="email_canonical",
 *             type="string",
 *             length=180,
 *             unique=false,
 *             nullable=true
 *         )
 *     ),
 *
 *     @AttributeOverride(name="username",
 *         column=@ORM\Column(
 *             name="username",
 *             type="string",
 *             length=180,
 *             nullable=true
 *         )
 *     ),
 *
 *     @AttributeOverride(name="usernameCanonical",
 *         column=@ORM\Column(
 *             name="username_canonical",
 *             type="string",
 *             length=180,
 *             unique=false,
 *             nullable=true
 *         )
 *     ),
 * 
 *     @AttributeOverride(name="password",
 *         column=@ORM\Column(
 *             name="password",
 *             type="string",
 *             length=255,
 *             unique=false,
 *             nullable=true
 *         )
 *     )
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Name is too short.",
     *     maxMessage="Name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Name is too short.",
     *     maxMessage="Name is too long."
     * )
     */
    private $middle_name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Name is too short.",
     *     maxMessage="Name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $last_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        $ret = '';

        if (!empty($this->first_name)) $ret .= $this->first_name;

        if (!empty($this->middle_name)) {
            if (!empty($ret)) $ret .= ' ';
            $ret .= $this->middle_name;
        }

        if (!empty($this->last_name)) {
            if (!empty($ret)) $ret .= ' ';
            $ret .= $this->last_name;
        }

        return $ret;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(?string $middle_name): self
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }
}