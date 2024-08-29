<?php

namespace App\DataTables;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WarehouseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name', function ($warehouse) {
                return $warehouse->getTranslation('name', app()->getLocale());
            })
            ->addColumn('status', function ($warehouse) {
                return view('content.warehouse.partials.status', compact('warehouse'));
            })
            ->addColumn('action', function ($warehouse) {
                return view('content.warehouse.partials.actions', compact('warehouse'));
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Warehouse $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('id', 'name', 'address', 'deleted_at')
            ->orderByDesc('id')
            ->withTrashed();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('warehouse-table')
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
            Column::make('name'),
            Column::make('address'),
            Column::make('status'),
            Column::computed('action')
        ];
    
        if (app()->getLocale() == "ar") {
            $columns[0]->title('الإسم');
            $columns[1]->title('العنوان');
            $columns[2]->title('الحالة');
            $columns[3]->title('خيارات العمل');
        }
    
        return $columns;
    }
}
