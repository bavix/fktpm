<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Professor;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{

    protected $description = 'descriptions.professors';

    public function model($id)
    {
        $model = Professor::query()
            ->where('professorrating', $id)
            ->where('active', 1)
            ->first();

        abort_if(!$model, 404);

        return $model;
    }

    public function professorRating(Request $request, $id)
    {
        $this->model($id);

        return redirect(route('professor.rank', $id), 301);
    }

    public function rank(Request $request, $id)
    {
        $this->model($id);

        return redirect('https://professorrating.org/professor.php?id=' . $id);
    }

    public function index(Request $request)
    {
        return $this->render(
            'professor.view',
            [
                'items' => Faculty::with('departments.professors')
                    ->where('active', 1)
                    ->get(),
                'title'       => 'Преподаватели',
                'description' => __($this->description)
            ]
        );
    }

}
