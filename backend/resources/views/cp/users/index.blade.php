@extends('cp.app')

@section('title', $title)

@section('css')

@endsection

@section('content')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <div class="table-responsive">

                        <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th width="10px">
                                <span>
                                    <input type="checkbox"  title="Отметить все/Снять отметку у всех" id="checkAll">
                                </span>
                                </th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Кол-во купленных билетов</th>
                                <th>Сумма потраченных денег</th>
                                <th>Текущий баланс</th>
                                <th>Кол-во открытых кейсов</th>
                                <th>Заблокирован</th>
                                <th>Зарегистрирован</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-sm-12 padding-bottom-10">
                                <div class="form-inline">
                                    <div class="control-group">

                                        {!! Form::select('action',[
                                        '1' => 'Заблокировать',
                                        '0' => 'Разблокировать',
                                        ],null,['class' => 'span3 form-control', 'id' => 'select_action','placeholder' => '-- выберите действие --']) !!}

                                        <span class="help-inline">
                                       {!! Form::submit('Применить', ['class' => 'btn btn-success', 'disabled' => "", 'id' => 'apply']) !!}
                                    </span>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function () {

            $("#apply").click(function (event) {
                var idSelect = $('#select_action').val();

                if (idSelect == '') {
                    event.preventDefault();
                    swal({
                        title: "Error",
                        text: "Выберите действие",
                        type: "error",
                        showCancelButton: false,
                        cancelButtonText: "Отменить",
                        confirmButtonColor: "#DD6B55",
                        closeOnConfirm: false
                    });
                }
            });

            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
                countChecked();
            });

            $("#checkAll").on('change',function () {
                countChecked();
            });

            $("#itemList").on('change', 'input.check', function () {
                countChecked();
            });

            pageSetUp();

            /* // DOM Position key index //

            l - Length changing (dropdown)
            f - Filtering input (search)
            t - The Table! (datatable)
            i - Information (records)
            p - Pagination (paging)
            r - pRocessing
            < and > - div elements
            <"#id" and > - div with an id
            <"class" and > - div with a class
            <"#id.class" and > - div with an id and class

            Also see: http://legacy.datatables.net/usage/features
            */

            /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;

            var breakpointDefinition = {
                tablet: 1024,
            };

            $('#itemList').dataTable({
                "sDom": "flrtip",
                "autoWidth": true,
                "oLanguage": {
                    "sLengthMenu": "Отображено _MENU_ записей на страницу",
                    "sZeroRecords": "Ничего не найдено - извините",
                    "sInfo": "Показано с _START_ по _END_ из _TOTAL_ записей",
                    "sInfoEmpty": "Показано с 0 по 0 из 0 записей",
                    "sInfoFiltered": "(отфильтровано  _MAX_ всего записей)",
                    "oPaginate": {
                        "sFirst": "Первая",
                        "sLast": "Посл.",
                        "sNext": "След.",
                        "sPrevious": "Пред.",
                    },
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#itemList'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                },
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('id', 'rowid_' + data['id']);
                    if (data['is_ban'] == 1) $(row).attr('class', 'danger');
                },
                aaSorting: [[1, 'asc']],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ URL::route('cp.datatable.users') }}'
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {
                        data: 'number_tickets_purchased',
                        name: 'number_tickets_purchased',
                        searchable: false
                    },
                    {data: 'amount_money_spent', name: 'amount_money_spent', searchable: false},
                    {data: 'сurrent_balance', name: 'сurrent_balance', orderable: false, searchable: false},
                    {data: 'number_open_cases', name: 'number_open_cases', searchable: false},
                    {data: 'is_ban', name: 'is_ban', searchable: false},
                    {data: 'created_at', name: 'created_at'},
                ],
            });
        })

        function countChecked()
        {
            if ($('.check').is(':checked'))
                $('#apply').attr('disabled',false);
            else
                $('#apply').attr('disabled',true);
        }

    </script>

@endsection
