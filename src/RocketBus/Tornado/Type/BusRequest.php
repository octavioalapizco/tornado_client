<?php
namespace RocketBus\Tornado\Type;

class BusRequest
{
    private $id_departure;
    private $id_arrival;
    private $type_way;
    private $cid;
    private $travelId;

    /**
     * @return mixed
     */
    public function getTravelId()
    {
        return $this->travelId;
    }

    /**
     * @param mixed $travelId
     */
    public function setTravelId($travelId)
    {
        $this->travelId = $travelId;
    }

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

}