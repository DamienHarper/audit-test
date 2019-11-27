<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DH\DoctrineAuditBundle\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RelationshipRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Audit\Auditable
 */
class Relationship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $relationship;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->status = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function setRelationship(string $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt): self
    {
        $this->deletedAt = $deletedAt;
    }

    public function isEnabled()
    {
        return $this->status;
    }
}
