<?php 
include 'db.php'; 
function contarProyectos($conn, $carrera) {
    $carrera_esc = $conn->real_escape_string($carrera);
    $res = $conn->query("SELECT COUNT(*) as total FROM proyectos WHERE carrera = '$carrera_esc'");
    $data = $res->fetch_assoc();
    return $data['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INCOS EL ALTO - Feria 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { 
            --incos-dark: #0a4a34; 
            --incos-gold: #E3D647; 
            --incos-light-green: #4CAF50;
        }

        /* Cambiamos mandatory por proximity para que no fuerce el salto en todo el documento */
        html { 
            scroll-snap-type: y proximity; 
            scroll-behavior: smooth; 
        }
        
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        /* --- CARÁTULA FULL SCREEN --- */
        .hero-wrapper {
            height: 100vh;
            background-color: var(--incos-dark);
            display: flex;
            align-items: center;
            scroll-snap-align: start; /* El salto empieza aquí */
            position: relative;
            color: white;
            overflow: hidden;
        }

        .hero-title { font-size: 4rem; font-weight: 900; }
        .dots-pattern {
            position: absolute; top: 10%; right: 5%; width: 200px; height: 300px;
            background-image: radial-gradient(rgba(255,255,255,0.2) 2px, transparent 2px);
            background-size: 25px 25px;
        }

        /* --- MENÚ STICKY --- */
        .navbar-incos {
            background-color: var(--incos-dark);
            border-bottom: 3px solid var(--incos-light-green);
            position: sticky;
            top: 0;
            z-index: 1000;
            /* ELIMINADO: scroll-snap-align: start; (Esto evita que se bloquee el scroll abajo) */
        }
        
        .nav-link { color: white !important; font-weight: 500; margin: 0 8px; transition: 0.3s; }
        .nav-link:hover { color: var(--incos-gold) !important; }
        
        .btn-nav { font-weight: bold; border-radius: 5px; padding: 8px 15px !important; }
        .btn-add { background-color: var(--incos-gold); color: #333 !important; }
        .btn-join { background-color: transparent; border: 2px solid white; color: white !important; }

        /* --- SECCIÓN CONTENIDO --- */
        .content-section { padding: 80px 0; background: #fff; }

        .feature-box { 
            background: white; border: 1px solid #eee; padding: 25px; 
            text-align: center; border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .feature-box i { font-size: 2.5rem; color: var(--incos-light-green); }

        .carrera-card {
            background: #fdfdfd; border-left: 5px solid var(--incos-light-green);
            padding: 20px; display: flex; align-items: center;
            text-decoration: none; color: #333; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03); margin-bottom: 20px;
        }
        .logo-carrera { width: 50px; margin-right: 15px; }

        /* --- PIE DE PÁGINA --- */
        footer { 
            background-color: var(--incos-dark); 
            color: white; 
            padding: 50px 0 20px; 
            border-top: 5px solid var(--incos-gold);
            /* Aseguramos que no tenga snap align */
            scroll-snap-align: none; 
        }
        footer h5 { color: var(--incos-gold); font-weight: bold; margin-bottom: 20px; }
        footer ul { list-style: none; padding: 0; }
        footer ul li { margin-bottom: 10px; opacity: 0.8; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 30px; padding-top: 20px; font-size: 0.9rem; opacity: 0.6; }
    </style>
</head>
<body>

<header class="hero-wrapper">
    <div class="dots-pattern"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="hero-title">FERIA INCOS<br>EL ALTO</h1>
                <p class="fs-5 opacity-75">Feria Educativa de Innovación y Tecnología - Gestión 2026</p>
                <a href="#menu" class="btn btn-outline-light btn-lg rounded-pill px-5 mt-4">Explorar Ahora</a>
            </div>
            <div class="col-md-5 text-center">
                <img src="img/logo png.png" class="img-fluid" style="max-height: 400px;" onerror="this.src='https://via.placeholder.com/400x400/0a4a34/ffffff?text=LOGO+DORADO'">
            </div>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-incos" id="menu">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#">Feria INCOS</a>
        <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="bi bi-list text-white"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="proyectos_galeria.php">Proyectos</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Jurados</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Información INCOS</a></li>
                
                <li class="nav-item ms-lg-2">
                    <a class="nav-link btn-nav btn-add" href="registro.php">
                        <i class="bi bi-plus-circle me-1"></i> Añadir Proyecto
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="nav-link btn-nav btn-join" href="unirse.php">
                        <i class="bi bi-person-plus me-1"></i> Unirse
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="content-section">
    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-md-3"><div class="feature-box"><i class="bi bi-lightbulb"></i><p class="fw-bold mt-2">Proyecto Innovador</p></div></div>
            <div class="col-md-3"><div class="feature-box"><i class="bi bi-people"></i><p class="fw-bold mt-2">Participación Total</p></div></div>
            <div class="col-md-3"><div class="feature-box"><i class="bi bi-display"></i><p class="fw-bold mt-2">Exposición y Demostración</p></div></div>
            <div class="col-md-3"><div class="feature-box"><i class="bi bi-geo-alt"></i><p class="fw-bold mt-2">Entrada Gratuita</p></div></div>
        </div>
    </div>

    <div class="container">
        <h2 class="fw-bold mb-4" style="color: var(--incos-dark);">CARRERAS PARTICIPANTES</h2>
        <div class="row g-4">
            <?php 
            $carreras = [
                ["nombre" => "Contaduría General", "logo" => "img/contaduria.jpg"],
                ["nombre" => "Comercio Internacional y Administración Aduanera", "logo" => "img/comercio.jpg"],
                ["nombre" => "Administración de Empresas", "logo" => "img/admin.jpg"],
                ["nombre" => "Secretariado Ejecutivo", "logo" => "img/secre.jpg"],
                ["nombre" => "Sistemas Informáticos", "logo" => "img/sis.jpg"],
                ["nombre" => "Idioma Inglés", "logo" => "img/ingles.jpg"]
            ];

            foreach($carreras as $c): 
                $total = contarProyectos($conn, $c['nombre']);
            ?>
            <div class="col-md-6 col-lg-4">
                <a href="proyectos_galeria.php?carrera=<?= urlencode($c['nombre']) ?>" class="carrera-card">
                    <img src="<?= $c['logo'] ?>" class="logo-carrera" onerror="this.src='https://via.placeholder.com/50?text=Logo'">
                    <div>
                        <h6 class="mb-0 fw-bold"><?= $c['nombre'] ?></h6>
                        <small class="text-muted"><?= $total ?> proyectos registrados</small>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>INCOS EL ALTO</h5>
                <p class="opacity-75">Formando profesionales de excelencia con visión tecnológica y compromiso social.</p>
                <div class="fs-4">
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-globe"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Enlaces Rápidos</h5>
                <ul>
                    <li><a href="#" class="text-white text-decoration-none opacity-75">Cronograma</a></li>
                    <li><a href="#" class="text-white text-decoration-none opacity-75">Reglamento</a></li>
                    <li><a href="#" class="text-white text-decoration-none opacity-75">Jurados</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Contacto</h5>
                <ul>
                    <li><i class="bi bi-geo-alt me-2"></i> Av. Juan Pablo II, El Alto</li>
                    <li><i class="bi bi-telephone me-2"></i> +591 2 284XXXX</li>
                    <li><i class="bi bi-envelope me-2"></i> info@incos-elalto.edu.bo</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p>&copy; 2026 INCOS El Alto - Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>