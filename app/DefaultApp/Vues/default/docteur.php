<?php
$role=\systeme\Model\Utilisateur::role();
$d=new \app\DefaultApp\Models\PersonelMedical();
if(isset($_GET['del'])){
    $id=$_GET['del'];
    $d->deleteById($id);
}

$liste=$d->findAll();
?>

<div class="form-head d-flex mb-3  mb-lg-5   align-items-start flex-wrap">
    <a href="javascript:void(0);" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-1">+ New
        Doctor</a>
    <form class="ms-auto default-search">
        <div class="input-group search-area d-inline-flex">
            <input type="text" class="form-control" placeholder="Search here">
            <span class="input-group-text"><button class="bg-transparent border-0"><i class="flaticon-381-search-2"></i></button></span>
        </div>
    </form>
    <div class="dropdown ms-3 d-inline-block">
        <div class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="flaticon-381-controls-3 me-2"></i> Filter
        </div>
        <div class="dropdown-menu dropdown-menu-left">
            <a class="dropdown-item" href="javascript:void(0);">A To Z List</a>
            <a class="dropdown-item" href="javascript:void(0);">Z To A List</a>
        </div>
    </div>
    <select class="default-select ms-3 style-1" aria-label="Default select example">
        <option selected>Newest</option>
        <option value="2">Old</option>
    </select>
    <a href="javascript:void(0);" class="btn btn-outline-primary ms-3"><i class="flaticon-381-menu-1 me-0"></i></a>
    <a href="javascript:void(0);" class="btn btn-light ms-3"><i class="flaticon-381-pad me-0"></i></a>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="accordion-one" class="accordion doctor-list">

            <div class="accordion__item">
                <div class="accordion__header collapsed rounded-lg" id="headingThree" data-bs-toggle="collapse"
                     data-bs-target="#collapseThree" aria-controls="collapseThree" role="button" aria-expanded="true">
                    <span class="accordion__header-alphabet">TOUS</span>
                    <span class="accordion__header-line flex-grow-1"></span>
                    <span class="accordion__header--text"><?= count($liste) ?> Doctors</span>
                    <span class="accordion__header--indicator style_two"></span>
                </div>
                <div id="collapseThree" class="collapse  show" aria-labelledby="headingThree"
                     data-bs-parent="#accordion-one">
                    <div class="accordion-body-text px-0">
                        <div class="widget-media best-doctor pt-4">
                            <div class="timeline row">
                                <?php
                                foreach ($liste as $d){
                                    ?>
                                    <div class="col-lg-6">
                                        <div class="timeline-panel bg-white p-4 mb-4 d-flex align-items-center justify-content-between flex-wrap">
                                            <div class="d-flex">
                                                <div class="media me-4">
                                                    <img alt="image" width="90" src="assets/images/avatar/1.jpg">
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="mb-2"><?= strtoupper($d->nom)." ".ucfirst($d->prenom) ?></h4>
                                                    <p class="mb-2 text-primary"><?= $d->type ?></p>
                                                    <div class="star-review" style="display: none">
                                                        <i class="fa fa-star text-orange"></i>
                                                        <i class="fa fa-star text-orange"></i>
                                                        <i class="fa fa-star text-orange"></i>
                                                        <i class="fa fa-star text-gray"></i>
                                                        <i class="fa fa-star text-gray"></i>
                                                        <span class="ms-3">451 reviews</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="social-media">
                                                <?php
                                                if($role=="admin"){
                                                    ?>
                                                    <a data-bs-toggle="modal" data-bs-target="#mx-<?= $d->id ?>" href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="medecin?del=<?= $d->id ?>" class="btn btn-outline-danger btn-rounded btn-sm"><i class="fa fa-remove"></i></a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="mx-<?= $d->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel-1">Update Doctor</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="message"></div>
                                                <form method="post" class="form_add_docteur">
                                                    <input type="hidden" name="update_docteur">
                                                    <input type="hidden" name="id" value="<?= $d->id ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput6" class="form-label">Type</label>
                                                                    <select class="form-control" name="type">
                                                                        <option value="<?= $d->type ?>"><?= ucfirst($d->type) ?></option>
                                                                        <option value="médecin">Médecin</option>
                                                                        <option value="médecin radiologue">Médecin radiologue</option>
                                                                        <option value="médecin externe">Médecin externe</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-12">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput6" class="form-label">Specialiter</label>
                                                                    <input value="<?= $d->specialiter ?>" required name="specialiter" type="text" class="form-control" id="exampleFormControlInput6" placeholder="Nom">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput6" class="form-label">Nom</label>
                                                                    <input value="<?= $d->nom ?>" required name="nom" type="text" class="form-control" id="exampleFormControlInput6" placeholder="Nom">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput6" class="form-label">Prénom</label>
                                                                    <input value="<?= $d->prenom ?>" required name="prenom" type="text" class="form-control" id="exampleFormControlInput6" placeholder="Prnom">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput7" class="form-label">Téléphone</label>
                                                                    <input value="<?= $d->telephone ?>" required name="telephone" type="number" class="form-control" id="exampleFormControlInput7" placeholder="+9123654789">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput8" class="form-label">Email address</label>
                                                                    <input readonly value="<?= $d->email ?>" name="email" type="email" class="form-control" id="exampleFormControlInput8" placeholder="name@example.com">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-12">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput8" class="form-label">Password</label>
                                                                    <input value="xxxx" name="password" type="password" class="form-control" id="exampleFormControlInput8" placeholder="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal-1" tabindex="-1" aria-labelledby="exampleModalLabel-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel-1">Add Doctor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="message"></div>
            <form method="post" class="form_add_docteur">
                <input type="hidden" name="add_docteur">
            <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput6" class="form-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="médecin">Médecin</option>
                                    <option value="médecin radiologue">Médecin radiologue</option>
                                    <option value="médecin externe">Médecin externe</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput6" class="form-label">Specialiter</label>
                                <input required name="specialiter" type="text" class="form-control" id="exampleFormControlInput6" placeholder="Nom">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput6" class="form-label">Nom</label>
                                <input required name="nom" type="text" class="form-control" id="exampleFormControlInput6" placeholder="Nom">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput6" class="form-label">Prénom</label>
                                <input required name="prenom" type="text" class="form-control" id="exampleFormControlInput6" placeholder="Prnom">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput7" class="form-label">Téléphone</label>
                                <input required name="telephone" type="number" class="form-control" id="exampleFormControlInput7" placeholder="+9123654789">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput8" class="form-label">Email address</label>
                                <input name="email" type="email" class="form-control" id="exampleFormControlInput8" placeholder="name@example.com">
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
