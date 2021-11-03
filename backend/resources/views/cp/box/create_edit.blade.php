@extends('cp.app')

@section('title', $title)

@section('css')


@endsection

@section('content')

    @if ($errors->has('address'))
        <div class="alert alert-danger fade in">
            <button class="close" data-dismiss="alert">
                ×
            </button>
            <i class="fa-fw fa fa-check"></i>
            {{ $errors->first('address') }}
        </div>
    @endif

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"

                -->

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">

                        {!! Form::open(['url' => isset($row) ? URL::route('cp.box.update') : URL::route('cp.box.store'), 'method' => isset($row) ? 'put' : 'post']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <fieldset>

                            <legend>
                                *-обязательные поля
                            </legend>

                            @if (isset($row))
                                <div class="form-group">

                                    {!! Form::label('address', 'Адрес') !!}

                                    {!! Form::text('address', $row->address, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                                </div>
                            @endif

                            <div class="form-group">

                                {!! Form::label('seed[]', 'SEED-фраза*') !!}

                                {!! Form::select('seed[]', $seed_options, old('seed[]', isset($row) ? $row->seed : null), ['multiple' => 'multiple', 'style' => "width:100%", 'id' => 'seed', 'class' => 'select2']) !!}

                                @if ($errors->has('seed'))
                                    <p class="text-danger">{{ $errors->first('seed') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('starting_bank', 'Начальный банк*') !!} (Сумма свободных средств: <span id="total_balance">0.0</span>)

                                {!! Form::text('starting_bank', old('starting_bank', isset($row) ? $row->starting_bank : ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                @if ($errors->has('starting_bank'))
                                    <p class="text-danger">{{ $errors->first('starting_bank') }}</p>
                                @endif

                            </div>

                            <div class="form-group">

                                {!! Form::label('price', 'Цена билета*') !!}

                                {!! Form::text('price', old('price', isset($row) ? $row->price : ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                @if ($errors->has('price'))
                                    <p class="text-danger">{{ $errors->first('price') }}</p>
                                @endif

                            </div>

                            @if (!isset($row))
                            <div class="form-group">

                                {!! Form::label('cryptocurrency', 'Криптовалюта*') !!}

                                {!! Form::select('cryptocurrency', $currency, old('cryptocurrency', null), ['placeholder' => 'выберите', 'class' => 'form-control', 'id' => 'cryptocurrency']) !!}

                                @if ($errors->has('cryptocurrency'))
                                    <p class="text-danger">{{ $errors->first('cryptocurrency') }}</p>
                                @endif

                            </div>
                            @endif

                            <div class="form-group">
                                 <div class="radio">
                                      <label>
                                          {!! Form::radio('box_type', 0, (isset($row) && $row->box_type == 0) or !isset($row)) !!} Hard-box
                                      </label>
                                 </div>
                                 <div class="radio">
                                      <label>
                                          {!! Form::radio('box_type', 1, old('box_type', isset($row) && $row->box_type == 1)) !!} Easy-box
                                      </label>
                                  </div>
                                  <div class="radio">
                                       <label>
                                           {!! Form::radio('box_type', 2, old('box_type', isset($row) && $row->box_type == 2)) !!} Quest-box
                                       </label>
                                  </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('hint_id[]', 'Подсказки*') !!}

                                {!! Form::select('hint_id[]', $options, old('hint_id', isset($row) ? $boxHintId : null), ['multiple' => 'multiple', 'placeholder' => 'выберите', 'class' => 'form-control custom-scroll']) !!}

                                @if ($errors->has('hint_id'))
                                    <span class="text-danger">{{ $errors->first('hint_id') }}</span>
                                @endif

                            </div>

                        </fieldset>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn btn-default" href="{{ URL::route('cp.box.index') }}">
                                        Назад
                                    </a>
                                    <button type="submit" class="btn btn-primary button-apply">
                                        {{ isset($row) ? 'Изменить' : 'Добавить' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                    <!-- end widget div -->
                </div>
                <!-- end widget -->
            </div>
        </article>
    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function () {

            pageSetUp();

              $('#cryptocurrency').on('change', function () {
                  var Cryptocurrency = $(this).val();

                  $.ajax({
                      url: '{{ URL::route('api.frontend.total_balance') }}',
                      type: "POST",
                      dataType: "json",
                      data: {
                          cryptocurrency: Cryptocurrency,
                      },
                      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                      success: function (data) {
                          $("#total_balance").text(data.balance);
                      },
                  });
            });
        })

    </script>>


@endsection
