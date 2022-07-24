<?php

namespace AddressBook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonthLookup
 *
 * @ORM\Table(name="month_lookup")
 * @ORM\Entity(repositoryClass="AddressBook\Repository\MonthLookupRepository")
 */
class MonthLookup
{
    /**
     * @var int
     *
     * @ORM\Column(name="bmonth_num", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bmonthNum = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="bmonth", type="string", length=50, nullable=false)
     */
    private $bmonth = '';

    /**
     * @var string
     *
     * @ORM\Column(name="bmonth_short", type="string", length=3, nullable=false, options={"fixed"=true})
     */
    private $bmonthShort = '';

    public function getBmonthNum(): ?int
    {
        return $this->bmonthNum;
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

    public function getBmonthShort(): ?string
    {
        return $this->bmonthShort;
    }

    public function setBmonthShort(string $bmonthShort): self
    {
        $this->bmonthShort = $bmonthShort;

        return $this;
    }


}
