@extends('sample')

@section('title')Привязка студента к дисциплине@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма привязки студента к дисциплине</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($no_stud_binding)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данный студент не найден!</h5>
        </div>
    @endif

    @if($no_subj_binding)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная дисциплина не найдена!</h5>
        </div>
    @endif

    @if($exist_binding)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная запись уже существует!</h5>
        </div>
    @endif

    <form method="post" action="/BindingStudent/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="text" name="student" id="student" placeholder="Введите ФИО студента" class="form-control"><br>
        <button style="width: 100px" type="submit" class="btn btn-primary">Добавить</button>
    </form>



    <div id="BindingStudent">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <v-row>
                        <v-col sm="4">
                            <v-alert
                                :value="no_stud_binding"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_no_stud">
                                Данный студент не найден!
                            </v-alert>
                            <v-alert
                                :value="no_subj_binding"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_no_subj">
                                Данная дисциплина не найдена!
                            </v-alert>
                            <v-alert
                                :value="having_binding"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_having_binding">
                                Данная запись уже существует!
                            </v-alert>
                            <v-text-field
                                solo
                                label="Введите название предмета"
                                v-model = "subject"
                                :rules="subject_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-text-field
                                solo
                                label="Введите ФИО студента"
                                v-model = "FIO"
                                :rules="FIO_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-btn
                                @click="StudBinding">
                                Добавить
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-main>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        new Vue({
            el: '#BindingStudent',
            vuetify: new Vuetify(),
            data(){
                return{
                    FIO:'',
                    subject:'',
                    no_stud_binding: false,
                    no_subj_binding: false,
                    having_binding: false,
                    show_alert_no_stud: false,
                    show_alert_no_subj: false,
                    show_alert_having_binding: false,
                    valid: false,
                    FIO_rules: [
                        v => !!v || 'ФИО не должно быть пустым',
                        v => v.length <= 40 || 'ФИО не должно быть длиннее 40 символов',
                    ],
                    subject_rules: [
                        v => !!v || 'Дисциплина не должна быть пустой',
                        v => v.length <= 40 || 'Дисциплина не должна быть длиннее 40 символов',
                    ],
                }
            },
            methods:{
                StudBinding(){
                    let data = new FormData()
                    data.append('FIO',this.FIO)
                    data.append('subject',this.subject)
                    fetch('BindingStudToSubj',{
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body: data
                    })

                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                            if(data==1){
                                this.no_subj_binding = true
                                this.show_alert_no_subj = true
                            }
                            if(data==2){
                                this.no_stud_binding = true
                                this.show_alert_no_stud = true
                            }
                            if(data==3){
                                this.having_binding = true
                                this.show_alert_having_binding = true
                            }
                            if(data==0){
                                window.location.replace("/")
                            }
                        })
                }
            }
        })
    </script>
@endsection
