<?php


function dateFinDetachement($matricule){

    require 'connect.php';

    $req = $conn->prepare("SELECT `dat_det_fin` FROM `psalm23_angifode_angifode_agent` WHERE matricule = ?");
    $req->execute([$matricule]);
    $row = $req->fetch();

    return $row;
}

function getEmployeeDetails($employeeMle){

    require 'connect.php';

    $req = $conn->prepare("SELECT * FROM psalm23_antilope_agent, psalm23_angifode_angifode_agent WHERE psalm23_antilope_agent.matricule = psalm23_angifode_angifode_agent.matricule AND psalm23_antilope_agent.matricule = ?");       
    $req->execute([$employeeMle]);
    $rows = $req->fetch();

    return $rows;
}

function getEmployeeOrgDetails($employeeMle){

    require 'connect.php';

    $req = $conn->prepare("SELECT * FROM psalm23_angifode_angifode_agent, psalm23_angifode_angifode_organisme WHERE psalm23_angifode_angifode_agent.id_org = psalm23_angifode_angifode_organisme.id AND psalm23_angifode_angifode_agent.matricule = ?");
    
    $req->execute([$employeeMle]);
    $rows = $req->fetch();

    return $rows;
}

function getAllStructureEmployee($idstructure) {
    require 'connect.php';

    $req = $conn->prepare("SELECT * FROM psalm23_angifode_angifode_agent, psalm23_antilope_agent WHERE psalm23_antilope_agent.matricule = psalm23_angifode_angifode_agent.matricule AND id_org = ?");
    $req->execute([$idstructure]);
    $data= $req->fetchAll();

    return $data;
}


function getStructureDetails($id_org) {
    require 'connect.php';

    $req = $conn->prepare("SELECT * FROM psalm23_angifode_angifode_organisme WHERE id = ?");
    $req->execute([$id_org]);
    $row= $req->fetch();

    return $row;
}

function getStructures() {
    require 'connect.php';

    $req = $conn->prepare("SELECT * FROM psalm23_angifode_angifode_organisme");
    $req->execute();
    $data= $req->fetchAll();

    return $data;
}

function getStructureReversements($id_org){
    require 'connect.php';

    $req = $conn->prepare("SELECT SUM(mon_tip) AS total FROM psalm23_angifode_angifode_reversement WHERE id_org = ?");
    $req->execute([$id_org]);
    $row = $req->fetch();

    return $row;
}

function getStructureEmployeeCotisations($id_org){
    require 'connect.php';

    $req = $conn->prepare("SELECT SUM(cot_tot) AS cot_tot FROM psalm23_angifode_angifode_cotisations INNER JOIN psalm23_angifode_angifode_reversement ON psalm23_angifode_angifode_cotisations.id_ref_tip = psalm23_angifode_angifode_reversement.id WHERE psalm23_angifode_angifode_reversement.id_org = ?");
    $req->execute([$id_org]);
    $row = $req->fetch();
    
    return $row;
}

