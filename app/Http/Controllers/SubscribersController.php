<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\SubscribersRepository;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function add(Request $request, SubscribersRepository $repository)
    {
        if ($request->isMethod('post')) {

            $result = $repository->addSubscriber($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result['error']);
            }
            return redirect()->back()->with($result);
        }
    }
}
