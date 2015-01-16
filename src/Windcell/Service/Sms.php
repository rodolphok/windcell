<?php
namespace Windcell\Service;

use Windcell\Model\Sms as SmsModel;

use Exception;


class Sms extends Service{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->valor)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $sms= $this->getSms($data);

        $sms->setValor($data->valor);

        try {

            $this->em->persist($sms);
            $this->em->flush();
            return $sms;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getSms($data)
    {

        $sms = null;

        if ( isset($data->id) ) {
            $sms = $this->em->getRepository('Windcell\Model\Sms')->find($data->id);

        }

        if (!$sms) {
            $sms = new SmsModel();
        }

        return $sms;
    }

}