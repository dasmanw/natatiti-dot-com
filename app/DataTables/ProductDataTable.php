<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('warehouse', function ($product) {
                return $product->warehouse?->name;
            })
            ->addColumn('category', function ($product) {
                return $product->category?->name;
            })
            ->addColumn('status', function ($product) {
                return view('content.product.partials.status', compact('product'));
            })
            ->addColumn('action', function ($product) {
                return view('content.product.partials.actions', compact('product'));
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        $query = $model->newQuery();
        if (!(is_super_admin() || is_admin())) {
            $query = $query->where('vendor_id', auth()->id());
        }
        $query = $query->select(
            'id',
            'vendor_id',
            'warehouse_id',
            'category_id',
            'prices',
            'code',
            'name',
            'length',
            'height',
            'width',
            'image_link',
            'deleted_at'
        )->with([
            'warehouse:id,name',
            'category:id,name',
            'media'
        ])->orderByDesc('id')
            ->withTrashed();

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->responsive(true);

        if (app()->getLocale() == "ar") {
            $dataTable->language([
                'url' => asset('plugin/ar.json'),
            ]);
        }

        return $dataTable;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('code'),
            Column::make('name'),
            Column::make('warehouse'),
            Column::make('category'),
            Column::make('status'),
            Column::computed('action')
        ];
    
        if (app()->getLocale() == "ar") {
            $columns[0]->title('رمز');
            $columns[1]->title('الإسم');
            $columns[2]->title('المخزن');
            $columns[3]->title('الفئة');
            $columns[4]->title('الحالة');
            $columns[5]->title('خيارات العمل');
        }
    
        return $columns;
    }
}
