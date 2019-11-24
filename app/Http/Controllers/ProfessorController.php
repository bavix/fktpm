<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Professor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class ProfessorController extends BaseController
{

    /**
     * @var string
     */
    protected $description = 'descriptions.professors';

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('professor.view', [
            'items' => Faculty::with('departments.professors')
                ->where('active', 1)
                ->get(),
            'title' => 'Факультеты, Кафедры, Преподаватели',
            'description' => trans($this->description)
        ]);
    }

    /**
     * @param Request $request
     * @param Professor $professor
     * @return RedirectResponse
     */
    public function professorRating(Request $request, Professor $professor): RedirectResponse
    {
        return redirect(route('professor.rank', $professor->professorrating), 301);
    }

    /**
     * @param Request $request
     * @param Professor $professor
     * @return RedirectResponse
     */
    public function rank(Request $request, Professor $professor): RedirectResponse
    {
        return redirect('https://professorrating.org/professor.php?id=' . $professor->professorrating);
    }

}
