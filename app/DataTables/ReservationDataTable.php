<?php

namespace App\DataTables;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReservationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('salesman', function ($reservation) {
                return $reservation->salesman?->name;
            })
            ->addColumn('action', function ($reservation) {
                return view('content.reservation.partials.actions', compact('reservation'));
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Reservation $model): QueryBuilder
    {
        if (is_admin() || is_super_admin()) {
            return $model->newQuery()
                ->select(
                    'id',
                    'code',
                    'salesman_id',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'payment_method',
                    'total_discount',
                    'sub_total',
                    'grand_total',
                )
                ->with('salesman')
                ->orderByDesc('id');
        } else {
            return $model->newQuery()
                ->select(
                    'id',
                    'code',
                    'salesman_id',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'payment_method',
                    'total_discount',
                    'sub_total',
                    'grand_total',
                )
                ->with('salesman')
                ->where('salesman_id', auth()->id())
                ->orderByDesc('id');
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('reservation-table')
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
        if (is_admin() || is_super_admin()) {
            return [
                Column::make('code'),
                Column::make('salesman'),
                Column::make('name'),
                Column::make('address'),
                Column::make('email'),
                Column::make('payment_method'),
                Column::make('total_discount'),
                Column::make('sub_total'),
                Column::make('grand_total'),
                Column::computed('action')
            ];
        } else {
            return [
                Column::make('code'),
                Column::make('name'),
                Column::make('address'),
                Column::make('email'),
                Column::make('payment_method'),
                Column::make('total_discount'),
                Column::make('sub_total'),
                Column::make('grand_total'),
                Column::computed('action')
            ];
        }
    }
}
