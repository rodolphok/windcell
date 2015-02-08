<?php
namespace Windcell\Service;


class Dashboard extends Service{

    /**
     * Function that gets the last 10 updates
     * @param                 array $data
     * @return                array $updates
     */
    public function getData($data)
    {
        $date = date('Y-m-d');
        $data = json_decode($data);

        if (!isset($data->lojaId)) {
            throw new Exception("Invalid Parameters", 1);
        }


        $limit = null;

        if(isset($data->limit)){
            $limit = $data->limit;
        }

        if (!$limit) {
            $limit = 50;
        }

        $userNotes = array();
        $query = $this->em->createQuery("SELECT u FROM Windcell\Model\Venda u ORDER BY u.created DESC");
        $userNotes = $query->getResult();

        $updates = array_merge($userNotes);


        return $updates;
    }

}