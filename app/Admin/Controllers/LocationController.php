<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Region;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class LocationController extends Controller
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
            ->header('Location')
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

        $form->ignore([
            [
                'lat' => 'lat',
                'lng' => 'lng',
            ],
        ]);

        $form->editing(function ($form) {
            $coord = $form->model()->coord;

            $form->builder()->fields()->transform(function ($field) use ($coord) {
                if ($field->label() === 'Coord') {
                    $field->fill([
                        'lat' => $coord->getLat(),
                        'lng' => $coord->getLng(),
                    ]);
                }

                return $field;
            });
        });

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
        $grid = new Grid(new Location);
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->id('#')->sortable();
        $grid->region()->name('Region');
        $grid->name('Name');
        $grid->coord('lat, lng')->display(function ($value) {
            return $value->getLat() . ',' . $value->getLng();
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
        $show = new Show(Location::findOrFail($id));

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
        $form = new Form(new Location);

        $form->display('id', 'ID');
        $form->select('region_id', 'Region')->options(function () {
           return Region::all()->pluck('name', 'id');
        });
        $form->text('name', 'Name');
        $form->map('lat', 'lng', 'Coord');
        $form->embeds('opening_hours', 'Opening Hours', function ($form) {
            $form->dateRange('0.0', '0.1', 'Sunday');
            $form->dateRange('1.0', '1.1', 'Monday');
            $form->dateRange('2.0', '2.1', 'Tuesday');
            $form->dateRange('3.0', '3.1', 'Wednesday');
            $form->dateRange('4.0', '4.1', 'Thursday');
            $form->dateRange('5.0', '5.1', 'Friday');
            $form->dateRange('6.0', '6.1', 'Saturday');
        });

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
