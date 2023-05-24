<?php

use core\entities\consultation\Consultation;
use core\helpers\consultation\ConsultationHelper;
use yii\bootstrap4\Html;

/**
 * @var Consultation $consultation
 */

?>

<h4 class="mb-3 fw-semibold lh-1 text-center">
    <?= ConsultationHelper::getStatusNameForUser($consultation->status) ?>
</h4>

<?php if ($consultation->status == ConsultationHelper::STATUS_ERROR): ?>
    <div class="text-center">
        <?= Html::a(
            'Загрузить файл еще раз',
            ['site/index'],
            [
                'class'          => 'btn btn-info',
                'title'          => 'Загрузить файл еще раз',
                'data-placement' => 'top',
                'data-toggle'    => 'tooltip',
            ]
        ) ?>
    </div>
<?php elseif ($consultation->status == ConsultationHelper::STATUS_SUCCESS): ?>
    <div class="text-center">
        <?= Html::a(
            'Увидеть результаты',
            ['site/finish', 'id' => $consultation->uniqueId],
            [
                'class'          => 'btn btn-success',
                'title'          => 'Увидеть результаты',
                'data-placement' => 'top',
                'data-toggle'    => 'tooltip',
            ]
        ) ?>
    </div>

<?php endif; ?>
