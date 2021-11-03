@extends('cp.app')

@section('title', $title)

@section('css')


@endsection

@section('content')

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

                        {!! Form::open(['url' => isset($row) ? URL::route('cp.hints.update') : URL::route('cp.hints.store'), 'files' => true, 'method' => isset($row) ? 'put' : 'post', 'class' => "smart-form"]) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        {!! Form::hidden('isset_pic', isset($row) && $row->icon ? $row->icon : null) !!}

                        <header>
                            *-обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('icon', 'Иконка', ['class' => 'label']) !!}

                                <div class="input input-file">
                                    <span class="button">{!! Form::file('icon', ['onchange' => "this.parentNode.nextSibling.value = this.value"]) !!} Выберите </span><input type="text" placeholder="Выберите иконку" readonly="">
                                </div>

                                @if ($errors->has('icon'))
                                    <p class="text-danger">{{ $errors->first('icon') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('name', 'Заголовок*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('name', isset($row) ? $row->name : ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('price', 'Стоимость*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('price', old('price', isset($row) ? $row->price : ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('price'))
                                    <p class="text-danger">{{ $errors->first('price') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('users_for_open', 'Кол-во пользователей*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('users_for_open', old('users_for_open', isset($row) ? $row->users_for_open : ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('users_for_open'))
                                    <p class="text-danger">{{ $errors->first('users_for_open') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('description', 'Описание', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('description', old('description', isset($row) ? $row->description : null), [ 'rows' => 3, 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif

                            </section>

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default" href="{{ URL::route('cp.hints.index') }}">
                                Назад
                            </a>
                        </footer>

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


@endsection
