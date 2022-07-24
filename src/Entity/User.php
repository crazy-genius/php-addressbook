<?php

namespace AddressBook\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AddressBook\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=128, nullable=false, options={"fixed"=true})
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="md5_pass", type="string", length=128, nullable=false, options={"fixed"=true})
     */
    private $md5Pass;

    /**
     * @var string
     *
     * @ORM\Column(name="password_hint", type="string", length=255, nullable=false)
     */
    private $passwordHint = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="sso_facebook_uid", type="string", length=255, nullable=true)
     */
    private $ssoFacebookUid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sso_google_uid", type="string", length=255, nullable=true)
     */
    private $ssoGoogleUid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sso_live_uid", type="string", length=255, nullable=true)
     */
    private $ssoLiveUid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sso_yahoo_uid", type="string", length=255, nullable=true)
     */
    private $ssoYahooUid;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50, nullable=false)
     */
    private $lastname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=false)
     */
    private $firstname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=false)
     */
    private $phone = '';

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=100, nullable=false)
     */
    private $address1 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=100, nullable=false)
     */
    private $address2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=80, nullable=false)
     */
    private $city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=20, nullable=false)
     */
    private $state = '';

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=20, nullable=false)
     */
    private $zip = '';

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=false)
     */
    private $country = '';

    /**
     * @var string
     *
     * @ORM\Column(name="master_code", type="string", length=128, nullable=false, options={"fixed"=true})
     */
    private $masterCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmation_code", type="string", length=128, nullable=true, options={"fixed"=true})
     */
    private $confirmationCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pass_reset_code", type="string", length=128, nullable=true, options={"fixed"=true})
     */
    private $passResetCode;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=128, nullable=false,
     *     options={"default"="NEW","fixed"=true,"comment"="New, Ready, Blocked"})
     */
    private $status = 'NEW';

    /**
     * @var int
     *
     * @ORM\Column(name="trials", type="integer", nullable=false)
     */
    private $trials = '0';

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

    public function getUserId(): ?int
    {
        return $this->userId;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMd5Pass(): ?string
    {
        return $this->md5Pass;
    }

    public function setMd5Pass(string $md5Pass): self
    {
        $this->md5Pass = $md5Pass;

        return $this;
    }

    public function getPasswordHint(): ?string
    {
        return $this->passwordHint;
    }

    public function setPasswordHint(string $passwordHint): self
    {
        $this->passwordHint = $passwordHint;

        return $this;
    }

    public function getSsoFacebookUid(): ?string
    {
        return $this->ssoFacebookUid;
    }

    public function setSsoFacebookUid(?string $ssoFacebookUid): self
    {
        $this->ssoFacebookUid = $ssoFacebookUid;

        return $this;
    }

    public function getSsoGoogleUid(): ?string
    {
        return $this->ssoGoogleUid;
    }

    public function setSsoGoogleUid(?string $ssoGoogleUid): self
    {
        $this->ssoGoogleUid = $ssoGoogleUid;

        return $this;
    }

    public function getSsoLiveUid(): ?string
    {
        return $this->ssoLiveUid;
    }

    public function setSsoLiveUid(?string $ssoLiveUid): self
    {
        $this->ssoLiveUid = $ssoLiveUid;

        return $this;
    }

    public function getSsoYahooUid(): ?string
    {
        return $this->ssoYahooUid;
    }

    public function setSsoYahooUid(?string $ssoYahooUid): self
    {
        $this->ssoYahooUid = $ssoYahooUid;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): self
    {
        $this->address1 = $address1;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMasterCode(): ?string
    {
        return $this->masterCode;
    }

    public function setMasterCode(string $masterCode): self
    {
        $this->masterCode = $masterCode;

        return $this;
    }

    public function getConfirmationCode(): ?string
    {
        return $this->confirmationCode;
    }

    public function setConfirmationCode(?string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    public function getPassResetCode(): ?string
    {
        return $this->passResetCode;
    }

    public function setPassResetCode(?string $passResetCode): self
    {
        $this->passResetCode = $passResetCode;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTrials(): ?int
    {
        return $this->trials;
    }

    public function setTrials(int $trials): self
    {
        $this->trials = $trials;

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
