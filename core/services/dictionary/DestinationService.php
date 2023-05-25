<?php

namespace core\services\dictionary;

use core\entities\dictionary\Destination;
use core\repositories\dictionary\DestinationRepository;

class DestinationService
{
    protected DestinationRepository $rep;


    public function __construct(DestinationRepository $rep)
    {
        $this->rep = $rep;
    }


    /**
     * @param integer $id
     *
     * @return Destination
     */
    public function get(int $id): Destination
    {
        return $this->rep->get($id);
    }


    /**
     * @param string $name
     *
     * @return Destination
     */
    public function create(string $name): Destination
    {
        $item = $this->rep->findItem($name);

        if ($item == null) {
            $item = Destination::create($name);
            $this->rep->save($item);
        }

        return $item;
    }


    /**
     * @param string $name
     *
     * @return Destination
     */
    public function findItem(string $name): ?Destination
    {
        return $this->rep->findItem($name);
    }
}