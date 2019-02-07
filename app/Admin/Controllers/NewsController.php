<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Region;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NewsController extends Controller
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
            ->header('News')
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
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
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
        $grid = new Grid(new News);
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->id('#')->sortable();
        $grid->title('Title');
        $grid->regions('Regions')->display(function ($value) {
            $value = array_map(function ($value) {
                return "<span class='label label-success'>{$value['name']}</span>";
            }, $value);

            return empty($value) ? "<span class='label label-success'>All</span>" : join('&nbsp;', $value);
        });
        $grid->published_at('Published at');
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
        $show = new Show(News::findOrFail($id));

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
        $form = new Form(new News);

        $form->display('id', 'ID');
        $form->multipleSelect('regions')->options(Region::all()->pluck('name', 'id'));

        $form->text('title', 'Title');
        $form->textarea('content', 'Content');
        $form->datetime('published_at', 'Published At');
        $form->datetime('ended_at', 'Ended At');

        $form->hasMany('links', 'Links', function (Form\NestedForm $form) {
            $form->text('type');
            $form->text('title');
            $form->url('link');
        });

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
