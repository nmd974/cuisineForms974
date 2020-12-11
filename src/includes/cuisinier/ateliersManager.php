<?php 
  require_once(__ROOT__.'/src/class/Ateliers.php');
?>
<?php 
// if(isset($_GET['action'])){
//     $action = $_GET['action'];
//     if($action == "activer"){
//         Ateliers::activerAtelier($_GET['id']);
//     }
//     if($action == "desactiver"){
//         Ateliers::activerAtelier($_GET['id']);
//     }
// }



?>
<div class="container mt-5 pt-5">
    <h2 class="text-center align-middle font-weight-bold">Liste des ateliers</h2>
    <div class="table-responsive">
        <div class="accordion" id="idAtelier">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h2 class="mb-0 d-flex">Cuisine du monde </h2>
                    </button>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1" id="labelswitch">Désactivé</label>
                    </div>
                </div>
                <div id="collapseOne" class="collapse show" data-parent="#idAtelier">
                    <div class="card w-100 card-manager">
                        <img src="../../images/gateau1.jpeg" class="card-img img-manager" alt="cours de cuisine">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Description : </strong>Lorem, ipsum dolor sit amet
                                    consectetur adipisicing elit. In iure veritatis inventore. Libero doloremque optio
                                    incidunt molestias at velit laborum repellat inventore aperiam exercitationem
                                    similique nulla odit sapiente, nostrum cumque?</li>
                                <li class="list-group-item"><strong>Date début : </strong>10/11/2020</li>
                                <li class="list-group-item"><strong>Durée : </strong>5 h</li>
                                <li class="list-group-item"><strong>Nombre de réservations : </strong>8</li>
                                <li class="list-group-item"><strong>Nombre de places : </strong>20</li>
                                <li class="list-group-item"><strong>Prix : </strong>120 €</li>
                            </ul>
                            <div class="d-flex w-100 justify-content-between align-items-center mt-5">
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                              <a href="#" class="btn btn-primary">Modifier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
