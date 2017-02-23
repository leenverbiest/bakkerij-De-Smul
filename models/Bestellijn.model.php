<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 20/02/2017
 * Time: 8:44
 */
require_once (ROOT.DS.'entities'.DS.'Bestellijn.php');

class BestellijnModel extends Model
{
    //READ
    //haal alle records uit 1 bestelling uit de database
    //returnt een ARRAY VAN Bestellijn-OBJECTEN
    public function getAll()
    {
        $sql = "select bestelnr,productnr,bestel_aantal from bestellijn";
        $dbh = $this->db->getConnection();
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach ($resultSet as $rij) {
            $bestellijn = Bestellijn::create($rij['bestelnr'], $rij['productnr'], $rij['bestel_aantal']);
            array_push($lijst, $bestellijn);
        }
        $this->db = null;
        return $lijst; //ARRAY VAN BESTELLIJN-OBJECTEN
    }
    //haal één specifieke bestellijn van een specifieke bestelling op
    //returnt één BESTEL-OBJECT
    public function getById($bestelnr, $productnr)
    {
        $sql = "select bestel_aantal from bestellijn WHERE bestelnr=:bestelnr and productnr=:productnr";
        $dbh = $this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':bestelnr' => $bestelnr, ':productnr' => $productnr));
        $rij = $stmt->fetch(\PDO::FETCH_ASSOC);
        $bestellijn = Bestellijn::create($bestelnr,$productnr, $rij['bestel_aantal']);
        $dbh = null;
        return $bestellijn;      //EESTELLIJN-OBJECT
    }

    //CREATE
    //voeg record toe aan de tabel bestellijn
    public function create($bestelnr, $productnr, $bestel_aantal)
    {
        //voegt een nieuwe bestellijn toe aan een specifieke bestelling
        //returnt een object $bestellijn met de gegevens van de net toegevoegde bestellijn
        $sql = "insert into bestellijn(bestelnr,productnr,bestel_aantal)
                VALUES(:bestelnr,:productnr,:aantal) ";
        $dbh = $this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':bestelnr' => $bestelnr,
            ':productnr' => $productnr,
            ':aantal' => $bestel_aantal
        ));
        $dbh = null;
        $bestellijn = Bestellijn::create($bestelnr, $productnr, $bestel_aantal);
        return $bestellijn;  //RETURN OBJECT BESTELLIJN
    }

    //UPDATE
    //Bestellijn van een bepaalde bestelling met een bepaald lijnnr updaten
    //returnt niets
    public function update($bestelnr,$productnr, $bestel_aantal)
    {
        $dbh = $this->db->getConnection();
        $sql = "update bestellijn set bestel_aantal=:aantal
                where bestelnr=:bestelnr AND productnr=:productnr";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':productnr' => $productnr,
            ':aantal' => $bestel_aantal,
            ':bestelnr' => $bestelnr
        ));
        $dbh = null;
    }
    //DELETE
    //Bestellijn van bepaalde bestelling met bepaald bestelnr verwijderen
    //returnt niets
    public function delete($bestelnr, $productnr)
    {
        $sql = "delete from bestellingen where bestelnr=:bestelnr and productnr=:productnr";
        $dbh = $this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':bestelnr' => $bestelnr, ':productnr' => $productnr));
        $dbh = null;

    }

}
