<?php

class SuratController extends BaseController {

	public function index() {
		$active = 'surat';
		if (Auth::user()) {
			$user = User::with('role')->where('user_id', Auth::user()->user_id)->first();
			$surats = Surat::all();
			return View::make('surat', compact('user', 'active', 'surats'));
		} else {
			return View::make('login');
		}
	}

	public function newSurat() {
		$active = 'surat';
		if (Auth::user()) {
			$user = User::with('role')->where('user_id', Auth::user()->user_id)->first();
			return View::make('formSurat', compact('user', 'active'));
		} else {
			return View::make('login');
		}
	}

	public function addSurat() {
		try {
			#deklarasi data input
			$arrFormat = Input::get('format');
			$arrFreetext = Input::get('freetext');
			$strFormat = "";
			$strNomor = "";
			$i = 1;
			foreach ($arrFormat as $str) {
				if ($str == "FREETEXT") {
					$str = $arrFreetext[$i];
					$part = $str;
				} elseif ($str == "AUTO") {
					$part = 0;
				} elseif ($str == "YEAR") {
					$part = date('Y');
				}
				$strFormat .= $str."/";
				$strNomor .= $part."/";
				$i++;
			}
			$strFormat = rtrim($strFormat, "/");
			$strNomor = rtrim($strNomor, "/");

			$kode_surat = trim(Input::get('kode_surat'));
			$keterangan = Input::get('keterangan');
			$jumlah_segmen = (int)Input::get('jumlah_segmen');
			$format = $strFormat;

			$validator = Validator::make(
				array(
					'kode_surat' => $kode_surat,
					'keterangan' => $keterangan,
					'jumlah_segmen' => $jumlah_segmen,
					'format' => $format
				),
				array(
					'kode_surat' => 'required',
					'keterangan' => 'required',
					'jumlah_segmen' => 'required|numeric',
					'format' => 'required'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$surat = new Surat;
			$surat->kode_surat = $kode_surat;
			$surat->keterangan = $keterangan;
			$surat->jumlah_segmen = $jumlah_segmen;
			$surat->format = $format;
			$surat->save();

			$logs = new Logsurat;
			$logs->user_id = Auth::user()->user_id;
			$logs->surat_id = $surat->surat_id;
			$logs->nomor_surat = $strNomor;
			$logs->save();
			
			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $surat;
			#jika ingin dapat last insert id
			#$response->data = $surat->surat_id;
			return Response::json($response);


		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function updateSurat() {
		try {
			#deklarasi data input
			$arrFormat = Input::get('format');
			$arrFreetext = Input::get('freetext');
			$strFormat = "";
			$strNomor = "";
			$i = 1;
			foreach ($arrFormat as $str) {
				if ($str == "FREETEXT") {
					$str = $arrFreetext[$i];
					$part = $str;
				} elseif ($str == "AUTO") {
					$part = 0;
				} elseif ($str == "YEAR") {
					$part = date('Y');
				}
				$strFormat .= $str."/";
				$strNomor .= $part."/";
				$i++;
			}
			$strFormat = rtrim($strFormat, "/");
			$strNomor = rtrim($strNomor, "/");

			$surat_id = (int)Input::get('surat_id');
			$kode_surat = trim(Input::get('kode_surat'));
			$keterangan = Input::get('keterangan');
			$jumlah_segmen = (int)Input::get('jumlah_segmen');
			$format = $strFormat;

			$validator = Validator::make(
				array(
					'surat_id' => $surat_id,
					'kode_surat' => $kode_surat,
					'keterangan' => $keterangan,
					'jumlah_segmen' => $jumlah_segmen,
					'format' => $format
				),
				array(
					'surat_id' => 'required|numeric',
					'kode_surat' => 'required',
					'keterangan' => 'required',
					'jumlah_segmen' => 'required|numeric',
					'format' => 'required'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}
			
			$surat = Surat::where('surat_id', $surat_id)->first();
			if (! is_object($surat)) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = 'Surat Not Found';
				$response->data = null;

				return Response::json($response);
			}

			$surat->surat_id = $surat_id;
			$surat->kode_surat = $kode_surat;
			$surat->keterangan = $keterangan;
			$surat->jumlah_segmen = $jumlah_segmen;
			$surat->format = $format;
			$surat->save();

			$logs = new Logsurat;
			$logs->user_id = Auth::user()->user_id;
			$logs->surat_id = $surat->surat_id;
			$logs->nomor_surat = $strNomor;
			$logs->save();
			
			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $surat;
			#jika ingin dapat last insert id
			#$response->data = $user->user_id;
			return Response::json($response);


		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function deleteSurat() {
		try {
			#deklarasi data input
			$surat_id = Input::get('surat_id');

			$validator = Validator::make(
				array(
					'surat_id' => $surat_id
				),
				array(
					'surat_id' => 'required|numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$user = Surat::where('surat_id', $surat_id)->first();
			if (! is_object($user)) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = 'Surat Not Found';
				$response->data = null;

				return Response::json($response);
			}

			$user->delete();
			
			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $surat_id;
			
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function searchSurat() {
		try {
			#deklarasi data input
			$id = Input::get('id');

			$validator = Validator::make(
				array(
					'id' => $id,
				),
				array(
					'id' => 'numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$surat = Surat::whereNotNull('surat_id');
			
			if (! empty($id)) {
				$surat->where('surat_id', $id);
			}

			$kode_surat = Input::get('kode_surat');
			if (! empty($kode_surat)) {
				$surat->where('kode_surat', 'like', '%' . $kode_surat . '%');
			}

			$_surat = clone($surat);

			$sort_by = 'surat.surat_id';
			$_sort_by = Input::get('sort_by');
			if (! empty($_sort_by)) {
				$sort_by = $_sort_by;
			}

			$sort_mode = 'asc';
			$_sort_mode = Input::get('sort_mode');
			if (! empty($_sort_mode)) {
				$sort_mode = $_sort_mode;
			}

			$total_records = $_surat->count();

			$surat = $surat->orderBy($sort_by, $sort_mode)->get();
			$format = Format::all();
			$active = 'surat';
			$user = User::with('role')->where('user_id', Auth::user()->user_id)->first();
			return View::make('formSurat', compact('user', 'active', 'surat', 'format'));

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function getLast() {
		try {
			#deklarasi data input
			$surat_id = Input::get('surat_id');

			$validator = Validator::make(
				array(
					'surat_id' => $surat_id,
				),
				array(
					'surat_id' => 'numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$logs = Logsurat::with(array('surat' => function($q) use($surat_id) {
						$q->where('surat.surat_id', $surat_id);
					}))
					->whereHas('surat', function($q) use($surat_id) {
						$q->where('surat.surat_id', $surat_id);
					})
					->orderBy('log_id', 'desc')
					->get();

			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $logs;
			#jika ingin dapat last insert id
			#$response->data = $user->user_id;
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function generate() {
		try {
			#deklarasi data input
			$surat_id = Input::get('surat_id');
			$format = Input::get('format');

			$validator = Validator::make(
				array(
					'surat_id' => $surat_id,
					'format' => $format
				),
				array(
					'surat_id' => 'numeric',
					'format' => 'required'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$logs = Logsurat::with(array('surat' => function($q) use($surat_id) {
						$q->where('surat.surat_id', $surat_id);
					}))
					->whereHas('surat', function($q) use($surat_id) {
						$q->where('surat.surat_id', $surat_id);
					})
					->orderBy('log_id', 'desc')
					->first();

			$nomorSurat = explode("/", $logs->nomor_surat);
			$arrFormat = explode("/", $format);
			$newNumber = "";
			$idx = 0;
			foreach ($arrFormat as $a) {
				$temp = $a;
				if ($a == "AUTO") {
					$temp = (int)$nomorSurat[$idx] + 1;
				} elseif ($a == "YEAR") {
					$temp = date('Y');
				}
				$newNumber .= $temp."/";
				$idx++;
			}
			$newNumber = rtrim($newNumber, "/");

			$logs = new Logsurat;
			$logs->user_id = Auth::user()->user_id;
			$logs->surat_id = $surat_id;
			$logs->nomor_surat = $newNumber;
			$logs->save();

			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $logs;
			#jika ingin dapat last insert id
			#$response->data = $user->user_id;
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function tracking() {
		try {
			#deklarasi data input
			$nomor_surat = Input::get('nomor_surat');

			$validator = Validator::make(
				array(
					'nomor_surat' => $nomor_surat
				),
				array(
					'nomor_surat' => 'required'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}
			
			$data = Logsurat::where('nomor_surat', 'like', '%' . $nomor_surat. '%')->with('users')
				->with('surat')->get();

			if (! empty($data)) {
				$response = new stdclass();
				$response->code = '1';
				$response->status = 'success';
				$response->message = 'Successful';
				$response->data = $data;

				return Response::json($response);
			} else {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = 'Failed';
				$response->data = 'Data Not Found';

				return Response::json($response);
			}

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function getFormat() {
		$format = Format::all();
		return Response::json($format);
	}

}
