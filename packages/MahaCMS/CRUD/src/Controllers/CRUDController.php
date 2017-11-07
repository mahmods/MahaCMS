<?php

namespace MahaCMS\CRUD\Controllers;

use Auth;
use DB;
use Schema;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\CRUD\Models\Table;


class CRUDController extends Controller
{
    public function tables()
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        return response()->json(['tables' => $tables]);
    }

    public function rows($table)
    {
        $rows = with(new Table())->setTable($table)->get();
        $columns = Schema::getColumnListing($table);
        return response()->json(['table' => $table, 'rows' => $rows, 'columns' => $columns]);
    }

    public function create($table)
    {
        $columns = Schema::getColumnListing($table);
        $form = array();
        foreach ($columns as $column) {
            $type = Schema::getColumnType($table, $column);
            array_push($form, array([
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => $column,
                    'model' => $column,
                    'value' => ''
                )
            ]));
        }
        return response()->json(['form' => $form]);
    }

    public function store(Request $request, $table)
    {
        $row = with(new Table())->setTable($table);
        $columns = Schema::getColumnListing($table);
        foreach ($columns as $c) {
            $row->$c = $request->$c;
        }
        $row->created_at = \Carbon\Carbon::now();
        $row->save();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param string $table
     * @param int    $key
     *
     * @return \Illuminate\Http\Response
     */
    public function show($table, $key)
    {
        $r = self::getRowAndColumns($table, $key);
        return view('laralum_CRUD::show', ['table' => $table, 'row' => $r[0], 'columns' => $r[1]]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param string $table
     * @param int    $key
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($table, $key)
    {
        $r = self::getRowAndColumns($table, $key);
        return view('laralum_CRUD::edit', ['table' => $table, 'row' => $r[0], 'columns' => $r[1]]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $table
     * @param int                      $key
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $table, $key)
    {
        $r = self::getRowAndColumns($table, $key);
        $row = $r[0]->setTable($table);
        $columns = $r[1];
        foreach ($columns as $c) {
            $type = Schema::getColumnType($table, $c);
            if ($type == 'boolean') {
                $row->$c = $request->$c && $request->$c;
            } else {
                $row->$c = $request->$c;
            }
        }
        $row->save();
        return redirect()->route('laralum::CRUD.row.index', ['table' => $table])->with('success', __('laralum_CRUD::general.row_edited'));
    }
    /**
     * Confirm remove the specified resource from storage.
     *
     * @param string $table
     * @param int    $key
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete($table, $key)
    {
        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'action' => route('laralum::CRUD.row.destroy', ['table' => $table, 'key' => $key]),
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($table, $key)
    {
        $r = self::getRowAndColumns($table, $key);
        $row = $r[0]->setTable($table);
        $row->delete();
        return redirect()->route('laralum::CRUD.row.index', ['table' => $table])->with('success', __('laralum_CRUD::general.row_deleted'));
    }
    /**
     * Get the row and the columns of the specified table key.
     *
     * @param string $table
     * @param int    $key
     *
     * @return array
     */
    public function getRowAndColumns($table, $key)
    {
        $raw_row = with(new Table())->setTable($table);
        $row = $raw_row->where($raw_row->getKeyName(), $key)->first();
        $columns = Schema::getColumnListing($table);
        return [$row, $columns];
    }
}