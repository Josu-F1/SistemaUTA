<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h2 class="text-center mb-4">🏛️ Nosotros - Universidad Técnica de Ambato</h2>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="text-primary">Historia</h4>
                    <p>
                        La Universidad Técnica de Ambato fue creada el 18 de abril de 1969, como una institución de educación superior
                        comprometida con la formación de profesionales de excelencia y el desarrollo de la región central del Ecuador.
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-bullseye me-2"></i>Misión
                            </h5>
                            <p class="card-text">
                                Formar profesionales líderes competentes, con visión humanística y pensamiento crítico,
                                a través de la docencia, la investigación y la vinculación, que contribuyan al desarrollo
                                del país y la sociedad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fas fa-eye me-2"></i>Visión
                            </h5>
                            <p class="card-text">
                                Ser una universidad acreditada, socialmente responsable, referente en la educación superior,
                                en la formación de talento humano, en la investigación, innovación y vinculación con la sociedad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

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
            
            </div>
        </div>
    </div>
</div>
<br>
<hr>
<h3> <i class="fas fa-users"></i> Gestión de Estudiantes</h3>
    <div class="mb-3 d-flex flex-wrap align-items-center bg-light p-3 rounded shadow-sm">
        
        <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
            <button type="button" class="btn btn-success me-3 mb-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-plus-circle me-2"></i> Agregar Nuevo Estudiante
            </button>
        <?php endif; ?>

        <a href="reporteEstudiante.php" class="btn btn-primary me-3 mb-2" target="_blank">
            <i class="fas fa-file-pdf me-2"></i> Reporte General
        </a>
        <button type="button" class="btn btn-outline-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#reporteFpdfCedulaModal">
             <i class="fas fa-file-invoice"></i> Reporte Cedula FPDF
        </button>

    </div>



    <!-- Buscador dinámico por cédula -->
    <div class="mb-3">
        <div class="input-group" style="max-width: 500px;">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control" id="searchInput" placeholder="Buscar por cédula...">
            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                <i class="fas fa-times"></i> Limpiar
            </button>
        </div>
        <small class="text-muted" id="searchResults"></small>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped" id="tabla-estudiantes">
            <thead class="table-dark">
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "models/conexion.php";
                $_GET['formato'] = 'html';
                include "models/select.php";
                unset($_GET['formato']);
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Agregar Nuevo Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <div class="mb-3">
                            <label for="addCedula" class="form-label">Cédula:</label>
                            <input type="text" class="form-control" id="addCedula" name="cedula" required>
                        </div>
                        <div class="mb-3">
                            <label for="addNombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="addNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="addApellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="addApellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="addDireccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="addDireccion" name="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="addTelefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="addTelefono" name="telefono">
                        </div>
                        <div id="addFormMessage" class="mt-3"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="addStudentForm" class="btn btn-primary">Guardar Estudiante</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Editar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm">
                        <input type="hidden" id="editCedulaOriginal" name="cedula">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editApellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="editApellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDireccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="editDireccion" name="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="editTelefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="editTelefono" name="telefono">
                        </div>
                        <div id="editFormMessage" class="mt-3"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="editStudentForm" class="btn btn-primary">Actualizar Estudiante</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reporteFpdfCedulaModal" tabindex="-1" aria-labelledby="reporteFpdfCedulaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reporteFpdfCedulaModalLabel">Generar Reporte FPDF por Cédula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formReporteFpdfCedula">
                        <div class="mb-3">
                            <label for="cedulaFpdf" class="form-label">Cédula del Estudiante:</label>
                            <input type="text" class="form-control" id="cedulaFpdf" name="cedula" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="formReporteFpdfCedula" class="btn btn-primary">Generar Reporte FPDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reporteJasperCedulaModal" tabindex="-1" aria-labelledby="reporteJasperCedulaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reporteJasperCedulaModalLabel">Generar Reporte Jasper por Cédula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formReporteJasperCedula">
                        <div class="mb-3">
                            <label for="cedulaJasper" class="form-label">Cédula del Estudiante:</label>
                            <input type="text" class="form-control" id="cedulaJasper" name="cedula" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="formReporteJasperCedula" class="btn btn-primary">Generar Reporte Jasper</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Confirmación para Eliminar -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                    <h6 class="mb-3">¿Estás seguro de que quieres eliminar a este estudiante?</h6>
                    <p class="text-muted mb-2">
                        <strong>Cédula:</strong> <span id="deleteStudentCedula"></span>
                    </p>
                    <p class="text-muted mb-0">
                        <strong>Nombre:</strong> <span id="deleteStudentNombre"></span>
                    </p>
                    <div class="alert alert-warning mt-3 mb-0" role="alert">
                        <small><i class="fas fa-info-circle me-1"></i>Esta acción no se puede deshacer.</small>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash-alt me-1"></i>Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addStudentForm = document.getElementById('addStudentForm');
        const addFormMessage = document.getElementById('addFormMessage');
        const addStudentModal = new bootstrap.Modal(document.getElementById('addStudentModal'));

        const editStudentForm = document.getElementById('editStudentForm');
        const editFormMessage = document.getElementById('editFormMessage');
        const editStudentModal = new bootstrap.Modal(document.getElementById('editStudentModal'));

        const tablaEstudiantesBody = document.querySelector('#tabla-estudiantes tbody');

        const formReporteFpdfCedula = document.getElementById('formReporteFpdfCedula');
        const reporteFpdfCedulaModal = new bootstrap.Modal(document.getElementById('reporteFpdfCedulaModal'));

        const formReporteJasperCedula = document.getElementById('formReporteJasperCedula');
        const reporteJasperCedulaModal = new bootstrap.Modal(document.getElementById('reporteJasperCedulaModal'));

        // Modal de confirmación de eliminación
        const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let studentToDelete = null;

        // --- NUEVO: Variables para el buscador ---
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearch');
        const searchResults = document.getElementById('searchResults');
        const tableRows = document.querySelectorAll('#tabla-estudiantes tbody tr');

        // --- Function to refresh the student table ---
        function refreshStudentTable() {
            location.reload();
        }

        // --- NUEVO: Función de búsqueda dinámica por cédula ---
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const cedula = row.cells[0].textContent.toLowerCase();

                // Buscar solo por cédula
                const matches = cedula.includes(searchTerm);

                if (matches || searchTerm === '') {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Actualizar contador de resultados
            if (searchTerm !== '') {
                searchResults.textContent = `Mostrando ${visibleCount} de ${tableRows.length} estudiantes`;
            } else {
                searchResults.textContent = '';
            }
        }

        // --- NUEVO: Event listeners para el buscador ---
        searchInput.addEventListener('input', filterTable);
        
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterTable();
            searchInput.focus();
        });

        // Limpiar búsqueda con tecla Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchInput.value = '';
                filterTable();
            }
        });

        // --- "Add Student" form submission (via AJAX) ---
        addStudentForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(addStudentForm);

            fetch('./models/guardar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                } else {
                    return response.text();
                }
            })
            .then(data => {
                let message = '';
                let isSuccess = false;

                if (typeof data === 'string') {
                    message = data;
                    isSuccess = data.includes("Se inserto el estudiante");
                } else if (typeof data === 'object' && data !== null && 'message' in data) {
                    message = data.message;
                    isSuccess = data.message.includes("Se inserto el estudiante");
                } else {
                    message = 'Respuesta desconocida del servidor.';
                    isSuccess = false;
                }

                if (isSuccess) {
                    addFormMessage.className = 'alert alert-success';
                    addFormMessage.textContent = 'Estudiante agregado exitosamente.';
                    addStudentForm.reset();
                    refreshStudentTable();
                    setTimeout(() => addStudentModal.hide(), 1500);
                } else {
                    addFormMessage.className = 'alert alert-danger';
                    addFormMessage.textContent = 'Error al agregar estudiante: ' + message;
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario (Agregar):', error);
                addFormMessage.className = 'alert alert-danger';
                addFormMessage.textContent = 'Error de conexión o en el servidor.';
            });
        });

        // --- Logic for DELETE and EDIT buttons ---
        tablaEstudiantesBody.addEventListener('click', function(event) {
            // Logic for the DELETE button
            if (event.target.classList.contains('delete-btn')) {
                const row = event.target.closest('tr');
                const studentCedula = event.target.dataset.estcedula;
                const cells = row.cells;
                const nombre = cells[1].textContent + ' ' + cells[2].textContent;
                
                // Guardar información del estudiante a eliminar
                studentToDelete = studentCedula;
                
                // Mostrar información en el modal
                document.getElementById('deleteStudentCedula').textContent = studentCedula;
                document.getElementById('deleteStudentNombre').textContent = nombre;
                
                // Mostrar el modal
                deleteConfirmModal.show();
            }
            
            // Logic for the EDIT button
            if (event.target.classList.contains('edit-btn')) {
                const row = event.target.closest('tr');
                const cedula = event.target.dataset.estcedula; 
                
                const cells = row.cells;
                const nombre = cells[1].textContent;
                const apellido = cells[2].textContent;
                const direccion = cells[3].textContent;
                const telefono = cells[4].textContent;

                document.getElementById('editCedulaOriginal').value = cedula;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editApellido').value = apellido;
                document.getElementById('editDireccion').value = direccion;
                document.getElementById('editTelefono').value = telefono;
                
                editFormMessage.textContent = '';
                editFormMessage.className = 'mt-3'; 

                editStudentModal.show();
            }
        });

        // --- Confirm Delete Button Handler ---
        confirmDeleteBtn.addEventListener('click', function() {
            if (studentToDelete) {
                const formData = new FormData();
                formData.append('estcedula', studentToDelete);

                // Deshabilitar el botón mientras se procesa
                confirmDeleteBtn.disabled = true;
                confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Eliminando...';

                fetch('./models/eliminar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    return response.text(); 
                })
                .then(responseText => {
                    if (responseText.includes("Se eliminó el estudiante") || responseText.includes("Se elimino")) {
                        // Cerrar modal
                        deleteConfirmModal.hide();
                        
                        // Mostrar mensaje de éxito con toast o alert
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                        alertDiv.style.zIndex = '9999';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>Estudiante eliminado exitosamente.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.body.appendChild(alertDiv);
                        
                        // Remover alerta después de 3 segundos
                        setTimeout(() => {
                            alertDiv.remove();
                        }, 3000);
                        
                        refreshStudentTable(); 
                    } else {
                        alert('Error al eliminar estudiante: ' + responseText);
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar estudiante:', error);
                    alert('Error de conexión de red o en el servidor al eliminar.');
                })
                .finally(() => {
                    // Restaurar el botón
                    confirmDeleteBtn.disabled = false;
                    confirmDeleteBtn.innerHTML = '<i class="fas fa-trash-alt me-1"></i>Eliminar';
                    studentToDelete = null;
                });
            }
        });

        // --- "Edit Student" form submission (via AJAX) ---
        editStudentForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(editStudentForm);
            formData.append('estcedula', document.getElementById('editCedulaOriginal').value);

            editFormMessage.textContent = 'Actualizando...';
            editFormMessage.className = 'alert alert-info';

            fetch('./models/editar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.text();
            })
            .then(text => {
                let data;
                let message = text;

                if (text.trim().charAt(0) === '{' || text.trim().charAt(0) === '"') {
                    try {
                        data = JSON.parse(text);
                        
                        if (data && typeof data === 'object' && data.message) {
                            message = data.message;
                        } else if (typeof data === 'string') {
                            message = data;
                        }
                    } catch (e) {
                        // Si falla el parseo, mantenemos el texto completo
                    }
                }
                
                if (message.includes("Se actualizó el estudiante") || message.includes("Se actualizo")) {
                    editFormMessage.className = 'alert alert-success';
                    editFormMessage.textContent = 'Estudiante actualizado exitosamente.';
                    refreshStudentTable();
                    setTimeout(() => editStudentModal.hide(), 1500);
                } else {
                    editFormMessage.className = 'alert alert-danger';
                    editFormMessage.textContent = 'Error al actualizar estudiante: ' + message;
                }
            })
            .catch(error => {
                console.error('Error de red al enviar el formulario (Editar):', error);
                editFormMessage.className = 'alert alert-danger';
                editFormMessage.textContent = 'Error de conexión de red o en el servidor.';
            });
        });

        // --- "FPDF Report by ID" form submission ---
        formReporteFpdfCedula.addEventListener('submit', function(event) {
            event.preventDefault();
            const cedula = document.getElementById('cedulaFpdf').value;
            if (cedula) {
                window.open(`reporteEstXCedulaFpdf.php?cedula=${encodeURIComponent(cedula)}`, '_blank');
                
                // Cerrar el modal correctamente y limpiar el backdrop
                reporteFpdfCedulaModal.hide();
                
                // Limpiar el formulario
                document.getElementById('cedulaFpdf').value = '';
                
                // Asegurar que se remueva el backdrop y se restaure el scroll
                setTimeout(() => {
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }, 300);
            } else {
                alert('Por favor, ingrese una cédula para generar el reporte FPDF.');
            }
        });

        // --- "Jasper Report by ID" form submission ---
        formReporteJasperCedula.addEventListener('submit', function(event) {
            event.preventDefault();
            const cedula = document.getElementById('cedulaJasper').value;
            if (cedula) {
                window.open(`reporteEstudianteXCedula.php?cedula=${encodeURIComponent(cedula)}`, '_blank');
                reporteJasperCedulaModal.hide();
            } else {
                alert('Por favor, ingrese una cédula para generar el reporte Jasper.');
            }
        });
    });
</script>
</div>
</body>
</html>