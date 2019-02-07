<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ReviewController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Reviews')
//            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $form = $this->form();

        return $content
            ->header('Edit')
            ->description('description')
            ->body($form->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Review);
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->id('#')->sortable();
        $grid->reviewable_type('Type')->display(function ($value) {
            return "<span class='label label-success'>".title_case($value)."</span>";
        });
        $grid->reviewable_id('Name')->display(function ($value) use ($grid) {
            if ($this->reviewable_type === 'product') {
                return Product::find($value)->name;
            }
            return '';
        });
        $grid->user()->name('Name');
        $grid->rating('Rating');
        $grid->approved_at('Approved at');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Review::findOrFail($id));

        $show->id('ID');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Review);
        $form->ignore(['approve_at']);

        $form->display('id', 'ID');
        $form->display('user.name');
        $form->text('title');
        $form->textarea('content');
        $form->number('rating')->min(1)->max(5);
        $form->switch('approve_switch', 'Approve');
        $form->display('approved_at', 'Approved At');
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
