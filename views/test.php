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
    <p>Buscar estudiantes por su cédula o dejar en blanco para mostrar todos.</p>

    <!-- Buscador de Estudiante -->
    <form id="searchForm" method="GET" action="javascript:void(0);">
        <div style="margin-bottom:10px">
            <input id="cedula" name="cedula" class="easyui-textbox" label="Buscar por cédula:" style="width:300px">
            <button type="submit" class="easyui-linkbutton" iconCls="icon-search">Buscar</button>
        </div>
    </form>

    <!-- Tabla de Estudiantes -->
    <table id="studentTable" class="easyui-datagrid" style="width:700px;height:250px">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody id="studentData">
            <!-- Aquí se insertarán los datos con Ajax -->
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function () {
            // Evento del formulario de búsqueda
            $('#searchForm').submit(function () {
                var cedula = $('#cedula').val(); // Obtener el valor de la cédula

                // Configurar la URL de la API
                var apiUrl = 'http://localhost/soa/ModeloVistaControlador/controllers/apiRest.php';

                // Si la cédula no está vacía, agregarla a la URL
                if (cedula) {
                    apiUrl += '?cedula=' + encodeURIComponent(cedula);
                }

                // Realizar la solicitud Ajax
                $.ajax({
                    url: apiUrl,
                    type: 'GET',
                    success: function (response) {
                        try {
                            var estudiantes = JSON.parse(response); // Decodificar la respuesta JSON
                            var studentRows = '';

                            // Si se encuentran estudiantes, construir las filas de la tabla
                            if (estudiantes.length > 0) {
                                $.each(estudiantes, function (index, estudiante) {
                                    studentRows += '<tr>' +
                                        '<td>' + estudiante.cedula + '</td>' +
                                        '<td>' + estudiante.nombres + '</td>' +
                                        '<td>' + estudiante.apellidos + '</td>' +
                                        '<td>' + estudiante.direccion + '</td>' +
                                        '<td>' + estudiante.telefono + '</td>' +
                                        '</tr>';
                                });
                            } else if (estudiantes.cedula) {
                                // Si se devuelve un solo estudiante
                                studentRows += '<tr>' +
                                    '<td>' + estudiantes.cedula + '</td>' +
                                    '<td>' + estudiantes.nombres + '</td>' +
                                    '<td>' + estudiantes.apellidos + '</td>' +
                                    '<td>' + estudiantes.direccion + '</td>' +
                                    '<td>' + estudiantes.telefono + '</td>' +
                                    '</tr>';
                            } else {
                                // Si no se encontraron resultados
                                studentRows = '<tr><td colspan="5">No se encontraron resultados.</td></tr>';
                            }

                            // Insertar las filas en la tabla
                            $('#studentData').html(studentRows);
                        } catch (e) {
                            console.error('Error al procesar la respuesta:', e);
                            $('#studentData').html('<tr><td colspan="5">Error al procesar la respuesta del servidor.</td></tr>');
                        }
                    },
                    error: function () {
                        console.error('Error en la solicitud Ajax');
                        $('#studentData').html('<tr><td colspan="5">Error en la solicitud. Inténtalo de nuevo.</td></tr>');
                    }
                });
            });

            // Cargar todos los estudiantes cuando la página se carga inicialmente
            $('#searchForm').submit(); // Simula el envío del formulario vacío al cargar la página
        });
    </script>
</body>

</html>
