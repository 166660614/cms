<?php
namespace App\Admin\Controllers;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use App\Model\Info;
class UserController extends Controller{
    public function index(Content $content){
        return $content
            ->header('用户管理')
            ->description('用户列表')
            ->body($this->grid());
    }
    public function grid(){
        $grid=new Grid(new Info());
        $grid->id('用户ID');
        $grid->name('用户名');
        $grid->email('用户邮箱');
        $grid->age('用户年龄');
        $grid->reg_time('注册时间')->display(function ($time){
            return date('Y-m-d H:i:s',$time);
        });
        return $grid;
    }
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }
    protected function form()
    {
        $form = new Form(new Info());

        $form->text('nick_name', '昵称');
        $form->text('age', '年龄');
        $form->email('email', 'Email');
        $form->editor('content','用户介绍');
        return $form;
    }
}