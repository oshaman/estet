<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\CommentsRepository;
use Illuminate\Http\Request;


class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $c_rep = new CommentsRepository();
        $result = $c_rep->addComment($request);

        if(is_array($result) && !empty($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->back()->with($result);

    }
}
