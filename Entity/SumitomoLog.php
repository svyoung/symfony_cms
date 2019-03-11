<?php

namespace CIR\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SumitomoLog
 *
 * @ORM\Table(name="sumitomo_log", indexes={@ORM\Index(name="sub_id", columns={"sub_id"})})
 * @ORM\Entity
 */
class SumitomoLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="sub_id", type="integer", nullable=false)
     */
    protected $subId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="shipdate", type="date", nullable=false)
     */
    protected $shipdate;

    /**
     * @var string
     *
     * @ORM\Column(name="blno", type="string", length=50, nullable=true)
     */
    protected $blno;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtyshipped", type="integer", nullable=false)
     */
    protected $qtyshipped;

    /**
     * @ORM\ManyToOne(targetEntity="SumitomoSub", inversedBy="log")
     * @ORM\JoinColumn(name="sub_id", referencedColumnName="id")
     */
    protected $sub;


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
     * Set subId
     *
     * @param integer $subId
     * @return SumitomoLog
     */
    public function setSubId($subId)
    {
        $this->subId = $subId;

        return $this;
    }

    /**
     * Get subId
     *
     * @return integer 
     */
    public function getSubId()
    {
        return $this->subId;
    }

    /**
     * Set shipdate
     *
     * @param \DateTime $shipdate
     * @return SumitomoLog
     */
    public function setShipdate($shipdate)
    {
        $this->shipdate = $shipdate;

        return $this;
    }

    /**
     * Get shipdate
     *
     * @return \DateTime 
     */
    public function getShipdate()
    {
        return $this->shipdate;
    }

    /**
     * Set blno
     *
     * @param string $blno
     * @return SumitomoLog
     */
    public function setBlno($blno)
    {
        $this->blno = $blno;

        return $this;
    }

    /**
     * Get blno
     *
     * @return string 
     */
    public function getBlno()
    {
        return $this->blno;
    }

    /**
     * Set qtyshipped
     *
     * @param integer $qtyshipped
     * @return SumitomoLog
     */
    public function setQtyshipped($qtyshipped)
    {
        $this->qtyshipped = $qtyshipped;

        return $this;
    }

    /**
     * Get qtyshipped
     *
     * @return integer 
     */
    public function getQtyshipped()
    {
        return $this->qtyshipped;
    }

    /**
     * Set main
     *
     * @param \CIR\Bundle\Entity\SumitomoSub $main
     * @return SumitomoLog
     */
    public function setMain(\CIR\Bundle\Entity\SumitomoSub $main = null)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return \CIR\Bundle\Entity\SumitomoSub 
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set sub
     *
     * @param \CIR\Bundle\Entity\SumitomoSub $sub
     * @return SumitomoLog
     */
    public function setSub(\CIR\Bundle\Entity\SumitomoSub $sub = null)
    {
        $this->sub = $sub;

        return $this;
    }

    /**
     * Get sub
     *
     * @return \CIR\Bundle\Entity\SumitomoSub 
     */
    public function getSub()
    {
        return $this->sub;
    }
}
