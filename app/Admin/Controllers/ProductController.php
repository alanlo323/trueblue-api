<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends Controller
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
            ->header('Products')
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
        $grid = new Grid(new Product);
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->model()->where('is_variant', '0');

        $grid->id('#')->sortable();
        $grid->categories('Categories')->display(function ($value) {
            $value = array_map(function ($value) {
                return "<span class='label label-success'>{$value['name']}</span>";
            }, $value);

            return empty($value) ? "<span class='label label-success'>All</span>" : join('&nbsp;', $value);
        });
        $grid->name('Name');
        $grid->price('Price');
        $grid->stock('Stock');
        $grid->has_stock('Unlimited Stock')->display(function ($value) {
            return $value ? '<i class="fa fa-check " />' : '<i class="fa fa-times" />';
        });
        $grid->is_vip('VIP')->display(function ($value) {
            return $value ? '<i class="fa fa-check " />' : '<i class="fa fa-times" />';
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
        $show = new Show(Product::findOrFail($id));

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
        $form = new Form(new Product);

        $form->display('id', 'ID');
        $form->multipleSelect('categories')->options(Category::all()->pluck('name', 'id'));

        $form->text('name', 'Name');
        $form->textarea('description', 'Description');
        $form->currency('price', 'Price');
        $form->number('stock', 'Stock');
        $form->switch('has_stock', 'Unlimited Stock');
        $form->switch('is_vip', 'VIP');

        $form->multipleSelect('attributes', 'Attributes')->options(ProductAttribute::all()->pluck('name', 'id'));

        $form->datetime('published_at', 'Published At');
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
