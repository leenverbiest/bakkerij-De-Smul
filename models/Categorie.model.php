<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 12/02/2017
 * Time: 20:12
 */
require_once (ROOT.DS.'entities'.DS.'Categorie.php');

class CategorieModel extends Model {

//READ
    //haal alle categorieën uit de database
    //returnt een ARRAY VAN CATEGORIE-OBJECTEN
    public function getAll(){
        $sql="select catnr,categorie from categorie";
        $dbh=$this->db->getConnection();
        $resultSet=$dbh->query($sql);
        $lijst=array();
        foreach ($resultSet as $rij){
           $categorie=Categorie::create($rij['catnr'],$rij["categorie"]);
            array_push($lijst,$categorie);
        }
        $this->db=null;
        return $lijst; //ARRAY VAN CATEGORIE-OBJECTEN
    }
    //haal één specifiek product op
    //returnt één CATEGORIE-OBJECT
    public function getById($id){
        $sql="select catnr,categorie from categorie WHERE catnr=:id";
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $rij=$stmt->fetch(\PDO::FETCH_ASSOC);
        $categorie=Categorie::create($id,$rij['categorie']);
        $dbh=null;
        return $categorie;      //CATEGORIE-OBJECT
    }

    //CREATE
    //voeg record toe aan de tabel categorie
    public function create($catnr,$categorie)
    {
        //voegt een nieuwe categorie toe aan de database
        //returnt een object $categorie met de gegevens van de net toegevoegde categorie
        $sql = "insert into categorie (catnr,categorie)
                VALUES(:catnr,:categorie) ";
        $dbh=$this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':catnr'=>$catnr,
            ':categorie' => $categorie
        ));
        $catnr = $dbh->lastInsertId();
        $dbh = null;
        $categorie=Categorie::create($catnr,$categorie);
        return $categorie;  //RETURN OBJECT CATEGORIE
    }
    //UPDATE
    //Categorie met bepaald catnr updaten
    //@categorie=CATEGORIE-OBJECT
    public function update($categorie)
    {
        $sql = "update categorie set catnr=:catnr,categorie=:categorie where catnr=:id";

        $dbh = $this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':catnr'=>$categorie->getCatnr(),
            ':categorie' =>$categorie->getCategorie()
        ));
        $dbh = null;
    }
    //DELETE
    //Categorie met bepaald catnr verwijderen
    //returnt niets
    public function delete($id){
        $sql="delete from categorie where catnr=:id";
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $dbh=null;

    }
}