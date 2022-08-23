@extends('sample')

@section('title')Главная страница@endsection

@section('content')
    <div class="p-4 p-md-5 mb-4 rounded text-bg-light text-primary">
        <div class="col-md-6 px-0">
            <h5><b>Опции администратора</b></h5>
        <ul class="nav flex-column">
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/StudentCreation" class="nav-link p-0 text-dark"><b>Создание студента</b></a></li>
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/SubjectCreation" class="nav-link p-0 text-dark"><b>Создание дисциплины</b></a></li>
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/BindingStudent" class="nav-link p-0 text-dark"><b>Привязка студента к дисциплине</b></a></li>
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/ShowStudents" class="nav-link p-0 text-dark"><b>Отображение студентов, изучающих дисциплину</b></a></li>
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/GradingStudent" class="nav-link p-0 text-dark"><b>Проставление оценки студенту за дисциплину</b></a></li>
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/DeleteStudent" class="nav-link p-0 text-dark"><b>Удаление студента</b></a></li>
            <li style="margin-left: 15px" class="nav-item mb-2"><a href="/DeleteSubject" class="nav-link p-0 text-dark"><b>Удаление дисциплины</b></a></li>
        </ul>
        </div>
    </div>
@endsection
