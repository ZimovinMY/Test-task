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
            'student' => 'required|min:4|max:50'
        ]);

        $new_student = $stud_request-> input('student');

        $value = DB::table('i_d_stud_models')->where('name', $new_student)->count();
        if ($value === 0) {
            DB::table('i_d_stud_models')->insert(['name'=>$new_student]);
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
        return view('BindingStudent', ['exist_binding' => false,'no_stud_binding' => false,'no_subj_binding' => false]);
    }

    public function BindingStudent_check(Request $bind_request) {
        $valid = $bind_request->validate([
            'subject' => 'required|min:4|max:50',
            'student' => 'required|min:4|max:50'
        ]);

        $bind_subj = $bind_request-> input('subject');
        $bind_stud = $bind_request-> input('student');

        $id_subj=DB::table('i_d_subjects')->where('subject', $bind_subj)->value('id');
        if($id_subj === null){
            return view('BindingStudent', ['exist_binding' => false,'no_stud_binding' => false,'no_subj_binding' => true]);
        }
        $id_stud=DB::table('i_d_stud_models')->where('name', $bind_stud)->value('id');
        if($id_stud === null){
            return view('BindingStudent', ['exist_binding' => false,'no_stud_binding' => true,'no_subj_binding' => false]);
        }
        $value = DB::table('stud_grades')->where('id_student', $id_stud)->where('id_subject', $id_subj)->count();
        if ($value === 0) {
            DB::table('stud_grades')->insert(['id_student'=>$id_stud,'id_subject'=>$id_subj]);
            return view('main');
        }
        else{
            return view('BindingStudent', ['exist_binding' => true,'no_stud_binding' => false,'no_subj_binding' => false]);
        }
    }

    public function ShowStudents() {
        return view('ShowStudents', ['students' => [], 'no_exist_subject' => false, 'no_exist_student' => false]);
    }

    public function ShowStudents_check(Request $show_request) {
        $valid = $show_request->validate([
            'subject' => 'required|min:4|max:50'
        ]);

        $show_subj = $show_request->input('subject');

        $id_subj = DB::table('i_d_subjects')->where('subject', $show_subj)->value('id');
        if ($id_subj === null) {
            return view('ShowStudents', ['students' => [], 'no_exist_subject' => true, 'no_exist_student' => false]);
        }
        $id_stud_count = DB::table('stud_grades')->where('id_subject', $id_subj)->count();
        if ($id_stud_count === 0) {
            return view('ShowStudents', ['students' => [], 'no_exist_subject' => false, 'no_exist_student' => true]);
        }
        $id_stud = DB::table('stud_grades')->where('id_subject', $id_subj)->get();
        $data_array = $id_stud->toArray();
        $id_stud_array = array_column($data_array, 'id_student');
        $stud_name = DB::table('i_d_stud_models')->whereIn('id', $id_stud_array)->get();
        return view('ShowStudents', ['students' => $stud_name, 'no_exist_subject' => false, 'no_exist_student' => false]);
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
}
