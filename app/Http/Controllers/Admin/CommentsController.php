<?php

namespace Fresh\Estet\Http\Controllers\Admin;
use Fresh\Estet\Repositories\TmpcommentsRepository;
use Illuminate\Http\Request;
use Gate;

class CommentsController extends AdminController
{
    public function index(Request $request)
    {
        if (Gate::denies('UPDATE_COMMENTS')) {
            abort(404);
        }


        $data = $request->except('_token');
        if (!empty($data['param'])) {
            $data['comment'] = $data['comment'] ?? null;
            if (!empty($data['comment'])) {
                $this->validate($request, [
                    'comment' => 'nullable|integer',
                ]);
                $com_rep = new TmpcommentsRepository();
                $comments[] = $com_rep->getOne($data['comment'], $data['param']);

            } else {
                $com_rep = new TmpcommentsRepository();
                $comments = $com_rep->get($data['param']);
            }
        } else {
            $comments = '';
        }

        $this->content = view('admin.comments.index')->with(['comments' => $comments])->render();

        return $this->renderOutput();
    }

    public function edit()
    {
        dd('edit');
    }
    public function destroy()
    {
        dd('del');
    }
}
