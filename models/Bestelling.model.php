<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 15/02/2017
 * Time: 10:36
 */
require_once (ROOT.DS.'entities'.DS.'Bestelling.php');

class BestellingModel extends Model{
    //READ
    //haal alle bestellingen uit de database
    //returnt een ARRAY VAN Bestel-OBJECTEN
    public function getAll(){
        $sql="select bestelnr,klantnr,besteldatum,bestel_aantal,afhaaldatum,status from bestellingen";
        $dbh=$this->db->getConnection();
        $resultSet=$dbh->query($sql);
        $lijst=array();
        foreach ($resultSet as $rij){
            $bestelling=Bestelling::create($rij['bestelnr'],$rij['klantnr'],$rij['besteldatum'],$rij['bestel_aantal'],
                        $rij['afhaaldatum'],$rij['status']);
            array_push($lijst,$bestelling);
        }
        $this->db=null;
        return $lijst; //ARRAY VAN BESTEL-OBJECTEN
    }
    //haal één specifieke bestelling op
    //returnt één BESTEL-OBJECT
    public function getById($id)
    {
        $sql = "select klantnr,besteldatum,bestel_aantal,afhaaldatum,status from bestellingen WHERE bestelnr=:id";
        $dbh = $this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $rij = $stmt->fetch(\PDO::FETCH_ASSOC);
        $bestelling = Bestelling::create($id,$rij['klantnr'], $rij['besteldatum'], $rij['bestel_aantal'],
            $rij['afhaaldatum'], $rij['status']);
        $dbh=null;
        return $bestelling;      //EESTEL-OBJECT
    }

    //CREATE
    //voeg record toe aan de tabel bestelling
    public function create($klantnr,$besteldatum,$bestel_aantal,$afhaaldatum,$status)
    {
        //voegt een nieuwe bestelling toe aan de database
        //returnt een object $bestelling met de gegevens van de net toegevoegde bestelling
        $sql = "insert into bestellingen(klantnr,besteldatum,bestel_aantal,afhaaldatum,status)
                VALUES(:klantnr,:besteldatum,:aantal,:afhaaldatum,:status) ";
        $dbh=$this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':klantnr' => $klantnr,
            ':besteldatum' => $besteldatum,
            ':aantal' => $bestel_aantal,
            ':afhaaldatum' => $afhaaldatum,
            ':status'=>$status
        ));
        $bestelnr= $dbh->lastInsertId();
        $dbh = null;
        $bestelling=Bestelling::create($klantnr,$besteldatum,$bestel_aantal,$afhaaldatum,$status);
        return $bestelling;  //RETURN OBJECT BESTELLING
    }

    //UPDATE
    //Bestelling met bepaald bestelnr updaten
    //returnt niets
    public function update($bestelnr,$klantnr,$besteldatum,$bestel_aantal,$afhaaldatum,$status)
    {
        $sql = "update bestellingen set klantnr=:klantnr,besteldatum=:besteldatum,bestel_aantal=:aantal,
                afhaaldatum=:afhaaldatum,status=:status
                where bestelnr=:id";
        $dbh=$this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':klantnr' => $klantnr,
            ':besteldatum' => $besteldatum,
            ':aantal' => $bestel_aantal,
            ':afhaaldatum' => $afhaaldatum,
            ':status'=>$status,
            ':id' => $bestelnr
        ));
        $dbh = null;
    }
    //DELETE
    //Bestelling met bepaald bestelnr verwijderen
    //returnt niets
    public function delete($id){
        $sql="delete from bestellingen where bestelnr=:id";
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $dbh=null;

    }
}