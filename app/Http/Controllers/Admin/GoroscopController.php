<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Horoscope;
use Illuminate\Http\Request;
use Validator;

class GoroscopController extends AdminController
{

    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $data = $request->except('_token');
            $validator = Validator::make($data, [
                '*' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $model = Horoscope::find(1);
            $model->fill($data)->save();

        }

        $signs = array_except(Horoscope::first()->toArray(), ['id', 'created_at', 'updated_at']);

        $this->content = view('admin.horoscope')->with('signs', $signs)->render();

        return $this->renderOutput();
    }
}
