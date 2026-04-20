<?php 
include 'db.php'; 

$mensaje = "";

if (isset($_POST['enviar'])) {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $ci = $_POST['ci'];
    $carrera = $_POST['carrera'];
    $anio = $_POST['anio'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];

    // Crear carpeta si no existe
    if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }

    // 1. Subir Foto del Estudiante (Perfil)
    $ext_perfil = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
    $foto_perfil = "uploads/perfil_" . time() . "_" . $ci . "." . $ext_perfil;
    move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);

    // 2. Subir Foto del Proyecto (Fondo)
    $ext_fondo = pathinfo($_FILES['foto_fondo']['name'], PATHINFO_EXTENSION);
    $foto_fondo = "uploads/fondo_" . time() . "_" . $ci . "." . $ext_fondo;
    move_uploaded_file($_FILES['foto_fondo']['tmp_name'], $foto_fondo);

    // Guardar en BD
    $stmt = $conn->prepare("INSERT INTO proyectos (nombres, apellidos, foto_estudiante, ci, carrera, anio, titulo, descripcion, foto_proyecto, color_fondo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nombres, $apellidos, $foto_perfil, $ci, $carrera, $anio, $titulo, $descripcion, $foto_fondo, $color);
    
    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit();
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Proyectos - INCOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --incos-green: #889e8dfb; --incos-dark: #333; }
        body { background-color: #1d502e; font-family: 'Segoe UI', sans-serif; }
        .card-registro { border: none; border-top: 5px solid var(--incos-green); border-radius: 8px; }
        .btn-incos { background-color: var(--incos-green); color: white; font-weight: bold; border: none; }
        .btn-incos:hover { background-color: #7cb342; color: white; }
        .form-label { font-weight: 600; color: #555; font-size: 0.9rem; }
        .header-registro { background-color: white; padding: 20px; margin-bottom: 30px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="header-registro shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-bold text-secondary">FERIA <span style="color: var(--incos-green);">INCOS 2026</span></h4>
        <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver al Inicio</a>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-registro shadow-sm p-4">
                <h2 class="fw-bold mb-4 text-center">Registro de Proyecto</h2>
                <?= $mensaje ?>
                
                <form action="registro.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-12"><h5 class="text-success border-bottom pb-2">Datos del Estudiante</h5></div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Nombres</label>
                            <input type="text" name="nombres" class="form-control" placeholder="Tus nombres" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" placeholder="Tus apellidos" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CI (Cédula de Identidad)</label>
                            <input type="text" name="ci" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Año que cursa</label>
                            <select name="anio" class="form-select">
                                <option>1er Año</option>
                                <option>2do Año</option>
                                <option>3er Año</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tu Foto de Perfil</label>
                            <input type="file" name="foto_perfil" class="form-control" accept="image/*" required>
                        </div>

                        <div class="col-12"><h5 class="text-success border-bottom pb-2 mt-3">Información del Proyecto</h5></div>
                        
                        <div class="col-12">
                            <label class="form-label">Carrera</label>
                            <select name="carrera" class="form-select" required>
                                <option value="" disabled selected>Selecciona tu carrera</option>
                                <option>Contaduría General</option>
                                <option>Comercio Internacional y Administración Aduanera</option>
                                <option>Administración de Empresas</option>
                                <option>Secretariado Ejecutivo</option>
                                <option>Sistemas Informáticos</option>
                                <option>Idioma Inglés</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Título del Proyecto</label>
                            <input type="text" name="titulo" class="form-control" placeholder="Nombre creativo de tu proyecto" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Breve Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="¿De qué trata tu proyecto? (Máx. 200 caracteres)"></textarea>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label text-primary">Imagen de Portada (Fondo de Tarjeta)</label>
                            <input type="file" name="foto_fondo" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Color de Tinte</label>
                            <input type="color" name="color" class="form-control form-control-color w-100" value="#8bc34a">
                        </div>

                        <div class="col-12 mt-5 text-center">
                            <button type="submit" name="enviar" class="btn btn-incos btn-lg px-5 shadow-sm">PUBLICAR PROYECTO</button>
                            <p class="text-muted mt-3 small">Al publicar, tu proyecto aparecerá automáticamente en la galería principal.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>