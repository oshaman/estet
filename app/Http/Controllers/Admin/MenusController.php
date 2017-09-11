<?php

namespace Fresh\Estet\Http\Controllers\Admin;
use Fresh\Estet\Category;

use Fresh\Estet\Repositories\MenusRepository;
use Fresh\Estet\Menu;
use Fresh\Estet\Http\Requests\MenusRequest;
use Gate;
use Cache;

class MenusController extends AdminController
{
    protected $m_rep;

    public function __construct(MenusRepository $rep)
    {
        $this->m_rep = $rep;
    }

    public function index(MenusRequest $request)
    {
        if (Gate::denies('UPDATE_MENUS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $result = $this->m_rep->updateMenus($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            Cache::forget('patientMenu');
            Cache::forget('docsMenu');
            return back()->with($result);
        }

        $cats = Category::select('id', 'name')->get();

        $menus = Menu::all();

        $this->content = view('admin.menu.menu')->with(['cats' => $cats, 'menus' => $menus])->render();
        return $this->renderOutput();
    }

}
