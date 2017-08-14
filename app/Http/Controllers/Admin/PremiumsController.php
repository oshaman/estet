<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\PremiumsRepository;
use Gate;
use Illuminate\Http\Request;

class PremiumsController extends AdminController
{
    public  function index(Request $request)
    {
        if (Gate::denies('UPDATE_PREMIUMS')) {
            abort(404);
        }
        $model = new PremiumsRepository;
        if ($request->isMethod('post')) {
            if ($request->has('category')) {
                $result = $model->updatePrem($request);

                if(is_array($result) && !empty($result['error'])) {
                    return redirect()->back()->withErrors($result['error'])->withInput();
                }

                return redirect()->back()->with($result);
            }
            if ($request->has('params')) {
                $category = $request->get('params');
            }
        }
        $data = '';

        if (!empty($category)) {
            $data = $model->getPrem($category);
        }

        $this->content = view('admin.prem')->with('data', $data)->render();

        return $this->renderOutput();
    }
}
