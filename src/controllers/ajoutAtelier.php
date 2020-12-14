<?php 

  require_once(__ROOT__.'/src/controllers/imageControl.php');
  require_once(__ROOT__.'/src/controllers/accesData.php');

  function ajoutAtelier($data, $image){
    //On declare par défaut une validation du formulaire à true s'il y a un manquement ca passe en false
    $validationInputs = [true];

    //On vérifie les inputs si vide alors on passe à false sinon on transforme les données saisies en htmlentities
    $inputsRequired = ['titre', 'description','date_debut','heureDebut','minDebut','heureDuree','minutesDuree','nombre_places','prix'];
    foreach ($inputsRequired as $input) {
      if($data["$input"] == ""){
        $validationInputs[0] = false;
        array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Le formulaire est incomplet !</div>', $input);
        return $validationInputs;
        exit();
      }else{
        $data["$input"] = htmlentities($data["$input"], ENT_QUOTES);
      }
    }

    //Contrôle de la date => On recupere les morceaux et on converti en int
    if(strlen($data['date_debut']) < 10 || substr($data['date_debut'],4,1) !== "-" || substr($data['date_debut'],7,1) !== "-" ||strlen($data['date_debut']) > 10){
      $validationInputs[0] = false;
      array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Le format de la date n\'est pas correct !</div>', 'date_debut');
      return $validationInputs;
      exit();
    }else{
      $year = intval(substr($_POST['date_debut'],0,4));
      $month = intval(substr($_POST['date_debut'],6,2));
      $day = intval(substr($_POST['date_debut'],9,2));
    }


    //Ici on contrôle les valeurs des heures / minutes et durées
    $inputsRequiredHeure = ['heureDebut','heureDuree'];
    $inputsRequiredMinutes = ['minDebut','minutesDuree'];
    foreach ($inputsRequiredHeure as $input) { //On transforme en entier au cas où un malin mets du decimal ou du texte en supprimant le type number le intval retourne 0 si c'est du texte
      if(intval($data["$input"]) < 0 && intval($data["$input"]) <= 23){
        $validationInputs[0] = false;
        array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Le format de l\'heure n\'est pas respecté !</div>', $input);
        return $validationInputs;
        exit();
      }else{
        $data["$input"] = intval($data["$input"]);//On transforme en entier au cas où un malin mets du decimal ou du texte
      }
    }
    foreach ($inputsRequiredMinutes as $input) { //On transforme en entier au cas où un malin mets du decimal ou du texte en supprimant le type number le intval retourne 0 si c'est du texte
      if(intval($data["$input"]) < 0 && intval($data["$input"]) <= 59){
        $validationInputs[0] = false;
        array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Le format des minutes n\'est pas respecté !</div>', $input);
        return $validationInputs;
        exit();
      }else{
        $data["$input"] = intval($data["$input"]);//On transforme en entier au cas où un malin mets du decimal ou du texte
      }
    }

    //Apres la verification des heures et minutes on peut modifier la valeur du $_POST en secondes
    // $data['date_debut'] = mktime($data['heureDebut'], $data['minDebut'], 0, $month, $day, $year);
    //OU
    $data['date_debut'] = $day.$month.$year;
    $data['heure_debut'] = $data['heureDebut'].':'.$data['minDebut'];
    $data['duree'] = $data['heureDuree'].':'.$data['minutesDuree'];

    //Ici on contrôle les valeurs de prix et nombre de place
    $inputsRequired = ['nombre_places','prix'];
    foreach ($inputsRequired as $input) { //On transforme en entier au cas où un malin mets du decimal ou du texte en supprimant le type number le intval retourne 0 si c'est du texte
      if(intval($data["$input"]) <= 0){
        $validationInputs[0] = false;
        array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Le prix ou le nombre de places doit être supérieure à 0 !</div>', $input);
        return $validationInputs;
        exit();
      }else{
        $data["$input"] = intval($data["$input"]);//On transforme en entier au cas où un malin mets du decimal ou du texte
      }
    }

    if($validationInputs[0]){
      $validationImage = controleImage($image);
      if($validationImage[0]){
        //Si l'ajout de l'image est un succes alors on ajoute les donnees de POST dans le ateliers.json
        $dataAtelier = getAteliersData();
        if($data !== null){
          //On ajoute à $data qui est l'équivalent de $_POST car argument de la fonction les valeurs non saisies
          $data['image'] = $validationImage[1]; //Il s'agit ici du nom de l'image retourné;
          $data['proprietaire'] = $_SESSION['id']; //Il s'agit ici de l'id du cuisto connecte
          date_default_timezone_set("Indian/Reunion");//On definie la timezone à la reunion
          $data['date_ajout'] = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
          $data['etat_atelier'] = "Desactive"; //Il s'agit ici de la desactivation de l'atelier le cuisto l'active
          $data['participants'] = []; //Il s'agit ici d'un tableau vide qui va servir d'ajouter les participants qui s'inscrivent
          $data['modifie'] = false; //Il s'agit ici d'un indice à false donc creation et true si modifié';
          array_push($dataAtelier, $data);
          saveAteliersData($dataAtelier);

          //On dit que la verification est ok via la variable du début
          array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Le prix ou le nombre de places doit être supérieure à 0 !</div>');
          return $validationInputs;
        }else{
          $validationInputs[0] = false;
          array_push($validationInputs, '<div class="container alert alert-danger col-12 mb-5">Erreur lors de la sauvegarde des données !</div>');
          return $validationInputs;
        }
      }else{
        return $validationImage[1];
      }
    }
  }
?>