@extends('sample')

@section('title')Отображение студентов, изучающих дисциплину@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Отображение студентов, изучающих дисциплину</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($no_exist_subject)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная дисциплина не найдена!</h5>
        </div>
    @endif

    <form method="post" action="/ShowStudents/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <button style="width: 100px" type="submit" class="btn btn-primary">Показать</button>
    </form>

    @if($students)
    <div class="p-4 p-md-5 mb-4 rounded text-bg-light text-primary">
        @foreach($students as $stud)
            <li>{{$stud->name}}</li>
        @endforeach
    </div>
    @endif

    @if($no_exist_student)
        <div style="width: 580px; margin-top: 20px;" class="p-4 p-md-5 mb-4 rounded text-bg-light text-primary">
            <h5>Нет студентов, изучающих данную дисциплину!</h5>
        </div>
    @endif

    <div id="ShowStudents">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <v-row>
                        <v-col sm="4">
                            <v-alert
                                :value="no_exist_subject"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_subj">
                                Данная дисциплина не найдена!
                            </v-alert>
                            <v-alert
                                :value="no_exist_student"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_stud">
                                Нет студентов, изучающих данную дисциплину!
                            </v-alert>
                            <v-text-field
                                solo
                                label="Введите название дисциплины"
                                v-model = "subject"
                                :rules="subject_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-btn
                                @click="SendSubject">
                                Показать
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
                <br>
                <v-data-table
                    v-model="selected"
                    :headers="headers"
                    :items="students"
                    :single-select= true
                    item-key="name"
                    show-select
                    class="elevation-1">
                    <template v-slot:top>
                        <v-col>
                        <v-btn
                            @click="DeleteStudents"
                            small>
                            Удалить выбранное
                        </v-btn>
                        </v-col>
                    </template>
                </v-data-table>
            </v-main>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        new Vue({
            el: '#ShowStudents',
            vuetify: new Vuetify(),
            data(){
                return{
                    show_alert_subj: false,
                    show_alert_stud: false,
                    selected: [],
                    headers: [
                        {
                            text: 'ФИО студента',
                            align: 'start',
                            value: 'name',
                        },
                        { text: 'Предмет', value: 'subject' },
                        { text: 'Оценка', value: 'grade' },
                    ],
                    students: [],
                    subject:'',
                    no_exist_subject: false,
                    no_exist_student: false,
                    valid: false,
                    subject_rules: [
                        v => !!v || 'Дисциплина не должна быть пустой',
                        v => v.length <= 40 || 'Дисциплина не должна быть длиннее 40 символов',
                    ],
                }
            },
            methods:{
                SendSubject(){
                    let data = new FormData()
                    data.append('subject',this.subject)

                    fetch('ShowTable',{
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body: data
                    })

                        .then((response)=>{
                            return response.json()
                        })
                            .then((data)=>{
                                if(data[1]==1){
                                    this.no_exist_subject = true
                                    this.show_alert_subj = true
                                }
                                if(data[1]==2){
                                    this.no_exist_student = true
                                    this.students = []
                                    this.show_alert_stud = true
                                }
                                if(data[1]==0){
                                    array = Object.values(data[0])
                                    this.students = array
                                    this.show_alert_subj = false
                                    this.show_alert_stud = false
                                }
                            })
                },
                DeleteStudents(){
                    let data = new FormData()
                    let result = this.selected.map(({ name }) => name);
                    names = result[0]
                    console.log(names)
                    data.append('FIO',names)
                    fetch('SendDeleteFIO',{
                        method:'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    })
                        .then((response)=>{
                            return response.json()
                        })
                            .then((data)=>{
                                if(data){
                                    this.SendSubject();
                                }
                            })
                },
            }
        })
    </script>

@endsection


