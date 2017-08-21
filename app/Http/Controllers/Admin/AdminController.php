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

            if(Gate::allows('EDIT_USERS')){
                $menu->add(trans('ru.profiles'),  array('route'  => 'admin_profile'));
            }

            if(Gate::allows('EDIT_USERS')){
                $menu->add(trans('ru.specialties'),  array('route'  => 'specialties'));
            }

            if(Gate::allows('UPDATE_CATS')) {
                $menu->add('Категории', array('route' => 'cats'));
            }

            if(Gate::allows('UPDATE_CATS')) {
                $menu->add('Категории блога', array('route' => 'blogcats'));
            }

            if(Gate::allows('UPDATE_TAGS')) {
                $menu->add('Тэги', array('route' => 'tags'));
            }

            if(Gate::allows('DELETE_BLOG')) {
                $menu->add(trans('ru.blog'), array('route' => 'view_blogs'));
            }

            if(Gate::allows('UPDATE_ESTABLISHMENT')) {
                $menu->add(trans('ru.establishment'), array('route' => 'admin_establishment'));
            }

            if(Gate::allows('ADD_ARTICLES')) {
                $menu->add(trans('ru.articles'), array('route' => 'admin_articles'));
            }

            if(Gate::allows('UPDATE_GOROSCOP')) {
                $menu->add('Гороскоп', array('route' => 'admin_goroscop'));
            }

            if(Gate::allows('UPDATE_MENUS')) {
                $menu->add('Меню', array('route' => 'menus'));
            }

            if(Gate::allows('UPDATE_COMMENTS')) {
                $menu->add('Коментарии', array('route' => 'admin_comments'));
            }

            if(Gate::allows('UPDATE_PREMIUMS')) {
                $menu->add('Премиум', array('route' => 'premium'));
            }

            if(Gate::allows('UPDATE_GEO')) {
                $menu->add('Добавить страну', array('route' => 'country'));
            }

            if(Gate::allows('UPDATE_GEO')) {
                $menu->add('Добавить город', array('route' => 'city'));
            }

            if(Gate::allows('UPDATE_EVENTS')) {
                $menu->add('Мероприятия', array('route' => 'events_admin'));
            }

            if(Gate::allows('UPDATE_SEO')) {
                $menu->add('SEO', array('route' => 'seo_admin'));
            }

            if(Gate::allows('UPDATE_ADVERTISING')) {
                $menu->add('Реклама', array('route' => 'advertising_admin'));
            }
            /*
            if(Gate::allows('UPDATE_EVENTS')) {
                 $menu->add(trans('ua.history'), array('route' => 'admin_events'))->prepend('<i class="icon-calendar"></i>');
             }

             if(Gate::allows('CONFIRMATION_DATA')){
                 $menu->add(trans('ua.selection'),  array('route'  => 'selection'))->prepend('<i class="icon-file"></i>');
             }*/
        });
    }
}
