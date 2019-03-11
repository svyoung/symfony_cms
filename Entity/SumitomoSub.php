<?php

namespace CIR\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * SumitomoSub
 *
 * @ORM\Table(name="sumitomo_sub")
 * @ORM\Entity(repositoryClass="CIR\Bundle\Entity\SumitomoSubRepository")
 */
class SumitomoSub
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
     * @ORM\Column(name="main_id", type="integer")
    */
    protected $mainId;

    /**
     * @var integer
     *
     * @ORM\Column(name="rackno", type="integer", nullable=true)
     */
    protected $rackno;

    /**
     * @var string
     *
     * @ORM\Column(name="heatcode", type="string", length=50, nullable=true)
     */
    protected $heatcode;

    /**
     * @var string
     *
     * @ORM\Column(name="diecode", type="string", length=50, nullable=true)
     */
    protected $diecode;

    /**
     * @var integer
     *
     * @ORM\Column(name="inqty", type="integer", nullable=false)
     */
    protected $inqty;

    /**
     * @var boolean
     *
     * @ORM\Column(name="onhold", type="boolean", nullable=false)
     */
    protected $onhold;

    /**
     * @ORM\ManyToOne(targetEntity="SumitomoMain", inversedBy="sub")
     * @ORM\JoinColumn(name="main_id", referencedColumnName="id")
     */
    protected $main;

    /**
     * @ORM\OneToMany(targetEntity="SumitomoLog", mappedBy="sub")
     */
    protected $log;

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
     * Set mainId
     *
     * @param integer $mainId
     * @return SumitomoSub
     */
    public function setMainId($mainId)
    {
        $this->mainId = $mainId;

        return $this;
    }

    /**
     * Get mainId
     *
     * @return integer
     */
    public function getMainId()
    {
        return $this->mainId;
    }

    /**
     * Set rackno
     *
     * @param integer $rackno
     * @return SumitomoSub
     */
    public function setRackno($rackno)
    {
        $this->rackno = $rackno;

        return $this;
    }

    /**
     * Get rackno
     *
     * @return integer 
     */
    public function getRackno()
    {
        return $this->rackno;
    }

    /**
     * Set heatcode
     *
     * @param string $heatcode
     * @return SumitomoSub
     */
    public function setHeatcode($heatcode)
    {
        $this->heatcode = $heatcode;

        return $this;
    }

    /**
     * Get heatcode
     *
     * @return string 
     */
    public function getHeatcode()
    {
        return $this->heatcode;
    }

    /**
     * Set diecode
     *
     * @param string $diecode
     * @return SumitomoSub
     */
    public function setDiecode($diecode)
    {
        $this->diecode = $diecode;

        return $this;
    }

    /**
     * Get diecode
     *
     * @return string 
     */
    public function getDiecode()
    {
        return $this->diecode;
    }

    /**
     * Set inqty
     *
     * @param integer $inqty
     * @return SumitomoSub
     */
    public function setInqty($inqty)
    {
        $this->inqty = $inqty;

        return $this;
    }

    /**
     * Get inqty
     *
     * @return integer 
     */
    public function getInqty()
    {
        return $this->inqty;
    }

    /**
     * Set onhold
     *
     * @param boolean $onhold
     * @return SumitomoSub
     */
    public function setOnhold($onhold)
    {
        $this->onhold = $onhold;

        return $this;
    }

    /**
     * Get onhold
     *
     * @return boolean 
     */
    public function getOnhold()
    {
        return $this->onhold;
    }

    /**
     * Set main
     *
     * @param \CIR\Bundle\Entity\SumitomoMain $main
     * @return SumitomoSub
     */
    public function setMain(\CIR\Bundle\Entity\SumitomoMain $main = null)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return \CIR\Bundle\Entity\SumitomoMain 
     */
    public function getMain()
    {
        return $this->main;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->log = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add log
     *
     * @param \CIR\Bundle\Entity\SumitomoLog $log
     * @return SumitomoSub
     */
    public function addLog(\CIR\Bundle\Entity\SumitomoLog $log)
    {
        $this->log[] = $log;

        return $this;
    }

    /**
     * Remove log
     *
     * @param \CIR\Bundle\Entity\SumitomoLog $log
     */
    public function removeLog(\CIR\Bundle\Entity\SumitomoLog $log)
    {
        $this->log->removeElement($log);
    }

    /**
     * Get log
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLog()
    {
        return $this->log;
    }
}
