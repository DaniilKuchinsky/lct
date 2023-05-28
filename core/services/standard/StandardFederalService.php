<?php

namespace core\services\standard;

use core\entities\dictionary\Destination;
use core\entities\dictionary\Mkb10;
use core\entities\standard\StandardFederal;
use core\repositories\dictionary\DestinationRepository;
use core\repositories\dictionary\Mkb10Repository;
use core\repositories\standard\StandardFederalRepository;
use moonland\phpexcel\Excel;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class StandardFederalService
{
    protected StandardFederalRepository $rep;

    protected Mkb10Repository          $repMkb10;

    protected DestinationRepository    $repDestination;


    public function __construct(
        StandardFederalRepository $rep,
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
     * @return StandardFederal
     */
    public function get(int $id): StandardFederal
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
                                  'getOnlySheet' => 'Федеральный стандарт'
                              ]);

        foreach ($data as $item) {

            if (strlen($item['Код МКБ-10']) == 0) {
                continue;
            }

            $mkb10 = $this->repMkb10->findItem(mb_strtolower($item['Код МКБ-10']));
            if (!$mkb10) {
                $mkb10 = Mkb10::create(mb_strtolower($item['Код МКБ-10']));
                $this->repMkb10->save($mkb10);
            }

            $destination = $this->repDestination->findItem(mb_strtolower($item['Назначение']));
            if (!$destination) {
                $destination = Destination::create(mb_strtolower($item['Назначение']));
                $this->repDestination->save($destination);
            }

            $standard = StandardFederal::create(
                $mkb10->id,
                $destination->id,
                mb_strtolower($item['Код медицинской услуги']),
                mb_strtolower($item['Усредненный показатель
кратности применения']),
                mb_strtolower($item['Обязательность']) == "1"
            );

            $this->rep->save($standard);
        }
    }
}