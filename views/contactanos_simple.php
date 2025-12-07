<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="text-center mb-4">📞 Contáctanos</h2>

            <?php if(isset($_SESSION['validarIngreso']) && $_SESSION['validarIngreso'] == 'ok'): ?>
                <div class="card bg-light border-info shadow-sm mb-4" style="min-width: 320px;">
                    <div class="card-body py-2 px-3 d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-circle fa-3x text-info"></i>
                        </div>
                        
                        <div class="flex-grow-1">
                            <h6 class="card-title text-dark fw-bold mb-1">
                                <?php echo $_SESSION['nombre_real'] ?? $_SESSION['usuario']; ?>
                            </h6>
                            <div class="small text-muted" style="line-height: 1.2;">
                                <span class="badge bg-primary mb-1">
                                    <?php echo ucfirst($_SESSION['privilegio'] ?? 'Invitado'); ?>
                                </span>
                                <br>
                                <i class="fas fa-clock me-1"></i>
                                <?php 
                                    if(empty($_SESSION['ultima_conexion'])){
                                        echo "Primer ingreso";
                                    } else {
                                        echo date("d/m/Y H:i", strtotime($_SESSION['ultima_conexion']));
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="ms-3 border-start ps-3">
                            <a href="index.php?action=salir" class="btn btn-outline-danger btn-sm" title="Cerrar Sesión">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                            </h5>
                            <p class="card-text">
                                <strong>Dirección:</strong><br>
                                Av. Los Chasquis y Río Payamino<br>
                                Huachi Chico, Ambato - Ecuador
                            </p>
                            <p class="card-text">
                                <strong>Código Postal:</strong> 180206
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fas fa-phone me-2"></i>Contacto
                            </h5>
                            <p class="card-text">
                                <strong>Teléfono:</strong><br>
                                (03) 2848487 - 2400087
                            </p>
                            <p class="card-text">
                                <strong>Email:</strong><br>
                                info@uta.edu.ec<br>
                                admisiones@uta.edu.ec
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-warning">
                        <i class="fas fa-clock me-2"></i>Horarios de Atención
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Lunes a Viernes:</strong></p>
                            <ul class="list-unstyled">
                                <li>Mañana: 08:00 - 12:00</li>
                                <li>Tarde: 14:00 - 18:00</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sábados:</strong></p>
                            <ul class="list-unstyled">
                                <li>Mañana: 08:00 - 12:00</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Desarrolladores -->
            <div class="card shadow-lg border-0 mb-4 mt-5">
                <div class="card-header text-center py-3" style="background: linear-gradient(135deg, #901B20 0%, #6d1419 100%); color: white !important;">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-code me-2"></i>Desarrollado por
                    </h4>
                    <p class="mb-0 small text-white">Equipo de Desarrollo - Sistema de Gestión UTA</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Desarrollador 1 -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <div class="rounded-circle bg-primary bg-gradient d-inline-flex align-items-center justify-content-center" 
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-user-tie fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2" style="color: #901B20;">Josue Neptali Llumitasig Pasochoa</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-laptop-code me-1"></i>Full Stack Developer
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge bg-primary">PHP</span>
                                        <span class="badge bg-info">MySQL</span>
                                        <span class="badge bg-success">JavaScript</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Desarrollador 2 -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <div class="rounded-circle bg-success bg-gradient d-inline-flex align-items-center justify-content-center" 
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-user-tie fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2" style="color: #901B20;">Bryan Josue Lopez Vera</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-database me-1"></i>Backend Developer
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge bg-danger">Laravel</span>
                                        <span class="badge bg-info">MySQL</span>
                                        <span class="badge bg-warning text-dark">API REST</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Desarrollador 3 -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <div class="rounded-circle bg-warning bg-gradient d-inline-flex align-items-center justify-content-center" 
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-user-tie fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2" style="color: #901B20;">Jonathan Josue Fiallos Yanza</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-paint-brush me-1"></i>Frontend Developer
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge bg-primary">Bootstrap</span>
                                        <span class="badge bg-warning text-dark">JavaScript</span>
                                        <span class="badge bg-info">CSS3</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional del equipo -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-light border text-center" role="alert">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                <strong>Universidad Técnica de Ambato</strong> - Facultad de Ingeniería en Sistemas<br>
                                <small class="text-muted">Proyecto de Desarrollo Web • Diciembre 2025</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.bg-gradient {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
}
</style>
```