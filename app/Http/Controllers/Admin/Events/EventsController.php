<?php

namespace Fresh\Estet\Http\Controllers\Admin\Events;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Gate;

class EventsController extends AdminController
{
    public function __construct()
    {
        $this->template = 'admin.events.index';
    }

    public function show()
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }



        $this->content = view('admin.events.show')->render();
        return $this->renderOutput();
    }
}
