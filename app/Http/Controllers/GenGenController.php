<?php

namespace App\Http\Controllers;

use App\GenGen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class GenGenController extends Controller {

	public $tablename = "Project table District_Generalview";

	public function show_dashboard() {
		return view('gengen.frame');
	}

	public function show_navigator() {
		return view('gengen.navigator');
	}

	public function color_search_results($str1, $str2) {
		$kwicLen = strlen($str1);

		$kwicArray = array();
		$pos = 0;
		$count = 0;

		while ($pos !== FALSE) {
			$pos = stripos($str2, $str1, $pos);
			if ($pos !== FALSE) {
				$kwicArray[$count]['kwic'] = substr($str2, $pos, $kwicLen);
				$kwicArray[$count++]['pos'] = $pos;
				$pos++;
			}
		}

		for ($I = count($kwicArray) - 1; $I >= 0; $I--) {
			$kwic = '<span style="background-color:yellow;">' . $kwicArray[$I]['kwic'] . '</span>';
			$str2 = substr_replace($str2, $kwic, $kwicArray[$I]['pos'], $kwicLen);
		}

		return ($str2);
	}

	public function log_query() {

		\DB::listen(function ($sql, $binding, $timing) {
			\Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
		}
		);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request) {
		$table = $this->tablename;
		$table = '`' . str_replace("'", "", $table) . '`';
		$query = collect(\DB::select(\DB::raw("show full columns from " . $table)));
		//take all column names
		$table_headers = $query->pluck('Field');
		//add counter to list of field names so it can be used in datatables
		$table_headers->prepend('thecounter');
		return view('gengen.index')->with('results', array())->with("table_headers", $table_headers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	public function create(Request $request) {
		// dd(\App\Location::paginate(10));

		//get the list of table in the database from the configured database
		$all_tables = \DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema=?", array(env('DB_DATABASE')));

		if (!$request->has('table_name')) {
			return view('gengen.create')->with('all_tables', $all_tables);
		}

		if (empty($request['table_name'])) {
			return view('gengen.create')->with('all_tables', $all_tables);
		}

		$table = '`' . str_replace("'", "", $request["table_name"]) . '`';
		$tableinfo = collect(\DB::select(\DB::raw("show full columns from " . $table)));
		return view('gengen.create')->with('tableinfo', $tableinfo)->with('all_tables', $all_tables)->with('table_name', $request["table_name"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function create_crud(Request $request, $table_name) {

		foreach ($request['field'] as $value) {
			$type = $request['type'][$value];
			$field = $value;
			$required = $request->input("required.$value") == "on" ? "required" : "";
			$fields_array[] = $field . ":" . $type . ":" . $required;

		}

		$fields = implode(",", $fields_array);
		$pk = "";
		if ($request->has('pk')) {
			$pk = $request['pk'];
		}

		$exitCode = \Artisan::call('ropat-crud:generate', ['name' => $table_name, '--fields' => $fields, '--route' => 'yes', '--table-name' => $table_name, '--pk' => $pk, '--view-path' => 'crud']);

		// Session::flash('flash_message', 'GenGen done it!');
		return redirect('gengen/create')->withErrors(array($exitCode, $table_name . " created successfully"));
	}

	// public createCrudFiles(Request $request){

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function show($id) {
		$gengen = GenGen::findOrFail($id);

		return view('gengen.show', compact('gengen'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */

	public function edit($id) {
		$gengen = GenGen::findOrFail($id);

		return view('gengen.edit', compact('gengen'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function update($id, Request $request) {
		$this->validate($request, ['name' => 'required', 'fields' => 'required', 'create_route' => 'required']);

		$gengen = GenGen::findOrFail($id);
		$gengen->update($request->all());

		Session::flash('flash_message', 'GenGen updated!');

		return redirect('gengen');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function destroy($id) {
		GenGen::destroy($id);

		Session::flash('flash_message', 'GenGen deleted!');

		return redirect('gengen');
	}

}
