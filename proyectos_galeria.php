<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería de Proyectos - INCOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .classroom-card { border: 1px solid #dadce0; border-radius: 8px; overflow: hidden; height: 100%; position: relative; background: #fff; }
        .card-header-custom { height: 130px; background-size: cover; background-position: center; padding: 15px; color: white; position: relative; background-blend-mode: multiply; }
        .student-photo { width: 75px; height: 75px; border-radius: 50%; border: 4px solid white; position: absolute; top: 90px; right: 15px; object-fit: cover; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .id-badge { position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.6); color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 12px; }
        .card-body { padding: 45px 15px 15px 15px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">← Volver al Portal INCOS</a>
    </div>
</nav>

<div class="container">
    <h2 class="fw-bold mb-4">Proyectos Registrados</h2>
    <div class="row g-4">
        <?php
        $filtro = isset($_GET['carrera']) ? "WHERE carrera = '" . $_GET['carrera'] . "'" : "";
        $res = $conn->query("SELECT * FROM proyectos $filtro ORDER BY id DESC");
        
        if($res->num_rows > 0):
            while($row = $res->fetch_assoc()): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card classroom-card">
                        <div class="card-header-custom" style="background-color: <?= $row['color_fondo'] ?>; background-image: url('<?= $row['foto_proyecto'] ?>');">
                            <span class="id-badge">ID-<?= $row['id'] ?></span>
                            <p class="fw-bold mb-0 text-truncate"><?= $row['titulo'] ?></p>
                            <small class="text-truncate d-block"><?= $row['carrera'] ?></small>
                        </div>
                        <img src="<?= $row['foto_estudiante'] ?>" class="student-photo">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1"><?= $row['nombres'] ?> <?= $row['apellidos'] ?></h6>
                            <p class="small text-secondary"><?= $row['descripcion'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; 
        else: echo "<p class='text-center'>No hay proyectos en esta categoría aún.</p>"; endif; ?>
    </div>
</div>
</body>
</html>