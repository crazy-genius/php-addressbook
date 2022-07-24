<?php

namespace AddressBook\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupList
 *
 * @ORM\Table(name="group_list")
 * @ORM\Entity(repositoryClass="AddressBook\Repository\GroupRepository")
 */
class Group
{
    /**
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $domainId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="group_parent_id", type="integer", nullable=true)
     */
    private $groupParentId;

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

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=255, nullable=false)
     */
    private $groupName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="group_header", type="text", length=16777215, nullable=false)
     */
    private $groupHeader;

    /**
     * @var string
     *
     * @ORM\Column(name="group_footer", type="text", length=16777215, nullable=false)
     */
    private $groupFooter;

    public function getDomainId(): ?int
    {
        return $this->domainId;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function getGroupParentId(): ?int
    {
        return $this->groupParentId;
    }

    public function setGroupParentId(?int $groupParentId): self
    {
        $this->groupParentId = $groupParentId;

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

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getGroupHeader(): ?string
    {
        return $this->groupHeader;
    }

    public function setGroupHeader(string $groupHeader): self
    {
        $this->groupHeader = $groupHeader;

        return $this;
    }

    public function getGroupFooter(): ?string
    {
        return $this->groupFooter;
    }

    public function setGroupFooter(string $groupFooter): self
    {
        $this->groupFooter = $groupFooter;

        return $this;
    }


}
