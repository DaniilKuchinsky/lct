<?php

namespace backend\forms\standard;

use yii\base\Model;

class StandardFileForm extends Model
{
    public $fileName = null;


    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'fileName' => 'Выберите excel файл',
        ];
    }


    public function rules(): array
    {
        return [
            [
                'fileName',
                'required',
                'skipOnEmpty' => true,
            ],
            ['fileName', 'safe'],
        ];
    }
}