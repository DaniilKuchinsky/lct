<?php

namespace core\services\standard;

use core\entities\dictionary\Destination;
use core\entities\dictionary\Mkb10;
use core\entities\standard\StandardMoscow;
use core\repositories\dictionary\DestinationRepository;
use core\repositories\dictionary\Mkb10Repository;
use core\repositories\standard\StandardMoscowRepository;
use moonland\phpexcel\Excel;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class StandardMoscowService
{
    protected StandardMoscowRepository $rep;

    protected Mkb10Repository          $repMkb10;

    protected DestinationRepository    $repDestination;


    public function __construct(
        StandardMoscowRepository $rep,
        Mkb10Repository          $repMkb10,
        DestinationRepository    $repDestination
    ) {
        $this->rep            = $rep;
        $this->repMkb10       = $repMkb10;
        $this->repDestination = $repDestination;
    }


    /**
     * @param integer $id
     *
     * @return StandardMoscow
     */
    public function get(int $id): StandardMoscow
    {
        return $this->rep->get($id);
    }


    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    private function uploadFile(UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->extension;

        $path = "/standard";
        FileHelper::createDirectory(\Yii::getAlias("@backend") . '/web' . $path);
        $file->saveAs(\Yii::getAlias("@backend") . "/web{$path}/{$fileName}");

        return \Yii::getAlias("@backend") . "/web{$path}/{$fileName}";
    }


    /**
     * @param UploadedFile $file
     *
     */
    public function loadData(UploadedFile $file)
    {
        $this->rep->resetItems();

        $data = Excel::widget([
                                  'mode'     => 'import',
                                  'fileName' => $this->uploadFile($file),
                                  'getOnlySheet' => 'СППВР Москва'
                              ]);

        foreach ($data as $item) {

            if (strlen($item['Категория']) == 0) {
                continue;
            }

            $mkb10 = $this->repMkb10->findItem(mb_strtolower($item['МКБ-10']));
            if (!$mkb10) {
                $mkb10 = Mkb10::create(mb_strtolower($item['МКБ-10']));
                $this->repMkb10->save($mkb10);
            }

            $destination = $this->repDestination->findItem(mb_strtolower($item['Назначения']));
            if (!$destination) {
                $destination = Destination::create(mb_strtolower($item['Назначения']));
                $this->repDestination->save($destination);
            }

            $standard = StandardMoscow::create(
                $mkb10->id,
                $destination->id,
                mb_strtolower($item['Категория']),
                mb_strtolower($item['Название нозологии']),
                mb_strtolower($item['Тип назначений']),
                mb_strtolower($item['Обязательность']) == "да",
                mb_strtolower($item['Критерии исследований/консультаций'])
            );

            $this->rep->save($standard);
        }
    }
}