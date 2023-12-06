@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Настройка {{ $setting->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Назад</a></li>

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">

            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header">

                        <h3 class="card-title">Опции</h3>

                        <div class="card-tools">
                            <!-- This will cause the card to maximize when clicked -->
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Код</th>

                                    <th>Статус</th>
                                    <th>Описание</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($setting->options['42']))
                                    <tr>
                                        <td>42</td>

                                        <td>{{ $setting->options['42'] }}</td>
                                        <td>[CURLOPT_HEADER]</td>
                                    </tr>
                                @endif

                                @if (isset($setting->options['101']))
                                    <tr>
                                        <td>101</td>
                                        <td>
                                            {{ $setting->options['101'] }}
                                        </td>
                                        <td>[CURLOPT_PROTOCOLS]</td>
                                    </tr>
                                @endif

                                @if (isset($setting->options['10004']))
                                    <tr>
                                        <td>10004</td>

                                        <td>{{ $setting->options['10004'] }}</td>
                                        <td>[CURLOPT_PROXY]</td>
                                    </tr>
                                @endif

                                @if (isset($setting->options['19913']))
                                    <tr>
                                        <td>19913</td>
                                        <td>{{ $setting->options['19913'] }}</td>
                                        <td>[CURLOPT_RETURNTRANSFER]</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>


                    </div>
                    <div class="card-footer">

                    </div>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-header">

                        <h3 class="card-title">Заголовки [CURLOPT_HTTPHEADER]</h3>

                        <div class="card-tools">
                            <!-- This will cause the card to maximize when clicked -->
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            {{-- <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Task</th>
                                    <th>Progress</th>
                                    <th style="width: 40px">Label</th>
                                </tr>
                            </thead> --}}
                            <tbody>
                                @foreach ($setting->options['10023'] as $header)
                                    <tr>
                                        <td>{{ $header }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>



                    </div>
                    <div class="card-footer">

                    </div>
                </div>




            </div>







        </section>
    </div>
@endsection
