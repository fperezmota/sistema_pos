    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inventario / Productos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Inventario / Productos</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- ROW PARA CRITERIOS DE BUSQUEDA -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool text-danger" id="btnLimpiarBusqueda">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div> <!-- ./ end card-tools -->
                        </div> <!-- ./ end card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 d-lg-flex">
                                    <div style="width: 20%;" class="form-floating mx-2">
                                        <input type="text" class="form-control" id="iptCodigoBarras" data-index="2">
                                        <label for="iptCodigoBarras">Código de Barras</label>
                                    </div>
                                    <div style="width: 20%;" class="form-floating mx-2">
                                        <input type="text" class="form-control" id="iptCategoria" data-index="4">
                                        <label for="iptCategoria">Categoría</label>
                                    </div>
                                    <div style="width: 20%;" class="form-floating mx-2">
                                        <input type="text" class="form-control" id="iptProducto" data-index="5">
                                        <label for="iptProducto">Producto</label>
                                    </div>
                                    <div style="width: 20%;" class="form-floating mx-2">
                                        <input type="text" class="form-control" id="iptPrecioDesde">
                                        <label for="iptPrecioDesde">$ Desde</label>
                                    </div>
                                    <div style="width: 20%;" class="form-floating mx-2">
                                        <input type="text" class="form-control" id="iptPrecioHasta">
                                        <label for="iptPrecioHasta">$ Hasta</label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- ./ end card-body -->
                    </div>
                </div>
            </div>
            <!-- FIN CRITERIOS DE BUSQUEDA -->

            <div class="row">
                <div class="col-lg-12">
                    <table id="tbl_productos" class="table table-striped w-100 shadow">
                        <thead class="bg-info">
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Código</th>
                                <th>Id Cat.</th>
                                <th>Categoría</th>
                                <th>Producto</th>
                                <th>$ Compra</th>
                                <th>$ Venta</th>
                                <th>Util.</th>
                                <th>Stock</th>
                                <th>Stock Min.</th>
                                <th>Ventas</th>
                                <th>F. Creac.</th>
                                <th>F. Actual.</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-small">
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <script>
        $(document).ready(function() {
            var table;

            $.ajax({
                url: "ajax/productos.ajax.php",
                type: "POST",
                data: {
                    'accion': 1 //1: Listar productos
                },
                dataType: 'json',
                success: function(respuesta) {
                    console.log("respuesta", respuesta);
                }
            });
            // Carga del listado con el plugin datatable JS
            table = $("#tbl_productos").DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        text: 'Agregar Producto',
                        className: 'addNewRecord',
                        action: function(e, dt, node, config) {
                            //Evento para levantar la ventana modal
                        }
                    },
                    'excel', 'print', 'pageLength'
                ],
                pageLength: [5, 10, 15, 30, 50, 100],
                pageLength: 10,
                ajax: {
                    url: "ajax/productos.ajax.php",
                    dataSrc: '',
                    type: "POST",
                    data: {
                        'accion': 1
                    }, //1: Listar productos
                },
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                        className: 'control'
                    },
                    {
                        targets: 1,
                        visible: false,
                    },
                    {
                        targets: 3,
                        visible: false,
                    },
                    {
                        targets: 9,
                        createdCell: function(td, cellData, rowData, row, col) {
                            if (parseFloat(rowData[9]) <= parseFloat(rowData[10])) {
                                $(td).parent().css('background', '#FF5733')
                            }
                        }
                    },
                    {
                        targets: 11,
                        visible: false,
                    },
                    {
                        targets: 12,
                        visible: false,
                    },
                    {
                        targets: 13,
                        visible: false,
                    },
                    {
                        targets: 14,
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return "<center>" +
                                "<span class='btnEditarProducto text-primary px-2' style='cursor:pointer'>" +
                                "<i class='fas fa-pencil-alt fs-5'></i>" +
                                "</span>" +
                                "<span class='btnAumentarStock text-success px-2' style='cursor:pointer'>" +
                                "<i class='fas fa-plus-circle fs-5'></i>" +
                                "</span>" +
                                "<span class='btnDisminuirStock text-warning px-2' style='cursor:pointer'>" +
                                "<i class='fas fa-minus-circle fs-5'></i>" +
                                "</span>" +
                                "<span class='btnEliminarProducto text-danger px-2' style='cursor:pointer'>" +
                                "<i class='fas fa-trash-alt fs-5'></i>" +
                                "</span>" +
                                "</center>"
                        }
                    }
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });
            //EVENTOS PARA CRITERIOS DE BÚSQUEDA
            $("#iptCodigoBarras").keyup(function() {
                table.column($(this).data('index')).search(this.value).draw();
            })
            $("#iptCategoria").keyup(function() {
                table.column($(this).data('index')).search(this.value).draw();
            })
            $("#iptProducto").keyup(function() {
                table.column($(this).data('index')).search(this.value).draw();
            })

            $("#iptPrecioDesde, #iptPrecioHasta").keyup(function() {
                table.draw();
            })

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var precioDesde = parseFloat($("#iptPrecioDesde").val());
                    var precioHasta = parseFloat($("#iptPrecioHasta").val());

                    var colVenta = parseFloat(data[7]);

                    if ((isNaN(precioDesde) && isNaN(precioHasta) ||
                            (isNaN(precioDesde) && colVenta <= precioHasta) ||
                            (precioDesde <= colVenta && isNaN(precioHasta)) ||
                            (precioDesde <= colVenta && colVenta <= precioHasta)
                        )) {
                        return true;
                    }
                    return false;
                }
            )

            $("#btnLimpiarBusqueda").on('click', function() {
                $("#iptCodigoBarras").val('')
                $("#iptCategoria").val('')
                $("#iptProducto").val('')
                $("#iptPrecioDesde").val('')
                $("#iptPrecioHasta").val('')

                table.search('').columns().search('').draw();
            })
        })
    </script>