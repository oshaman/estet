<?php

namespace Fresh\Estet\Http\Controllers\Admin;
use Fresh\Estet\Repositories\CommentsRepository;
use Illuminate\Http\Request;
use Gate;

class CommentsController extends AdminController
{
    protected $comm_rep;
    
    public function __construct(CommentsRepository $repository)
    {
        $this->comm_rep = $repository;
    }

    /**
     * @param Request $request
     * @return Instance of View $this
     */
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

                $comments[] = $this->comm_rep->getOne($data['comment'], $data['param']);
                $source = $data['param'];
            } else {
                $comments = $this->comm_rep->get($data['param']);
                $source = $data['param'];
            }
        } else {
            $comments = '';
            $source = '';
        }
        $this->content = view('admin.comments.index')->with(['comments' => $comments, 'source' => $source])->render();

        return $this->renderOutput();
    }

    public function edit(Request $request, $id)
    {
        if (Gate::denies('UPDATE_COMMENTS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->comm_rep->updateComment($request, $id);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }

            return redirect()->route('admin_comments')->with($result);

        }

        $id = (int)$id;
        $result = $this->comm_rep->getOne($id, $request->get('comment_source'));

        $this->content = view('admin.comments.edit')->with('comment', $result)->render();
        return $this->renderOutput();
    }

    public function destroy(Request $request, $id)
    {
        if (Gate::denies('UPDATE_COMMENTS')) {
            abort(404);
        }

        $result = $this->comm_rep->delComment($request, $id);

        if(is_array($result) && !empty($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('admin_comments')->with($result);
    }
}
