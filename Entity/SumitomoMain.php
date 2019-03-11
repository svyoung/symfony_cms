<?php

namespace CIR\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SumitomoMain
 *
 * @ORM\Table(name="sumitomo_main", indexes={@ORM\Index(name="dano", columns={"dano"})})
 * @ORM\Entity(repositoryClass="CIR\Bundle\Entity\SumitomoMainRepository")
 */
class SumitomoMain
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
     * @var \DateTime
     *
     * @ORM\Column(name="indate", type="date", nullable=true)
     */
    protected $indate;

    /**
     * @var string
     *
     * @ORM\Column(name="dano", type="string", length=50, nullable=false)
     */
    protected $dano;

    /**
     * @var string
     *
     * @ORM\Column(name="partno", type="string", length=50, nullable=false)
     */
    protected $partno;

    /**
     * @var integer
     *
     * @ORM\Column(name="batchno", type="integer", nullable=true)
     */
    protected $batchno;

    /**
 * @var Sub
 * @ORM\OneToMany(targetEntity="SumitomoSub", mappedBy="main", cascade={"persist"})
 */
    protected $sub;

    public function __construct() {
        $this->sub = new ArrayCollection();
    }

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
     * Set indate
     *
     * @param \DateTime $indate
     * @return SumitomoMain
     */
    public function setIndate($indate)
    {
        $this->indate = $indate;

        return $this;
    }

    /**
     * Get indate
     *
     * @return \DateTime 
     */
    public function getIndate()
    {
        return $this->indate;
    }

    /**
     * Set dano
     *
     * @param string $dano
     * @return SumitomoMain
     */
    public function setDano($dano)
    {
        $this->dano = $dano;

        return $this;
    }

    /**
     * Get dano
     *
     * @return string 
     */
    public function getDano()
    {
        return $this->dano;
    }

    /**
     * Set partno
     *
     * @param string $partno
     * @return SumitomoMain
     */
    public function setPartno($partno)
    {
        $this->partno = $partno;

        return $this;
    }

    /**
     * Get partno
     *
     * @return string 
     */
    public function getPartno()
    {
        return $this->partno;
    }

    /**
     * Set batchno
     *
     * @param integer $batchno
     * @return SumitomoMain
     */
    public function setBatchno($batchno)
    {
        $this->batchno = $batchno;

        return $this;
    }

    /**
     * Get batchno
     *
     * @return integer 
     */
    public function getBatchno()
    {
        return $this->batchno;
    }



    /**
     * Set sub
     *
     * @param string $sub
     * @return SumitomoMain
     */
    public function setSub($sub)
    {
        $this->sub = $sub;

        return $this;
    }

    /**
     * Get sub
     *
     * @return string 
     */
    public function getSub()
    {
        return $this->sub;
    }

    /**
     * Add sub
     *
     * @param \CIR\Bundle\Entity\SumitomoSub $sub
     * @return SumitomoMain
     */
    public function addSub(\CIR\Bundle\Entity\SumitomoSub $sub)
    {
//        $this->sub[] = $sub;
//
//        return $this;

        $sub->setMain($this);
        $this->sub->add($sub);
        return $this;

    }

    /**
     * Remove sub
     *
     * @param \CIR\Bundle\Entity\SumitomoSub $sub
     */
    public function removeSub(\CIR\Bundle\Entity\SumitomoSub $sub)
    {
        $this->sub->removeElement($sub);
    }
}