function numeroBareme($date_deb,$date_fin,$indice){
  
    require 'connect.php';

    $req = $conn->prepare("SELECT  DISTINCT(psalm23_antilope_baremes.num_bar ) , bru_sol,dat_deb,dat_fin FROM baremes,psalm23_antilope_baremes_type
    WHERE ((psalm23_antilope_baremes_type.dat_deb <= ?) AND (psalm23_antilope_baremes_type.dat_fin >= ?)
     AND (psalm23_antilope_baremes_type.num_bar = psalm23_antilope_baremes.num_bar) AND (ind_sol = ?)) ORDER BY dat_deb");
    
    $req->execute([$date_deb,$date_fin,$indice]);
    $rows = $req->fetch();

    return $rows;
}

function indiceSuivant($cat, $ind){

    require 'connect.php';

    $req = $conn->prepare("SELECT MIN(INDICE) AS ind_sol FROM `psalm23_angifode_bareme` WHERE CATEGORIE = ? AND  `INDICE` > ?");
    
    $req->execute([$cat, $ind]);
    $rows = $req->fetch();

    return $rows;

}

function indiceSuivantMagis($ind,$mat,$grad){

    require 'connect.php';

    $req = $conn->prepare("SELECT indice AS ind_sol FROM `psalm23_angifode_angifode_avancement` WHERE matricule = ? AND grade_code = ? AND indice > ?");
    
    $req->execute([$mat,$grad,$ind]);
    $rows = $req->fetch();

    return $rows;

}

function echelonSuivant($echl, $cat){

    require 'connect.php';

    $req = $conn->prepare("SELECT MIN(`ECHELON`) AS echelon FROM `psalm23_angifode_bareme_con` WHERE `ECHELON` > ? AND `CATEGORIE` = ?");
    
    $req->execute([$echl, $cat]);
    $rows = $req->fetch();

    return $rows;

}

function getNewStartDateMagis($mat,$grad){

    require 'connect.php';

    $req = $conn->prepare("SELECT date_effet FROM `psalm23_angifode_angifode_avancement` WHERE matricule = ? AND grade_code = ?");
    
    $req->execute([$mat,$grad]);
    $rows = $req->fetch();

    return $rows;

}

function salaireBase($num_bar, $cat, $ind){

    require 'connect.php';

    $req = $conn->prepare("SELECT MIN(`salaire_base`) AS salaire_base FROM `psalm23_angifode_bareme` WHERE `num_bar`= ? AND `CATEGORIE`= ? AND `INDICE`= ?");
    
    $req->execute([$num_bar, $cat, $ind]);
    $data = $req->fetchall();

    return $data;
}

function salaireBaseContractuel($num_bar, $echl, $cat, $grade){

    require 'connect.php';

    $req = $conn->prepare("SELECT MIN(`salaire_base`) AS salaire_base FROM `psalm23_angifode_bareme_con` WHERE `num_bar`= ? AND  `CATEGORIE`= ? AND ECHELON = ? AND CODE_GRADE = ?");
    
    $req->execute([$num_bar, $cat, $echl, $grade]);
    $data = $req->fetchall();

    return $data;
}

function salaireBaseMagis($ind,$num_bar,$grad){

    require 'connect.php';

    $req = $conn->prepare("SELECT MIN(`salaire_base`) AS salaire_base FROM `psalm23_angifode_bareme_magis` WHERE `num_bar`= ? AND CODE_GRADE = ? AND INDICE = ?");
    
    $req->execute([$num_bar, $grad, $ind]);
    $data = $req->fetchall();

    return $data;
}

//--------------------------------------------------------------------------------
 
function  etatSommesDuesPeriodeBaremeAvancement($ind, $cat, $num_bar){

    require 'connect.php';

    $req = $conn->prepare("SELECT `CLASSE`, `ECHELON`, `INDICE`, `CATEGORIE` FROM `psalm23_angifode_bareme` WHERE INDICE = ? AND CATEGORIE = ? AND `num_bar` = ?");
    
    $req->execute([$ind, $cat, $num_bar]);
    $data = $req->fetchall();

    return $data;

}

function  etatSommesDuesPeriodeBaremeAvancementCon($grad, $cat){

    require 'connect.php';

    $req = $conn->prepare("SELECT `CODE_GRADE`FROM `psalm23_angifode_bareme_con` WHERE `CODE_GRADE` > ? AND `CATEGORIE` = ?");
    
    $req->execute([$grad, $cat]);
    $data = $req->fetchall();

    return $data;

}

function  etatSommesDuesPeriodeBaremeAvancementMagis($grad, $cat){

    require 'connect.php';

    $req = $conn->prepare("SELECT `CODE_GRADE`FROM `psalm23_angifode_bareme_magis` WHERE `CODE_GRADE` > ? AND `CATEGORIE` = ?");
    
    $req->execute([$grad, $cat]);
    $data = $req->fetchall();

    return $data;

}

function etatSommesDuesPeriodeBaremeAvancement2($matricule, $date_debut, $date_fin){

    require 'connect.php';

    $req = $conn->prepare("SELECT SUM( `cot_tot` ) AS cot_tot FROM `psalm23_angifode_angifode_cotisations` WHERE `matricule` = ? AND `dat_deb_cot` >= ? AND `dat_deb_cot` < ?");
    
    $req->execute([$matricule, $date_debut, $date_fin]);
    $data = $req->fetchall();

    return $data;

}

function etatSommesDuesPeriode($date_fin,$date_debut){

    require 'connect.php';

    $req = $conn->prepare("SELECT num_bar, dat_deb, dat_fin FROM psalm23_angifode_baremes_type WHERE dat_deb <= ? AND dat_fin >= ? ORDER BY dat_deb");
    
    $req->execute([$date_fin,$date_debut]);
    $data = $req->fetchall();

    return $data;

}

//--------------------------------------------------------------------------------
function etat_cotisations($matricule, $date_fin){

    require 'connect.php';

    $req = $conn->prepare("SELECT `dat_deb_cot`, `dat_fin_cot`, `cot_tot`,`cot_ind` FROM `psalm23_angifode_angifode_cotisations` WHERE `matricule` = ? AND `dat_fin_cot` > ?");
    
    $req->execute([$matricule, $date_fin]);
    $data = $req->fetchall();

    return $data;
}

function getStructureCotisations($id){

    require 'connect.php';

    $req = $conn->prepare("SELECT SUM(cot_tot) AS cot_tot FROM psalm23_angifode_angifode_organisme INNER JOIN psalm23_angifode_angifode_reversement ON psalm23_angifode_angifode_organisme.id = psalm23_angifode_angifode_reversement.id_org INNER JOIN psalm23_angifode_angifode_cotisations ON psalm23_angifode_angifode_reversement.id = psalm23_angifode_angifode_cotisations.id_ref_tip INNER JOIN psalm23_angifode_angifode_agent ON psalm23_angifode_angifode_cotisations.matricule = psalm23_angifode_angifode_agent.matricule WHERE psalm23_angifode_angifode_organisme.id = ?");
    
    $req->execute([$id]);
    $data = $req->fetchall();

    return $data;
}

function totalCotisation($matricule){

    require 'connect.php';

    $req = $conn->prepare("SELECT  `matricule`, `cot_sal`, `cot_pat`, `cot_tot`, `cot_ind`, `cot_sib`,`dat_deb_cot`, `dat_fin_cot`, `ref_tip` FROM `psalm23_angifode_angifode_cotisations` WHERE (matricule LIKE ?) ORDER BY dat_deb_cot");
    
    $req->execute([$matricule]);
    $data = $req->fetchall();

    return $data;

}

function totalReversement($matricule){

    require 'connect.php';

    $req = $conn->prepare("SELECT  `matricule`, `cot_sal`, `cot_pat`, `cot_tot`, `cot_ind`, `cot_sib`,`dat_deb_cot`, `dat_fin_cot`, `ref_tip` FROM `psalm23_angifode_angifode_cotisations` WHERE (matricule LIKE ?) ORDER BY dat_deb_cot");
    
    $req->execute([$matricule]);
    $data = $req->fetchall();

    return $data;
}

function getEmployeeReversements($employeeMle) {
    require 'connect.php';

    $req = $conn->prepare("SELECT * FROM psalm23_angifode_angifode_agent,psalm23_angifode_angifode_cotisations, psalm23_angifode_angifode_reversement, psalm23_antilope_baremes WHERE psalm23_angifode_angifode_agent.matricule = psalm23_angifode_angifode_cotisations.matricule AND psalm23_angifode_angifode_reversement.id_org = psalm23_angifode_angifode_agent.id_org AND dat_deb_tip = dat_deb_cot AND dat_fin_tip = dat_fin_cot AND psalm23_angifode_angifode_agent.cat_int = psalm23_antilope_baremes.cat_sol AND psalm23_angifode_angifode_cotisations.matricule = ? GROUP BY(psalm23_angifode_angifode_reversement.id) ORDER BY dat_deb_tip DESC");

    $req->execute([$employeeMle]);

    $data = $req->fetchAll();

    return $data;
}

function enteteEsd($matricule){

    require 'connect.php';

    $req = $conn->prepare("SELECT psalm23_angifode_angifode_agent.matricule matricule, `nom` , `prenoms`,sgl_org, dat_pri_ser, dat_eff_det,date_naissance,gra_int,ech_int,ind_int, cat_int, cor_int,dat_int FROM `psalm23_angifode_angifode_agent` WHERE (psalm23_angifode_angifode_agent.matricule=psalm23_antilope_agent.matricule) AND (psalm23_angifode_angifode_agent.matricule = ?)");
    
    $req->execute([$matricule]);
    $rows = $req->fetch();

    return $rows;
}

function getCategorie($grade, $classe, $echelon){

    require 'connect.php';

    $req = $conn->prepare("SELECT DISTINCT `CATEGORIE` FROM `psalm23_angifode_bareme` WHERE `CODE_GRADE` = ? AND `CLASSE` = ? AND `ECHELON` = ?");

    $req->execute([$grade, $classe, $echelon]);
    $row = $req->fetch();

    return $row;
}

function getCategorieCon($grade, $echelon){

    require 'connect.php';

    $req = $conn->prepare("SELECT DISTINCT CATEGORIE FROM psalm23_angifode_bareme_con WHERE CODE_GRADE = ? AND `ECHELON` = ?");

    $req->execute([$grade, $echelon]);
    $row = $req->fetch();

    return $row;
}

function getIndice($grade, $classe, $echelon){

    require 'connect.php';

    $req = $conn->prepare("SELECT DISTINCT `INDICE` FROM `psalm23_angifode_bareme` WHERE `CODE_GRADE` = ? AND `CLASSE` = ? AND `ECHELON` = ?");

    $req->execute([$grade, $classe, $echelon]);
    $row = $req->fetch();

    return $row;

}
