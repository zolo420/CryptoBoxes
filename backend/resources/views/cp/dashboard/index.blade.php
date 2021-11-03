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
                    <div class="row">
                        <div class="text">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="well text-center connect">
                                    <i class="fa fa-cubes fa-3x"></i>
                                    <h5><strong>{{ $open_box }}</strong></h5>
                                    <span class="font-md">Кол-во открытых кейсов</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="well text-center connect">
                                    <i class="fa fa-ticket fa-3x"></i>
                                    <h5><strong>0</strong></h5>
                                    <span class="font-md">Кол-во купленных биллетов</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="well text-center connect">
                                    <i class="fa fa-users fa-3x"></i>
                                    <h5><strong>{{ $users }}</strong></h5>
                                    <span class="font-md">Кол-во пользователей</span>
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


@endsection
