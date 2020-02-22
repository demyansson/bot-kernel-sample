<?php

namespace App\Admin\Controllers;

use App\Telegram\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TelegramUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Telegram\Models\User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('username', __('Username'));
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('language_code', __('Language code'));
        $grid->column('is_bot', __('Is bot'));
        $grid->column('context', __('Context'));
        $grid->column('payload', __('Payload'));
        $grid->column('image', __('Image'))->image('/storage');
        $grid->column('phone', __('Phone'));
        $grid->column('name', __('Name'));
        $grid->column('category', __('Category'));
        $grid->column('feedback', __('Feedback'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('language_code', __('Language code'));
        $show->field('is_bot', __('Is bot'));
        $show->field('context', __('Context'));
        $show->field('payload', __('Payload'));
        $show->field('image', __('Image'))->image();
        $show->field('phone', __('Phone'));
        $show->field('name', __('Name'));
        $show->field('category', __('Category'));
        $show->field('feedback', __('Feedback'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('username', __('Username'));
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->text('language_code', __('Language code'));
        $form->switch('is_bot', __('Is bot'));
        $form->text('context', __('Context'));
        $form->textarea('payload', __('Payload'));
        $form->image('image', __('Image'));
        $form->mobile('phone', __('Phone'));
        $form->text('name', __('Name'));
        $form->text('category', __('Category'));
        $form->textarea('feedback', __('Feedback'));

        return $form;
    }
}
