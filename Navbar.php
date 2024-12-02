<?php
class Navbar {
    public static function render($usuarioLogueado = null, $rolUsuario = null) {
        ?>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="inicio.php">
                    <img src="imagenes/Logo.png" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="rentaDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Diversión
                            </a>
                            <div class="dropdown-menu" aria-labelledby="rentaDropdown">
                                <a class="dropdown-item" href="renta_inflables.php">Inflables</a>
                                <a class="dropdown-item" href="renta_brincos.php">Brincolines</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="mobiliarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Mobiliaria
                            </a>
                            <div class="dropdown-menu" aria-labelledby="mobiliarioDropdown">
                                <a class="dropdown-item" href="renta_sillas.php">Sillas</a>
                                <a class="dropdown-item" href="renta_mesas.php">Mesas</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="cateringDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Servicio de catering
                            </a>
                            <div class="dropdown-menu" aria-labelledby="cateringDropdown">
                                <a class="dropdown-item" href="comida.php">Comidas</a>
                                <a class="dropdown-item" href="postres.php">Postres y repostería</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contacto.php">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="informacion.php">Información</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if ($usuarioLogueado): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Hola, <?= htmlspecialchars($usuarioLogueado) ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                    <?php if ($rolUsuario == 'admin'): ?>
                                        <a class="dropdown-item" href="admin_dashboard.php" style="font-weight: bold;">Panel de Administración</a>
                                    <?php endif; ?>
                                    <?php if ($rolUsuario != 'admin'): ?>
                                    <?php endif; ?>
                                    <a class="dropdown-item" href="cotizaciones.php" style="font-weight: bold;">Cotización</a>
                                    <a class="dropdown-item" href="logout.php" style="font-weight: bold;">Cerrar Sesión</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="Login.html" style="font-weight: bold;">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Registro.html" style="font-weight: bold;">Registrarse</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
    }
}
?>
