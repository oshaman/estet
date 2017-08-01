<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Gate;

class EstablishmentsController extends AdminController
{
    public function index()
    {
        if (Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }

        $profiles = null;
        $this->content = view('admin.establishment.index')->with('profiles', $profiles)->render();
        return $this->renderOutput();
    }
}
