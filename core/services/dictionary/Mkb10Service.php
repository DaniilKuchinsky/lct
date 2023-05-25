<?php

namespace core\services\dictionary;

use core\entities\dictionary\Mkb10;
use core\repositories\dictionary\Mkb10Repository;

class Mkb10Service
{
    protected Mkb10Repository $rep;


    public function __construct(Mkb10Repository $rep)
    {
        $this->rep = $rep;
    }


    /**
     * @param integer $id
     *
     * @return Mkb10
     */
    public function get(int $id): Mkb10
    {
        return $this->rep->get($id);
    }


    /**
     * @param string $name
     *
     * @return Mkb10
     */
    public function create(string $name): Mkb10
    {
        $item = $this->rep->findItem($name);

        if ($item == null) {
            $item = Mkb10::create($name);
            $this->rep->save($item);
        }

        return $item;
    }


    /**
     * @param string $name
     *
     * @return Mkb10
     */
    public function findItem(string $name): ?Mkb10
    {
        return $this->rep->findItem($name);
    }

}