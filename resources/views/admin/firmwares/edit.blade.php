@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Редактировать статью</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Назад</a></li>
                            <li class="breadcrumb-item active">Редактировать статью</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Редактирование «{{ $setting->name }}»</h3>
                    <div class="card-tools">
                        <!-- This will cause the card to maximize when clicked -->
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                class="fas fa-expand"></i></button>
                    </div>
                </div>
                <form method="POST" action="{{ route('settings.update', ['setting' => $setting->id]) }}" id="quickForm"
                    novalidate="novalidate">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="InputText">Название</label>
                            <input type="text" name="name" class="form-control @error('title') is-invalid @enderror"
                                id="InputTextsetting" value="{{ $setting->options['42'] }}"
                                aria-describedby="InputText-error" aria-invalid="true">
                            <span id="InputText-error" class="error invalid-feedback">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>

        </section>
    </div>
@endsection
