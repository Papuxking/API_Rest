<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
    <link rel="stylesheet" type="text/css" href="../jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/color.css">
    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../jquery/jquery.easyui.min.js"></script>
</head>

<body>
    <h2>Basic CRUD Application</h2>
    <p>Click the buttons on datagrid toolbar to do crud actions.</p>
    
    <div style="margin-bottom:10px">
        <input id="buscarCedula" class="easyui-textbox" style="width:300px">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true"
            onclick="searchUser()">Buscar por cédula</a>
    </div>

    <!-- IMPORTANTE -->
    <table id="dg" title="My Users" class="easyui-datagrid" style="width:700px;height:250px"
        url="http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php" method="GET" toolbar="#toolbar"
        pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="cedula" width="50">Cédula</th>
                <th field="nombres" width="50">Nombre</th>
                <th field="apellidos" width="50">Apellido</th>
                <th field="direccion" width="50">Dirección</th>
                <th field="telefono" width="50">Teléfono</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New
            User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true"
            onclick="editUser()">Edit User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true"
            onclick="destroyUser()">Remove User</a>
    </div>

    <div id="dlg" class="easyui-dialog" style="width:400px"
        data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>User Information</h3>
            <div style="margin-bottom:10px">
                <input name="cedula" class="easyui-textbox" required="true" label="cedula:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="nombres" class="easyui-textbox" required="true" label="Nombres:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="apellidos" class="easyui-textbox" required="true" label="Apellidos:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="direccion" class="easyui-textbox" required="true" label="Dirección:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="telefono" class="easyui-textbox" required="true" label="Telefono:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()"
            style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
            onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;

        function searchUser() {
    var cedula = $('#buscarCedula').textbox('getValue'); // Obtener el valor de la cédula

    // Verificar si el campo de búsqueda está vacío
    if (cedula) {
        // Si hay una cédula, realizar la búsqueda específica
        $.ajax({
            url: 'http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php?cedula=' + cedula,
            type: 'GET',
            success: function (result) {
                try {
                    var data = JSON.parse(result);

                    if (data.mensaje) {
                        $.messager.show({
                            title: 'Error',
                            msg: data.mensaje
                        });
                    } else {
                        // Cargar el resultado en el datagrid para una cédula específica
                        $('#dg').datagrid('loadData', [data]);
                    }
                } catch (e) {
                    console.error("Error del servidor:", result);
                    $.messager.show({
                        title: 'Error',
                        msg: 'Error del servidor'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la búsqueda:', error);
                $.messager.show({
                    title: 'Error',
                    msg: 'No se pudo buscar el estudiante'
                });
            }
        });
    } else {
        $.ajax({
            url: 'http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php',
            type: 'GET',
            success: function (result) {
                try {
                    var data = JSON.parse(result);

                    if (Array.isArray(data) && data.length > 0) {
                        $('#dg').datagrid('loadData', data);
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: 'No se encontraron estudiantes'
                        });
                    }
                } catch (e) {
                    console.error("Error del servidor:", result);
                    $.messager.show({
                        title: 'Error',
                        msg: 'Error del servidor'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la búsqueda:', error);
                $.messager.show({
                    title: 'Error',
                    msg: 'No se pudo cargar la lista de estudiantes'
                });
            }
        });
    }
}


        function newUser() {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New User');
            $('#fm').form('clear');
            url = 'http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php';
        }


        function editUser() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit User');
                $('#fm').form('load', row);
                url = 'http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php?cedula=' + row.cedula;
            }
        }

        function saveUser() {
            var method = url.includes('?cedula=') ? 'PUT' : 'POST'; // Determina si es PUT o POST
            var data = $('#fm').serializeArray(); // Recoge los datos del formulario

            var userData = {};
            $.each(data, function(i, field) {
                userData[field.name] = field.value;
            });

            // Configuración de la solicitud dependiendo del método
            var ajaxOptions = {
                url: url,
                type: method,
                success: function(result) {
                    try {
                        result = JSON.parse(result);
                        if (result.errorMsg) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlg').dialog('close'); // Cierra el diálogo
                            $('#dg').datagrid('reload'); // Recarga los datos del usuario
                        }
                    } catch (e) {
                        console.error("Respuesta inesperada del servidor:", result);
                        $.messager.show({
                            title: 'Error',
                            msg: 'Respuesta no válida del servidor'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar usuario:', error);
                }
            };

            // Si es PUT, envía los datos como JSON
            if (method === 'PUT') {
                ajaxOptions.contentType = "application/json";
                ajaxOptions.data = JSON.stringify(userData);
            } else {
                // Si es POST, envía los datos como formulario
                ajaxOptions.data = userData;
            }

            // Realiza la solicitud Ajax
            $.ajax(ajaxOptions);
        }


        //IMPORTANTE
        function destroyUser() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', '¿Está seguro de que desea eliminar a este estudiante?', function (r) {
                    if (r) {
                        $.ajax({
                            url: 'http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php?cedula=' + row.cedula, // Agregar la cédula en la URL
                            type: 'DELETE',
                            success: function (result) {
                                if (result.success) {
                                    $('#dg').datagrid('reload'); // Recargar datos
                                } else {
                                    $.messager.show({ // Mostrar mensaje de error
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            },
                            error: function () {
                                $.messager.show({
                                    title: 'Error',
                                    msg: 'No se pudo eliminar al estudiante.'
                                });
                            }
                        });
                    }
                });
            }
        }




    </script>
</body>

</html>