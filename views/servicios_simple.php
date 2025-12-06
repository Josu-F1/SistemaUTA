<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    
    <style>
        /* ESTO ARREGLA EL TAMAÑO DE LOS INPUTS */
        /* EasyUI necesita content-box para calcular alturas correctamente */
        .textbox .textbox-text, 
        .textbox .textbox-addon, 
        .textbox .textbox-icon,
        .panel-header, 
        .panel-body, 
        .window-header, 
        .window-body {
            box-sizing: content-box !important;
        }
        
        /* Ajuste de altura para los inputs dentro del modal */
        .fitem { margin-bottom: 15px; }
        .fitem label { display: inline-block; width: 80px; font-weight: bold; margin-bottom: 5px; }
        
        /* Forzar altura mínima en los inputs de texto de easyui */
        .easyui-textbox { height: 30px; }
    </style>
</head>
<body>

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
    <hr>

    <h3><i class="fas fa-users"></i> Gestión de Estudiantes</h3>
    <p>Utilice la barra de herramientas para gestionar los registros.</p>
    
    <table id="dg" title="Listado de Estudiantes" class="easyui-datagrid" style="width:100%;height:450px"
            url="models/select.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="estcedula" width="50" sortable="true">Cédula</th>
                <th field="estnombre" width="80" sortable="true">Nombre</th>
                <th field="estapellido" width="80" sortable="true">Apellido</th>
                <th field="estdireccion" width="100">Dirección</th>
                <th field="esttelefono" width="50">Teléfono</th>
            </tr>
        </thead>
    </table>

    <div id="toolbar">
        <span style="margin-right:10px">
            <input id="searchCedula" class="easyui-textbox" style="width:180px; height:30px;" prompt="Buscar por cédula" />
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchByCedula()">Buscar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="clearSearch()">Limpiar</a>
        </span>
        
        <span class="datagrid-btn-separator" style="vertical-align: middle; display:inline-block;float:none"></span>

        <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar</a>
            <span class="datagrid-btn-separator" style="vertical-align: middle; display:inline-block;float:none"></span>
        <?php endif; ?>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="reporteFPDF()">Reporte General</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="reporteFPDFCedula()">Reporte Cédula</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:450px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Información del Estudiante</h3>
            
            <div class="fitem" id="div-cedula">
                <input name="estcedula" id="estcedula" class="easyui-textbox" required="true" label="Cédula:" style="width:100%; height:32px;">
            </div>
            
            <div class="fitem">
                <input name="estnombre" id="estnombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%; height:32px;">
            </div>
            
            <div class="fitem">
                <input name="estapellido" id="estapellido" class="easyui-textbox" required="true" label="Apellido:" style="width:100%; height:32px;">
            </div>
            
            <div class="fitem">
                <input name="estdireccion" id="estdireccion" class="easyui-textbox" label="Dirección:" style="width:100%; height:32px;">
            </div>
            
            <div class="fitem">
                <input name="esttelefono" id="esttelefono" class="easyui-textbox" label="Teléfono:" style="width:100%; height:32px;">
            </div>
            
            <input type="hidden" name="editCedulaOriginal" id="editCedulaOriginal">
        </form>
    </div>

    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="closeDlg()" style="width:90px">Cancelar</a>
    </div>

    <script type="text/javascript">
        var url;
        
        function closeDlg(){ $('#dlg').dialog('close'); }
        
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Estudiante');
            $('#fm').form('clear');
            $('#div-cedula').show();
            $('#estcedula').textbox('readonly', false);
            url = 'models/guardar.php';
        }
        
        function editUser() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Actualizar Estudiante');
                $('#fm').form('load', row);
                $('#div-cedula').hide();
                $('#editCedulaOriginal').val(row.estcedula);
                url = 'models/editar.php';
            } else {
                $.messager.alert('Atención', 'Selecciona un estudiante primero.', 'warning');
            }
        }
        
        function saveUser(){
            if (!$('#fm').form('validate')) return;

            var data = {
                estcedula: $('#estcedula').textbox('getValue'),
                estnombre: $('#estnombre').textbox('getValue'),
                estapellido: $('#estapellido').textbox('getValue'),
                estdireccion: $('#estdireccion').textbox('getValue'),
                esttelefono: $('#esttelefono').textbox('getValue'),
                editCedulaOriginal: $('#editCedulaOriginal').val() || $('#estcedula').textbox('getValue')
            };

            $.ajax({
                url: url, type: 'POST', data: data, dataType: 'text', 
                success: function(result){
                    if (result.includes("Se inserto") || result.includes("Se actualizo") || result.includes("actualizado")) {
                        $.messager.show({ title: 'Éxito', msg: 'Operación correcta.', timeout: 2000, showType:'slide' });
                        $('#dlg').dialog('close');
                        $('#dg').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result, 'error');
                    }
                },
                error: function(){ $.messager.alert('Error', 'Fallo de conexión.', 'error'); }
            });
        }
        
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Seguro de eliminar a: <b>'+row.estnombre+' '+row.estapellido+'</b>?',function(r){
                    if (r){
                        $.post('models/eliminar.php', {estcedula:row.estcedula}, function(result){
                            if (result.includes("Se elimino") || result.includes("eliminado")){
                                $('#dg').datagrid('reload');    
                                $.messager.show({ title: 'Eliminado', msg: 'Registro borrado.', timeout: 2000, showType:'slide' });
                            } else {
                                $.messager.alert('Error', result, 'error');
                            }
                        },'text');
                    }
                });
            } else {
                $.messager.alert('Atención', 'Selecciona un registro.', 'warning');
            }
        }

        // Reportes
        function reporteFPDF() { window.open('reporteEstudiante.php', '_blank'); }
        function reporteJasper() { window.open('reporteEstudianteJasper.php', '_blank'); }
        function reporteFPDFCedula() {
            var row = $('#dg').datagrid('getSelected'); 
            if(row) window.open('reporteEstXCedulaFpdf.php?cedula=' + encodeURIComponent(row.estcedula), '_blank');
            else $.messager.alert('Info', 'Selecciona un registro.', 'info');
        }
        function reporteJasperCedula() {
            var row = $('#dg').datagrid('getSelected'); 
            if(row) window.open('reporteEstudianteXCedula.php?cedula=' + encodeURIComponent(row.estcedula), '_blank');
            else $.messager.alert('Info', 'Selecciona un registro.', 'info');
        }

        // Buscador
        function searchByCedula(){
            var ced = $('#searchCedula').textbox('getValue');
            $('#dg').datagrid('load', { cedula: ced });
        }
        function clearSearch(){
            $('#searchCedula').textbox('clear');
            $('#dg').datagrid('load', {});
        }
        $(function(){
            $('#searchCedula').textbox('textbox').bind('keydown', function(e){
                if (e.keyCode == 13) searchByCedula();
            });
        });
    </script>
</body>
</html>