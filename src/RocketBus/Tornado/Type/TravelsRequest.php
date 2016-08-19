<?php
/**
 * Created by PhpStorm.
 * User: octavioalapizco2
 * Date: 8/17/16
 * Time: 3:28 PM
 */

namespace RocketBus\Tornado\Type;


class TravelsRequest
{
    private  $id_departure;
    private  $id_arrival;
    /** @var  \DateTime */
    private  $date_departure;
    private  $type_way;
    private $cid;
    private $date_return;

    /**
     * @return mixed
     */
    public function getIdDeparture()
    {
        return $this->id_departure;
    }

    /**
     * @param mixed $id_departure
     */
    public function setIdDeparture($id_departure)
    {
        $this->id_departure = $id_departure;
    }

    /**
     * @return mixed
     */
    public function getIdArrival()
    {
        return $this->id_arrival;
    }

    /**
     * @param mixed $id_arrival
     */
    public function setIdArrival($id_arrival)
    {
        $this->id_arrival = $id_arrival;
    }

    /**
     * @return \DateTime
     */
    public function getDateDeparture()
    {
        return $this->date_departure;
    }

    /**
     * @param mixed $date_departure
     */
    public function setDateDeparture($date_departure)
    {
        $this->date_departure = $date_departure;
    }

    /**
     * @return mixed
     */
    public function getTypeWay()
    {
        return $this->type_way;
    }

    /**
     * @param mixed $type_way
     */
    public function setTypeWay($type_way)
    {
        $this->type_way = $type_way;
    }

    /**
     * @return mixed
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @param mixed $cid
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    /**
     * @return mixed
     */
    public function getDateReturn()
    {
        return $this->date_return;
    }

    /**
     * @param mixed $date_return
     */
    public function setDateReturn($date_return)
    {
        $this->date_return = $date_return;
    }

}