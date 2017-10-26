<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{

    protected $description = 'descriptions.professors';

    public function rank(Request $request, $id)
    {
        $model = Professor::query()
            ->where('professorrating', $id)
            ->where('active', 1)
            ->first();

        abort_if(!$model, 404);

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
