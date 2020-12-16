<?php
  require_once(__ROOT__.'/src/controllers/accesData.php');

function inscriptionAtelier($id)
{
    foreach($_SESSION['ateliers'] as $ateliers_inscrit){
        if($ateliers_inscrit == $id){
            return '<div class="container alert alert-danger col-12 mb-5">Vous vous êtes déjà inscrit à cet atelier :)</div>';
            exit();
        }
    }
    $dataUser = getUserData();//On recupere les donnees json
    $dataAtelier = getAteliersData(); //On recupere les données json des ateliers
    if($dataUser !== null){//S'il y a des gens inscrits alors on recherche l'id connecte
        foreach ($dataUser as $keyUser => $user) {
            if($user['id'] == $_SESSION['id']){
                foreach($dataAtelier as $keyAtelier => $atelier){//On recherche l'id auxquel l'utilisateur souhaite s'inscrire 
                    if(count($atelier['participants']) == $atelier['nombre_places']){
                        return '<div class="container alert alert-danger col-12 mb-5">L\'atelier est déjà complet</div>';
                        exit();
                    }
                    if($atelier['date_debut']-3600 >= mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))){
                        return '<div class="container alert alert-danger col-12 mb-5">Vous ne pouvez plus vous inscrire à cet atelier</div>';
                        exit();
                    }
                    if($atelier['id'] == $id){
                        array_push($dataAtelier[$keyAtelier]['participants'], $_SESSION['id']);//on rajoute dans le tableau json de l'atelier l'id du participant
                        array_push($dataUser[$keyUser]['ateliers'], $atelier['id']);//On rajoute dans le tableau ateliers de l'utilisateur l'id de l'atelier auquel il s'inscrit
                        array_push($_SESSION['ateliers'], $atelier['id']);
                        saveAteliersData($dataAtelier);
                        saveUserData($dataUser);
                    }
                }
            }
        }
    }
}

?>