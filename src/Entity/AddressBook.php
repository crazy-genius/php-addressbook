<?php

namespace AddressBook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Addressbook
 *
 * @ORM\Table(name="addressbook", indexes={@ORM\Index(name="deprecated_domain_id_idx", columns={"deprecated", "domain_id"})})
 * @ORM\Entity(repositoryClass="AddressBook\Repository\AddressBookRepository")
 */
class AddressBook
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="middlename", type="string", length=255, nullable=false)
     */
    private $middlename;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=false)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", length=65535, nullable=false)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addr_long", type="text", length=65535, nullable=true)
     */
    private $addrLong;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addr_lat", type="text", length=65535, nullable=true)
     */
    private $addrLat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addr_status", type="text", length=65535, nullable=true)
     */
    private $addrStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="home", type="text", length=65535, nullable=false)
     */
    private $home;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="text", length=65535, nullable=false)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="work", type="text", length=65535, nullable=false)
     */
    private $work;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="text", length=65535, nullable=false)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="text", length=65535, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email2", type="text", length=65535, nullable=false)
     */
    private $email2;

    /**
     * @var string
     *
     * @ORM\Column(name="email3", type="text", length=65535, nullable=false)
     */
    private $email3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="im", type="text", length=65535, nullable=true)
     */
    private $im;

    /**
     * @var string|null
     *
     * @ORM\Column(name="im2", type="text", length=65535, nullable=true)
     */
    private $im2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="im3", type="text", length=65535, nullable=true)
     */
    private $im3;

    /**
     * @var string
     *
     * @ORM\Column(name="homepage", type="text", length=65535, nullable=false)
     */
    private $homepage;

    /**
     * @var bool
     *
     * @ORM\Column(name="bday", type="boolean", nullable=false)
     */
    private $bday;

    /**
     * @var string
     *
     * @ORM\Column(name="bmonth", type="string", length=50, nullable=false)
     */
    private $bmonth;

    /**
     * @var string
     *
     * @ORM\Column(name="byear", type="string", length=4, nullable=false)
     */
    private $byear;

    /**
     * @var bool
     *
     * @ORM\Column(name="aday", type="boolean", nullable=false)
     */
    private $aday;

    /**
     * @var string
     *
     * @ORM\Column(name="amonth", type="string", length=50, nullable=false)
     */
    private $amonth;

    /**
     * @var string
     *
     * @ORM\Column(name="ayear", type="string", length=4, nullable=false)
     */
    private $ayear;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="text", length=65535, nullable=false)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="text", length=65535, nullable=false)
     */
    private $phone2;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=65535, nullable=false)
     */
    private $notes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="text", length=16777215, nullable=true)
     */
    private $photo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="x_vcard", type="text", length=16777215, nullable=true)
     */
    private $xVcard;

    /**
     * @var string|null
     *
     * @ORM\Column(name="x_activesync", type="text", length=16777215, nullable=true)
     */
    private $xActivesync;

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
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=256, nullable=true)
     */
    private $password;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="login", type="date", nullable=true)
     */
    private $login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=256, nullable=true)
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMiddlename(): ?string
    {
        return $this->middlename;
    }

    public function setMiddlename(string $middlename): self
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddrLong(): ?string
    {
        return $this->addrLong;
    }

    public function setAddrLong(?string $addrLong): self
    {
        $this->addrLong = $addrLong;

        return $this;
    }

    public function getAddrLat(): ?string
    {
        return $this->addrLat;
    }

    public function setAddrLat(?string $addrLat): self
    {
        $this->addrLat = $addrLat;

        return $this;
    }

    public function getAddrStatus(): ?string
    {
        return $this->addrStatus;
    }

    public function setAddrStatus(?string $addrStatus): self
    {
        $this->addrStatus = $addrStatus;

        return $this;
    }

    public function getHome(): ?string
    {
        return $this->home;
    }

    public function setHome(string $home): self
    {
        $this->home = $home;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getWork(): ?string
    {
        return $this->work;
    }

    public function setWork(string $work): self
    {
        $this->work = $work;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail2(): ?string
    {
        return $this->email2;
    }

    public function setEmail2(string $email2): self
    {
        $this->email2 = $email2;

        return $this;
    }

    public function getEmail3(): ?string
    {
        return $this->email3;
    }

    public function setEmail3(string $email3): self
    {
        $this->email3 = $email3;

        return $this;
    }

    public function getIm(): ?string
    {
        return $this->im;
    }

    public function setIm(?string $im): self
    {
        $this->im = $im;

        return $this;
    }

    public function getIm2(): ?string
    {
        return $this->im2;
    }

    public function setIm2(?string $im2): self
    {
        $this->im2 = $im2;

        return $this;
    }

    public function getIm3(): ?string
    {
        return $this->im3;
    }

    public function setIm3(?string $im3): self
    {
        $this->im3 = $im3;

        return $this;
    }

    public function getHomepage(): ?string
    {
        return $this->homepage;
    }

    public function setHomepage(string $homepage): self
    {
        $this->homepage = $homepage;

        return $this;
    }

    public function isBday(): ?bool
    {
        return $this->bday;
    }

    public function setBday(bool $bday): self
    {
        $this->bday = $bday;

        return $this;
    }

    public function getBmonth(): ?string
    {
        return $this->bmonth;
    }

    public function setBmonth(string $bmonth): self
    {
        $this->bmonth = $bmonth;

        return $this;
    }

    public function getByear(): ?string
    {
        return $this->byear;
    }

    public function setByear(string $byear): self
    {
        $this->byear = $byear;

        return $this;
    }

    public function isAday(): ?bool
    {
        return $this->aday;
    }

    public function setAday(bool $aday): self
    {
        $this->aday = $aday;

        return $this;
    }

    public function getAmonth(): ?string
    {
        return $this->amonth;
    }

    public function setAmonth(string $amonth): self
    {
        $this->amonth = $amonth;

        return $this;
    }

    public function getAyear(): ?string
    {
        return $this->ayear;
    }

    public function setAyear(string $ayear): self
    {
        $this->ayear = $ayear;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getXVcard(): ?string
    {
        return $this->xVcard;
    }

    public function setXVcard(?string $xVcard): self
    {
        $this->xVcard = $xVcard;

        return $this;
    }

    public function getXActivesync(): ?string
    {
        return $this->xActivesync;
    }

    public function setXActivesync(?string $xActivesync): self
    {
        $this->xActivesync = $xActivesync;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLogin(): ?\DateTimeInterface
    {
        return $this->login;
    }

    public function setLogin(?\DateTimeInterface $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDecodedImage(): string
    {
        $b64 = explode(";", $this->getPhoto());
        if (count($b64) >= 3) {
            $b64 = $b64[2];
            $b64 = explode(":", $b64);
            if (count($b64) >= 2) {
                return str_replace(" ", "", $b64[1]);
            }
        }

        return '';
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getAddresses(): array
    {
        return [];
    }

    public function getPhones(): array
    {

        $phones = [];
        if ($this->home !== "") {
            $phones[] = $this->home;
        }
        if ($this->mobile !== "") {
            $phones[] = $this->mobile;
        }
        if ($this->work !== "") {
            $phones[] = $this->work;
        }
        if ($this->phone2 !== "") {
            $phones[] = $this->phone2;
        }

        return $phones;
    }

    public function getEmails(): array
    {
        return [
            $this->email,
            $this->email2,
            $this->email3,
        ];
    }
}
