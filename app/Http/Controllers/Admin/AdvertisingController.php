<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\AdvertisingRepository;
use Illuminate\Http\Request;
use Gate;
class AdvertisingController extends AdminController
{
    public function index(AdvertisingRepository $repository)
    {
        if (Gate::denies('UPDATE_ADVERTISING')) {
            abort(404);
        }

        $advertisings = $repository->get(['id', 'placement', 'text', 'own']);
        $this->content = view('admin.advertising.show')->with(['advertisings' => $advertisings])->render();
        return $this->renderOutput();
    }

    public function edit(AdvertisingRepository $repository, Request $request, $advertising=false)
    {
        if (Gate::denies('UPDATE_ADVERTISING')) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $result = $repository->updateAdvertising($request, $advertising);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result['error']);
            }
            return redirect()->route('advertising_admin')->with($result);
        }

        $this->content = view('admin.advertising.edit')->with(['advertising' => $advertising])->render();
        return $this->renderOutput();

    }
}
