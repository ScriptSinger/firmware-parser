@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Список прошивок</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Главная</a></li>
                            <li class="breadcrumb-item active">Список прошивок</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Список</h3> --}}
                        <div class="card-tools">
                            <!-- This will cause the card to maximize when clicked -->
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($firmwares))
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>id пути</th>
                                        <th>id прошивки</th>
                                        <th>Путь</th>
                                        <th>Название</th>
                                        <th>Размер</th>
                                        <th>Расширение</th>
                                        <th>Платформа</th>
                                        <th>CRC32</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($firmwares as $firmware)
                                        <tr>

                                            <td>{{ $firmware->path->id }}</td>
                                            <td>{{ $firmware->id }}</td>
                                            <td>{{ $firmware->path->path }}</td>
                                            <td>
                                                <a href="{{ route('firmwares.show', ['firmware' => $firmware->id]) }}">
                                                    {{ $firmware->title }}</a>
                                            </td>
                                            <td>
                                                {{ $firmware->size }}
                                            </td>
                                            <td>
                                                {{ $firmware->extension }}
                                            </td>
                                            <td>
                                                {{ $firmware->platform }}
                                            </td>
                                            <td>
                                                {{ $firmware->crc32 }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="card-footer">{{ $firmwares->links('pagination::bootstrap-4') }}</div>
                </div>
        </section>
    </div>
@endsection
