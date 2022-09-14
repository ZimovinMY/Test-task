@extends('sample')

@section('title')Проставление оценки студенту за дисциплину@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма проставления оценки студенту за дисциплину</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($no_exist_student)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данный студент не найден!</h5>
        </div>
    @endif

    @if($no_exist_subject)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная дисциплина не найдена!</h5>
        </div>
    @endif

    @if($no_conn_grade)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Студент не изучает данную дисциплину!</h5>
        </div>
    @endif

    <form method="post" action="/GradingStudent/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="student" id="student" placeholder="Введите ФИО студента" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="number" min="0" max="5" name="grade" id="grade" placeholder="Введите оценку" class="form-control"><br>
        <button style="width: 100px" type="submit" class="btn btn-primary">Добавить</button>
    </form>
    <br>
    <div id="GradingStudent">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <h4 style="margin-left: 15px" class="text-primary"><p>Форма проставления оценки студенту за дисциплину</p></h4>
                    <v-row>
                        <v-col sm="4">
                            <v-alert
                                :value="no_stud_grading"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_no_stud">
                                Данный студент не найден!
                            </v-alert>
                            <v-alert
                                :value="no_subj_grading"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_no_subj">
                                Данная дисциплина не найдена!
                            </v-alert>
                            <v-alert
                                :value="no_conn_grading"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_no_conn">
                                Студент не изучает данную дисциплину!
                            </v-alert>
                            <v-text-field
                                solo
                                label="Введите ФИО студента"
                                v-model = "FIO"
                                :rules="FIO_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-text-field
                                solo
                                label="Введите название дисциплины"
                                v-model = "subject"
                                :rules="subject_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-select
                                solo
                                label="Выберите номер КМ"
                                :items = "КМ_num"
                                v-model = "selected_KM_num"
                                :rules="KM_num_rules">
                            </v-select>
                            <v-select
                                solo
                                label="Выберите оценку"
                                :items = "grade"
                                v-model = "selected_grade"
                                :rules="grade_rules">
                            </v-select>
                            <v-btn
                                @click="StudGrading">
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
            el: '#GradingStudent',
            vuetify: new Vuetify(),
            data(){
                return{
                    FIO:'',
                    subject:'',
                    selected_KM_num:'',
                    selected_grade:'',
                    no_stud_grading: false,
                    no_subj_grading: false,
                    no_conn_grading: false,
                    show_alert_no_stud: false,
                    show_alert_no_subj: false,
                    show_alert_no_conn: false,
                    valid: false,
                    FIO_rules: [
                        v => !!v || 'ФИО не должно быть пустым',
                        v => v.length <= 40 || 'ФИО не должно быть длиннее 40 символов',
                    ],
                    subject_rules: [
                        v => !!v || 'Дисциплина не должна быть пустой',
                        v => v.length <= 40 || 'Дисциплина не должна быть длиннее 40 символов',
                    ],
                    KM_num_rules: [
                        v => !!v || 'Номер КМ не должен быть пустым',
                    ],
                    grade_rules: [
                        v => !!v || 'Оценка не должна быть пустой',
                    ],
                    КМ_num:[1,2,3,4],
                    grade:[0,1,2,3,4,5],
                }
            },
            methods:{
                StudGrading(){
                    if (this.FIO && this.subject && this.selected_KM_num && this.selected_grade && this.FIO.length <= 40 && this.subject.length <= 40){
                        let data = new FormData()
                        data.append('FIO',this.FIO)
                        data.append('subject',this.subject)
                        data.append('KM_num',this.selected_KM_num)
                        data.append('grade',this.selected_grade)

                        fetch('GradingStud',{
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            body: data
                        })

                            .then((response)=>{
                                return response.json()
                            })
                            .then((data)=>{
                                if(data==1){
                                    this.no_stud_grading = true
                                    this.show_alert_no_stud = true
                                }
                                if(data==2){
                                    this.no_subj_grading = true
                                    this.show_alert_no_subj = true
                                }
                                if(data==3){
                                    this.no_conn_grading = true
                                    this.show_alert_no_conn = true
                                }
                                if(data==0){
                                    window.location.replace("/")
                                }
                            })
                    }

                }
            }
        })
    </script>
@endsection
