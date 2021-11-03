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

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>На сегодняшний день</th>
                                <th>Вчера</th>
                                <th>Последние 7 дней</th>
                                <th>За месяц</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$today_payment['usd']}} {{\App\Helpers\SettingsHelpers::getSetting('currency')}}</td>
                                <td>{{$yesterday_payment['usd']}} {{\App\Helpers\SettingsHelpers::getSetting('currency')}}</td>
                                <td>{{$week_payment['usd']}} {{\App\Helpers\SettingsHelpers::getSetting('currency')}}</td>
                                <td>{{$month_payment['usd']}} {{\App\Helpers\SettingsHelpers::getSetting('currency')}}</td>
                            </tr>
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



@endsection
