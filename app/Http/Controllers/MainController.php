<?php

namespace App\Http\Controllers;

use App\IDStudModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class MainController extends Controller
{
    public function main() {
        return view('main');
    }

    public function StudentCreation() {
        return view('StudentCreation', ['exist_student_creation' => false]);
    }

    public function StudentCreation_check(Request $stud_request)
    {
        $valid = $stud_request->validate([
            'student' => 'required|min:4|max:50',
            'year' => 'required|min:4|max:10'
        ]);

        $new_student = $stud_request-> input('student');
        $new_year = $stud_request-> input('year');

        $value = DB::table('i_d_stud_models')->where('name', $new_student)->count();
        if ($value === 0) {
            DB::table('i_d_stud_models')->insert(['name'=>$new_student,'year'=>$new_year]);
            return view('main');
        }
        else{
            return view('StudentCreation', ['exist_student_creation' => true]);
        }
    }

    public function SubjectCreation() {
        return view('SubjectCreation', ['exist_subject_creation' => false]);
    }

    public function SubjectCreation_check(Request $subj_request) {
        $valid = $subj_request->validate([
            'subject' => 'required|min:4|max:50'
        ]);

        $new_subject = $subj_request-> input('subject');

        $value = DB::table('i_d_subjects')->where('subject', $new_subject)->count();
        if ($value === 0) {
            DB::table('i_d_subjects')->insert(['subject'=>$new_subject]);
            return view('main');
        }
        else{
            return view('SubjectCreation', ['exist_subject_creation' => true]);
        }
    }

    public function BindingStudent() {
        return view('BindingStudent');
    }

    public function ShowStudents() {
        return view('ShowStudents');
    }

    public function GradingStudent() {
        return view('GradingStudent',['no_conn_grade' => false, 'no_exist_subject' => false, 'no_exist_student' => false]);
    }

    public function GradingStudent_check(Request $grade_request) {
        $valid = $grade_request->validate([
            'student' => 'required|min:4|max:50',
            'subject' => 'required|min:4|max:50',
            'grade' => 'required'
        ]);

        $grad_stud = $grade_request-> input('student');
        $grad_subj = $grade_request-> input('subject');
        $grad_grade = $grade_request-> input('grade');
        $id_stud = DB::table('i_d_stud_models')->where('name', $grad_stud)->value('id');
        if ($id_stud === null) {
            return view('GradingStudent',['no_conn_grade' => false, 'no_exist_subject' => false, 'no_exist_student' => true]);
        }
        $id_subj = DB::table('i_d_subjects')->where('subject', $grad_subj)->value('id');
        if ($id_subj === null) {
            return view('GradingStudent',['no_conn_grade' => false, 'no_exist_subject' => true, 'no_exist_student' => false]);
        }
        $value = DB::table('stud_grades')->where('id_subject', $id_subj)->where('id_student', $id_stud)->count();
        if($value === 0) {
            return view('GradingStudent',['no_conn_grade' => true, 'no_exist_subject' => false, 'no_exist_student' => false]);
        }
        else{
            DB::table('stud_grades')->where('id_subject', $id_subj)->where('id_student', $id_stud)->update(['grade' => $grad_grade]);
            return view('main');
        }
    }


    public function DeleteStudent() {
        return view('DeleteStudent',['no_exist_student_delete' => false]);
    }

    public function DeleteStudent_check(Request $del_req_stud)
    {
        $valid = $del_req_stud->validate([
            'student' => 'required|min:4|max:50'
        ]);

        $del_stud = $del_req_stud-> input('student');

        $value = DB::table('i_d_stud_models')->where('name', $del_stud)->value('id');
        if ($value === null) {
            return view('DeleteStudent', ['no_exist_student_delete' => true]);
        }
        else{
            DB::table('i_d_stud_models')->where('name', '=', $del_stud)->delete();
            DB::table('stud_grades')->where('id_student', '=', $value)->delete();
            return view('main');
        }
    }

    public function DeleteSubject() {
        return view('DeleteSubject',['no_exist_subject_delete' => false]);
    }

    public function DeleteSubject_check(Request $del_req_subj)
    {
        $valid = $del_req_subj->validate([
            'subject' => 'required|min:4|max:50'
        ]);

        $del_subj = $del_req_subj-> input('subject');

        $value = DB::table('i_d_subjects')->where('subject', $del_subj)->value('id');
        if ($value === null) {
            return view('DeleteSubject', ['no_exist_subject_delete' => true]);
        }
        else{
            DB::table('i_d_subjects')->where('subject', '=', $del_subj)->delete();
            DB::table('stud_grades')->where('id_subject', '=', $value)->delete();
            return view('main');
        }
    }

    ///////vue

    public function SendCreationFIO(request $request)
    {
        $new_student = $request-> input('FIO');
        $new_year = $request-> input('year');

        $value = DB::table('i_d_stud_models')->where('name', $new_student)->count();
        if ($value === 0) {
            DB::table('i_d_stud_models')->insert(['name'=>$new_student,'year'=>$new_year]);
            $answer = 1;
            return json_encode($answer);
        }
        else{
            $answer = 0;
            return json_encode($answer);
        }
    }

    public function SendDeleteID(Request $del_req_stud)
    {
        $del_id = $del_req_stud-> input('id_student');

        $value = DB::table('i_d_stud_models')->where('id', $del_id)->value('id');
        if ($value === null) {
            $answer = 0;
            return json_encode($answer);
        }
        else{
            DB::table('i_d_stud_models')->where('id', '=', $del_id)->delete();
            DB::table('stud_grades')->where('id_student', '=', $del_id)->delete();
            $answer = 1;
            return json_encode($answer);
        }
    }

    public function BindingStudToSubj(Request $request_binding)
    {
        $stud_bind = $request_binding->input('FIO');
        $subj_bind = $request_binding->input('subject');

        $id_subj = DB::table('i_d_subjects')->where('subject', $subj_bind)->value('id');
        if($id_subj === null){
            $answer = 1;
            return json_encode($answer);
        }
        $id_stud = DB::table('i_d_stud_models')->where('name', $stud_bind)->value('id');
        if($id_stud === null){
            $answer = 2;
            return json_encode($answer);
        }
        $value = DB::table('stud_grades')->where('id_student', $id_stud)->where('id_subject', $id_subj)->count();
        if ($value === 0) {
            for ($KM_num = 1; $KM_num <5; $KM_num++){
                DB::table('stud_grades')->insert(['id_student'=>$id_stud,'id_subject'=>$id_subj,'KM_num'=>$KM_num]);
            }
            $answer = 0;
            return json_encode($answer);
        }
        else{
            $answer = 3;
            return json_encode($answer);
        }
    }

     public function ShowTable(Request $show_request) {

        $show_subj = $show_request->input('subject');

        $id_subj = DB::table('i_d_subjects')->where('subject', $show_subj)->value('id');
        if ($id_subj === null) {
            $stud = null;
            $answer = 1;
            return json_encode([$stud,$answer]);
        }
        $id_stud_count = DB::table('stud_grades')->where('id_subject', $id_subj)->count();
        if ($id_stud_count === 0) {
            $stud = null;
            $answer = 2;
            return json_encode([$stud,$answer]);
        }
        $selection = DB::select('SELECT
            i_d_stud_models.name,
            stud_grades.grade,
            i_d_subjects.subject,
            stud_grades.KM_num,
            stud_grades.id_student,
            stud_grades.id_subject
        FROM i_d_stud_models
        JOIN stud_grades
        ON i_d_stud_models.id = stud_grades.id_student
        JOIN i_d_subjects
        ON i_d_subjects.id = stud_grades.id_subject
        ORDER BY i_d_stud_models.id, stud_grades.KM_num;');

        $selection_coll = collect($selection);
        $stud = $selection_coll->whereIn('subject',$show_subj);
        $answer = 0;
        return json_encode([$stud,$answer]);
    }

    public function GradingStud(Request $grade_request)
    {
        $grade_stud = $grade_request-> input('FIO');
        $grade_subj = $grade_request-> input('subject');
        $grade_KM_num = $grade_request-> input('KM_num');
        $grade_grade = $grade_request-> input('grade');

        $id_stud = DB::table('i_d_stud_models')->where('name', $grade_stud)->value('id');
        if ($id_stud === null) {
            $answer = 1;
            return json_encode($answer);
        }
        $id_subj = DB::table('i_d_subjects')->where('subject', $grade_subj)->value('id');
        if ($id_subj === null) {
            $answer = 2;
            return json_encode($answer);
        }
        $value = DB::table('stud_grades')->where('id_subject', $id_subj)->where('id_student', $id_stud)->count();
        if($value === 0) {
            $answer = 3;
            return json_encode($answer);
        }
        else{
            DB::table('stud_grades')->where('id_subject', $id_subj)->where('id_student', $id_stud)->where('KM_num', $grade_KM_num)->update(['grade' => $grade_grade]);
            $answer = 0;
            return json_encode($answer);
        }
    }

    public function DeleteStud(Request $del_req_stud){
        $del_stud = $del_req_stud-> input('student');
        $value = DB::table('i_d_stud_models')->where('name', $del_stud)->value('id');
        DB::table('i_d_stud_models')->where('name', '=', $del_stud)->delete();
        DB::table('stud_grades')->where('id_student', '=', $value)->delete();
    }

    public function GetTableSubjects(){
        $subjects = DB::table('i_d_subjects')->get();
        return json_encode($subjects);
    }

    public function DeleteString(Request $del_req){
        $del_id_stud = $del_req -> input('id_student');
        $del_id_subj = $del_req -> input('id_subject');
        $del_count=DB::table('stud_grades')->where('id_student', '=', $del_id_stud)->where('id_subject', '=', $del_id_subj)->delete();
        return json_encode($del_count);
    }

    public function ChangeString(Request $change_req){
        $change_id_stud = $change_req -> input('id_student');
        $change_id_subj = $change_req -> input('id_subject');
        $KMs = $change_req -> input('KM');
        for($step = 0; $step <= 3; $step ++){
            DB::table('stud_grades')
                ->where('id_student', $change_id_stud)
                ->where('id_subject', $change_id_subj)
                ->where('KM_num', ($step + 1))
                ->update(['grade' => $KMs[$step]]);
        }
        $answer = 1;
        return json_encode($answer);
        }
}
