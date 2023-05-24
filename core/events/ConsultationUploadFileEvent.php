<?php

namespace core\events;

use core\entities\consultation\Consultation;

class ConsultationUploadFileEvent
{
    public int $id;


    public function __construct(Consultation $item)
    {
        $this->id = $item->id;
    }
}