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

                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ URL::route('cp.users.index') }}"
                                   class="btn btn-info btn-sm pull-left">
                                    Назад
                                </a>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>BTC:</h4>
                                <p>
                                <strong>Адрес кошелька:</strong> {{  $user->wallet('btc')->address ?? ''  }}<br>
                                <strong>Баланс:</strong> {{ $user->wallet('btc')->balance ?? '' }}
                            </p>
                            <h4>ETH:</h4>
                            <p>
                                <strong>Адрес кошелька:</strong> {{ $user->wallet('eth')->address ?? '' }}<br>
                                <strong>Баланс:</strong> {{ $user->wallet('eth')->balance ?? '' }}
                            </p>
                            <h4>Последний логин:</h4>
                            <strong>Дата и время:</strong> {{ $user->lastLogin->created_at ?? '' }}<br>
                            <strong>IP:</strong> {{ $user->lastLogin->location->ip ?? '' }}<br>
                            <strong>Страна и город:</strong> {{ $user->lastLogin->location->country ?? '' }} {{ $user->lastLogin->location->city ?? '' }}
                        </div>
                    </div>

                    <br>
                    <h3>История транзакций</h3>

                    <div class="table-responsive">

                        <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>Действие</th>
                                <th>Платеж</th>
                                <th>Валюта</th>
                                <th>Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <h3>История покупки билетов</h3>

                        <table id="itemList2" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>ID кейса</th>
                                <th>SEED-фраза</th>
                                <th>Стоимость билета</th>
                                <th>Дата и время</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

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
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ URL::route('cp.datatable.transaction_history', ['user_id' => $user->id]) }}'
                },
                columns: [
                    {data: 'transaction_type', name: 'transaction_type', searchable: false},
                    {data: 'amount', name: 'amount'},
                    {data: 'address_type', name: 'address_type'},
                    {data: 'created_at', name: 'created_at'},
                ],
            });

            /* BASIC ;*/
            var responsiveHelper_dt_basic2 = undefined;

            var breakpointDefinition2 = {
                tablet: 1024,
            };

            $('#itemList2').dataTable({
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
                    if (!responsiveHelper_dt_basic2) {
                        responsiveHelper_dt_basic2 = new ResponsiveDatatablesHelper($('#itemList2'), breakpointDefinition2);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic2.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic2.respond();
                },
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('id', 'rowid_' + data['id']);
                },
                aaSorting: [[3, 'asc']],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ URL::route('cp.datatable.box_payment_history', ['user_id' => $user->id]) }}'
                },
                columns: [
                    {data: 'box_id', name: 'box_id'},
                    {data: 'seed', name: 'seed'},
                    {data: 'payment_usd', name: 'payment_usd'},
                    {data: 'created_at', name: 'created_at'},
                ],
            });
        })

    </script>

@endsection
