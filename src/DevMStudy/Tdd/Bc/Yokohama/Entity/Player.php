<?php
namespace DevMStudy\Tdd\Bc\Yokohama\Entity;

/**
 * Class Player
 * @package DevMStudy\Tdd\Bc\Yokohama
 */
class Player
{
    /**
     * @var int 打席数
     */
    private $plateAppearances = 0;

    /**
     * @var int 安打数
     */
    private $hits = 0;

    /**
     * @var int 打数（打席数 - (四死球+犠牲フライ+犠牲バント+打撃妨害+走塁妨害)）
     */
    private $atBats = 0;

    /**
     * @var mixed 打率
     */
    private $battingAverage;

    /**
     * @param int $plateAppearances
     */
    public function setPlateAppearances($plateAppearances)
    {
        $this->plateAppearances = $plateAppearances;
    }

    /**
     * @return int
     */
    public function getPlateAppearances()
    {
        return $this->plateAppearances;
    }

    /**
     * @param int $hits
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    }

    /**
     * @return int
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @param int $atBats
     */
    public function setAtBats($atBats)
    {
        $this->atBats = $atBats;
    }

    /**
     * @return int
     */
    public function getAtBats()
    {
        return $this->atBats;
    }

    /**
     * @param mixed $battingAverage
     */
    public function setBattingAverage($battingAverage)
    {
        $this->battingAverage = $battingAverage;
    }

    /**
     * @return mixed
     */
    public function getBattingAverage()
    {
        return $this->battingAverage;
    }
}