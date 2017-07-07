<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;

use Auth;
use Menu;
use Gate;

class AdminController extends Controller
{
    protected $template = '\admin.index';
    protected $content = FALSE;
    protected $title;
    protected $vars;
    protected $sidebar_vars = false;


    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $this->vars = array_add($this->vars, 'nav', $menu);

        if($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    /**
     * Menu builder.
     *
     *  return menu instance
     */
    public function getMenu() {
        return Menu::make('adminMenu', function($menu) {

            $menu->add(trans('ru.home'),  array('route'  => 'main'));

            if(Gate::allows('EDIT_PERMS')){
                $menu->add(trans('ru.permissions'),  array('route'  => 'permissions'));
            }

            if(Gate::allows('ADMIN_USERS')){
                $menu->add(trans('ru.users'),  array('route'  => 'users'));
            }
            /*  if(Gate::allows('UPDATE_ARTICLES')) {
                 $menu->add(trans('ua.articles'), array('route' => 'admin_articles'));
             }

            if(Gate::allows('UPDATE_EVENTS')) {
                 $menu->add(trans('ua.history'), array('route' => 'admin_events'))->prepend('<i class="icon-calendar"></i>');
             }



             if(Gate::allows('EDIT_USERS')){
                 $menu->add(trans('ua.users'),  array('route'  => 'users'))->prepend('<i class="icon-user"></i>');
             }


             if(Gate::allows('CONFIRMATION_DATA')){
                 $menu->add(trans('ua.selection'),  array('route'  => 'selection'))->prepend('<i class="icon-file"></i>');
             }*/
        });
    }
}
