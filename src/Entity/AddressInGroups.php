<?php

namespace AddressBook\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * AddressInGroups
 *
 * @ORM\Table(name="address_in_groups")
 * @ORM\Entity(repositoryClass="AddressBook\Repository\AddressInGroupsRepository")
 */
class AddressInGroups
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deprecated", type="datetime", nullable=true)
     */
    private $deprecated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function getDomainId(): ?int
    {
        return $this->domainId;
    }

    public function setDomainId(int $domainId): self
    {
        $this->domainId = $domainId;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(?\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    public function getDeprecated(): ?\DateTimeInterface
    {
        return $this->deprecated;
    }

    public function setDeprecated(?\DateTimeInterface $deprecated): self
    {
        $this->deprecated = $deprecated;

        return $this;
    }


}
