<?php

namespace app\Admin\Controllers\Auth;

use App\Admin\Models\Auth\UserComany;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.list'));
            $content->body($this->grid()->render());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.edit'));
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.create'));
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Administrator::grid(function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->user_login(trans('admin.username'));
            $grid->user_nicename(trans('admin.name'));
            $grid->roles(trans('admin.roles'))->pluck('name')->label();
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
                    $actions->disableDelete();
                }
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });

            $grid->filter(function($filter){

                // 在这里添加字段过滤器
                $filter->column(1/2, function ($filter) {
                    $filter->like('user_login', '用户名');
                });

                $filter->column(1/2, function ($filter) {
                    $filter->like('user_nicename', '名称');
                });

                // 去掉默认的id过滤器
                $filter->disableIdFilter();


            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $is_admin = Admin::user()->isAdministrator();
        if($is_admin === true){
            $company = UserComany::all()->pluck('company_name','id');
        }
        else{
            $company_id = Admin::user()->company_id;
            $company = UserComany::where('id',$company_id)->get()->pluck('company_name','id');
        }

        return Administrator::form(function (Form $form) use($company){
            $form->display('id', 'ID');
            $form->text('user_login', trans('admin.username'))->rules(function ($form){
                if (!$id = $form->model()->id) {
                    return 'required|unique:cmf_users,user_login';
                }
                else{
                    return 'required';
                }
            });
            $form->text('user_nicename', trans('admin.name'))->rules(function ($form){
                if (!$id = $form->model()->id) {
                    return 'required|unique:cmf_users,user_nicename';
                }
                else{
                    return 'required';
                }
            });
            $form->image('avatar', trans('admin.avatar'));
            $form->password('password', trans('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);

            $form->multipleSelect('roles', trans('admin.roles'))->options(Role::all()->pluck('name', 'id'));
            $form->multipleSelect('permissions', trans('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));
            $form->select('company_id',trans('admin.company'))->options($company);
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }
}
