<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends AlbumController
{

    protected $model       = Poll::class;
    protected $withModel   = ['tagged'];
    protected $route       = 'poll';
    protected $title       = 'blocks.polls';
    protected $description = 'blocks.listPolls';

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        $model = Poll::query()
            ->where('active', 1)
            ->find($id);

        \abort_if(!$model, 404);

        $count  = $model->questions()->count();
        $result = $request->cookie('poll_' . $id);

        if ($request->method() === 'POST')
        {
            $questions = $request->input()['questions'] ?? [];

            if (count($questions) === $count)
            {
                $result = \json_encode($questions);
                $this->setCookie('poll_' . $id, $result);

                // todo : replace on raw query
                foreach ($model->questions as $question)
                {
                    /**
                     * @var $answer Answer
                     */
                    $answer = $question->answers
                        // if question not found
                        ->where('id', $questions[$question->id] ?? -1)
                        ->first();

                    $answer->count++;
                    $answer->save();

                    $question->count++;
                    $question->save();
                }
            }
        }

        if ($result)
        {
            $result = \json_decode($result, true);

            if ($count !== count($result))
            {
                $result = null;
            }
        }

        return $this->render($result ? 'poll.result' : 'poll.view', [
            'item'        => $model,
            'title'       => $model->title . ' - Опрос',
            'result'      => $result,
            'description' => 'Опрос #' . $model->id
        ], $this->mergeData());

    }

}
