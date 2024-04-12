
 <?php require_once "../base.php";
    require_once BASE_PROJET . '/src/_partials/menu.php';
    ?>
    <nav class="navbar navbar-expand-lg bg-dark shadow  navbar-expand-md"  >
        <div class="container-fluid  ">
            <a class="navbar-brand text-white "  href="<?php BASE_PROJET?>/index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-film"
                     viewBox="0 0 16 16">
                    <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zM1 7v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z"/>
                </svg>
                BestMovie</a>

            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse  " id="navbarText">
                <ul class="navbar-nav  mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="<?php BASE_PROJET?>/index.php" >
                            <button type="button" class="btn btn-light">Liste des films</button>
                        </a>
                    </li>

                    <?php if (empty($_SESSION)) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php BASE_PROJET?>/creation-compte.php">
                                <button type="button" class="btn btn-light">Inscription</button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php BASE_PROJET?>/connexion.php">
                                <button type="button" class="btn btn-light">Connexion</button>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php BASE_PROJET?>/creation-film.php">
                                <button type="button" class="btn btn-light">Ajouter un film</button>
                            </a>
                        </li>
                        <div class="btn-group dropdown" role="group">
                            <button type="button" class="btn btn-sm btn-light  dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bi bi-person-circle me-1 "></i><?= $utilisateur["pseudo_utilisateur"] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-center">
                                <li><a class="dropdown-item" href="<?php BASE_PROJET ?>/deconnexion.php"><i
                                                class="bi bi-box-arrow-right me-1"></i>Déconnexion</a>
                                </li>
                                <li><a class="dropdown-item" href="<?php BASE_PROJET ?>/liste_film_utilisateur.php"><i class="bi bi-arrow-return-right"></i>Ma liste de film</a>
                                </li>

                            </ul>
                        </div>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>

