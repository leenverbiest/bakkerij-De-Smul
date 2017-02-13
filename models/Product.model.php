<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 12/02/2017
 * Time: 20:12
 */
require_once (ROOT.DS.'entities'.DS.'Product.php');

class ProductModel extends Model {

//READ
    //haal alle producten uit de database
    //returnt een ARRAY VAN PRODUCT-OBJECTEN
    public function getAll(){
        $sql="select productnr,catnr,product_naam,eenheidsprijs from producten";
        $dbh=$this->db->getConnection();
        $resultSet=$dbh->query($sql);
        $lijst=array();
        foreach ($resultSet as $rij){
           $product=Product::create($rij["productnr"],$rij['catnr'],$rij['product_naam'],$rij['eenheidsprijs']);
            array_push($lijst,$product);
        }
        $this->db=null;
        return $lijst; //ARRAY VAN PRODUCT-OBJECTEN
    }
    //haal één specifiek product op
    //returnt één product-OBJECT
    public function getById($id){
        $sql="select productnr,catnr,product_naam,eenheidsprijs from producten WHERE productnr=:id";
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $rij=$stmt->fetch(\PDO::FETCH_ASSOC);

        $product=Product::create($rij['productnr'],$rij['catnr'],$rij['product_naam'],$rij['eenheidsprijs']);
        $dbh=null;
        return $product;      //PRODUCT-OBJECT
    }
    public function getCatnrById($id){
        $sql="select catnr from producten WHERE productnr=:id";
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $result=$stmt->fetch(\PDO::FETCH_ASSOC);
        $catnr=$result;
        $dbh=null;
        return $catnr;      // RETURNT INTEGER
    }
    public function getCategorie($productnr){
        //returnt een array van categorieën met als key het productnr
        $sql='SELECT categorie from categorie WHERE catnr=:catnr';
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':catnr'=>self::getCatnrById($productnr)));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result; //returnt STRING (categorienaam)
    }

    //CREATE
    //voeg record toe aan de tabel producten
    public function create($catnr,$naam,$eenheidsprijs)
    {
        //voegt een nieuw product toe aan de database
        //returnt een object $product met de gegevens van het net toegevoegde product
        $sql = "insert into producten (catnr,product_naam,eenheidsprijs)
                VALUES(:catnr,:naam,:eenheidsprijs) ";
        $dbh=$this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':catnr'=>$catnr,
            ':naam' => $naam,
            ':eenheidsprijs' => $eenheidsprijs
        ));
        $productnr = $dbh->lastInsertId();
        $dbh = null;
        $product=Product::create($productnr,$catnr,$naam,$eenheidsprijs);
        return $product;  //RETURN OBJECT PRODUCT
    }
    //UPDATE
    //Product met bepaald productnr updaten
    public function update($product)
    {
        $sql = "update producten set catnr=:catnr,product_naam=:naam,eenheidsprijs=:prijs where productnr=:id";

        $dbh = $this->db->getConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':catnr'=>$product->getCatnr(),
            ':naam' =>$product->getProductnaam(),
            ':prijs' => $product->getEenheidsprijs()
        ));
        $dbh = null;
    }
    //DELETE
    //Product met bepaald productnr verwijderen
    //returnt niets
    public function delete($id){
        $sql="delete from producten where productnr=:id";
        $dbh=$this->db->getConnection();
        $stmt=$dbh->prepare($sql);
        $stmt->execute(array(':id'=>$id));
        $dbh=null;

    }
}