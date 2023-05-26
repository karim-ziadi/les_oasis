<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
$pageName = 'villes';

require_once '../inc/header.php';

$sql = "SELECT COUNT(*) AS total FROM villes";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
$nbVilles = (int)$result->total;
// echo $nbVilles;
$parPage = 3;
//calcule le nombre de pages totale

$pages = ceil($nbVilles / $parPage);
// echo $pages;
//calcule du 1er ville de la page
$premier = ($currentPage * $parPage) - $parPage;
$sql = 'SELECT * FROM `villes` ORDER BY `id_ville` DESC LIMIT :premier, :parPage; ';
$query = $pdo->prepare($sql);
$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parPage', $parPage, PDO::PARAM_INT);
$query->execute();
$villes = $query->fetchAll(PDO::FETCH_ASSOC);
// var_dump($villes);

?>
<div class="container2" style="margin-top: 100px;">
    <div class="row">
        <div class="col">
            <h1>Table Ville</h1>
        </div>
        <div class="col-3 ">
            <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addVi">Ajouter</button>
        </div>
        <div id="displayDataTable">
            <?php require BL . 'functions/messages.php' ?>
            <table class="table table-bordered mb-5 text-center">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Code Postal</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($villes as $key => $vill) : ?>
                        <?php
                        $id = $vill['id_ville'];
                        $num = $key + 1;
                        $nom = $vill['nom_ville'];
                        $codePostal = $vill['code_postal'];
                        ?>
                        <tr>
                            <th> <?php echo $id ?> </th>
                            <td><?php echo $nom ?> </td>
                            <td><?php echo $codePostal ?> </td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-primary m-2 voir" title="Voir detail" onclick="voirVill(<?php echo $id ?>)">
                                    <i class="bx bx-show"></i>
                                </button>
                                <button class="btn btn-success m-2 edit" onclick="detailsVill(<?php echo $id ?>)" title="Modifier"><i class="bx bx-edit"></i></button>
                                <button class="btn btn-danger m-2 " title="supprimer" onclick="deleteVill(<?php echo $id ?>)"><i class="bx bx-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- pagination -->
    <nav aria-label="Page navigation example float-rigth" id="pagination">
        <ul class="pagination justify-content-end">
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a class=" page-link " href="./?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php
            for ($page = 1; $page <= $pages; $page++) {
            ?>
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>"><a class="page-link " href="./?page=<?= $page ?>"><?php echo $page ?></a></li>
            <?php } ?>
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                <a class="page-link" href="./?page=<?= $currentPage + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>

        </ul>
    </nav>
    <!-- add modal -->
    <div class="modal fade" id="addVi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Ville</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="">Nom de Ville : </label>
                            <input class="form-control" type="text" placeholder="Nom de Ville" aria-label="default input example" id="nomV" required>
                            <br>
                            <label for="">Code Postal : </label>
                            <input class="form-control" type="text" placeholder="Code Postal" aria-label="default input example" id="cpVil" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="addVil()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editVi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Ville</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="nom_ville">Nom de Ville : </label>
                            <input class="form-control" type="text" placeholder="Nom de Ville" id="nom_ville" aria-label="default input example" required />
                            <br>
                            <label for="codePos_ville">Code Postal : </label>
                            <input class="form-control" type="text" placeholder="Code Postal" id="codePos_ville" aria-label="default input example" required />
                            <input type="hidden" name="" id="hiddenData" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="updateVill()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- detail ville -->
    <div class="modal fade" id="voirVi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Ville</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Nom Ville</h5>
                    <p class="nomVill"></p>
                    <hr>
                    <h5>Code Postal</h5>
                    <p class="codePosVille"> </p>
                </div>
                <input type="hidden" id="hiddenId" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                </div>
            </div>
        </div>
    </div>
</div>
<?php

require_once BLA . '/inc/footer.php';
?>

<script>
    //add ville
    function addVil() {
        var nom = $('#nomV').val();
        var codePostal = $('#cpVil').val();
        $.ajax({
            url: "insert.php",
            type: "post",
            data: {
                Snom: nom,
                ScodePostal: codePostal
            },
            success: function(data, status) {
                // console.log(data.Snom);
                // console.log(data.ScodePostal);
                var nom = $('#nomV').val(' ');
                var codePostal = $('#cpVil').val(' ');
                $('#addVi').modal("hide");

                location.reload();
            }
        })
        // console.log(codePostal);

    }
    //delete ville
    function deleteVill(deleteId) {
        // console.log(deletID);
        $.ajax({
            url: "delete.php",
            type: 'post',
            data: {
                deleteSend: deleteId,
            },
            success: function(data, status) {

                location.reload();

            }
        })
    }
    //get ville
    function detailsVill(updateId) {
        $('#hiddenData').val(updateId);
        $('#editVi').modal('show');
        console.log(updateId);
        $.post("update.php", {
            updateId: updateId,
        }, function(data, status) {
            var villId = JSON.parse(data);
            $('#nom_ville').val(villId.nom_ville);
            $('#codePos_ville').val(villId.code_postal);
        })
        // $('#editVi').modal("hide");
    }
    //update ville
    function updateVill() {
        var nameVille = $('#nom_ville').val();
        var codeVille = $('#codePos_ville').val();
        var hiddenData = $('#hiddenData').val();
        $.post("update.php", {
            hiddenData: hiddenData,
            nameVille: nameVille,
            codeVille: codeVille
        }, function(data, status) {
            $('#editVi').modal("hide");
            location.reload();
        })
    }
    //show ville
    function voirVill(datailsId) {
        $('#voirVi').modal('show');
        $('#hiddenId').val(datailsId);
        $.post("display.php", {
            datailsId: datailsId,
        }, function(data, status) {
            var voirVi = JSON.parse(data);
            $('.nomVill').html(voirVi.nom_ville);
            $('.codePosVille').html(voirVi.code_postal);
        })
        $('#voirVi').modal("show");
    }
</script>