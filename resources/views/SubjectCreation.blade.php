@extends('sample')

@section('title')Создание дисциплины@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма создания дисциплины</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($exist_subject_creation)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная запись уже существует!</h5>
        </div>
    @endif

    <form method="post" action="/SubjectCreation/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <button style="width: 85px" type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection
