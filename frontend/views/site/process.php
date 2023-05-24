<?php

use core\entities\consultation\Consultation;
use frontend\assets\ConsultationStatusAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View         $this
 * @var Consultation $consultation
 */

$this->title = 'Обработка файла';

ConsultationStatusAsset::register($this);
?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title"><?= $this->title ?></h3>
    </div>

    <div class="card-body" id="div-status"
         data-action="<?= Url::to(['status', 'id' => $consultation->uniqueId]) ?>"
         data-success="<?= Url::to(['finish', 'id' => $consultation->uniqueId]) ?>">

    </div>

</div>
