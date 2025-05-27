<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentFormController extends Controller
{
    public function index()
    {
        $associacoes = DB::table('student_form')
            ->join('students', 'student_form.student_id', '=', 'students.id')
            ->join('forms', 'student_form.form_id', '=', 'forms.id')
            ->select('student_form.*', 'students.id as student_id', 'forms.title as form_title')
            ->get();

        return view('student_form.index', compact('associacoes'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        $forms = Form::where('is_validated', true)->get();
        return view('student_form.create', compact('students', 'forms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'form_id' => 'required|exists:forms,id',
        ]);

        DB::table('student_form')->insert([
            'student_id' => $request->student_id,
            'form_id' => $request->form_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('student-form.index')->with('success', 'Associação criada!');
    }

    public function destroy($id)
    {
        DB::table('student_form')->where('id', $id)->delete();
        return redirect()->route('student-form.index')->with('success', 'Associação removida!');
    }
}

