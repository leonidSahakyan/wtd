<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Dictionary;
use App\Models\Admin\Settings;
use Illuminate\Routing\Redirector;
use Response;
use View;
use File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DB;
use Log;

class DictionaryController extends Controller
{
    protected $request;

    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }


    public function index()
    {
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'dictionary');




        return view('admin.dictionary.index');
    }

    public function data(Request $request)

    {

        $model = new Dictionary();

        $filter = array('search' => $request->input('search'),
                        'type'=> $request->input('filter_type'));

        $inNews = $model->getAll(
            $this->request->input('start'),
            $this->request->input('length'),
            $filter,
            $this->request->input('sort_field'),
            $this->request->input('sort_dir'));

        $data = json_encode(
            array('data' => $inNews['data'],
            'recordsFiltered' => $inNews['count'],
            'recordsTotal'=> $inNews['count']));
        return $data;
        //return $request;

    }

    public function get()
    {

        $key = $this->request->input('key');

        if ($key) {
            $word = Dictionary::where('key', $key)->first();
            $mode = 'edit';
        }

        if (!$word) {
            return json_encode(array('status' => 0, 'errors' => "Can't find word"));
        }

        $data = json_encode(array(
                'data' => (String)view('admin.dictionary.item', array(
                    'item' => $word,
                    'mode' => $mode
                )),
                'status' => 1
            ));
        return $data;
    }


    public function save(Request $request)
    {
        $key = $this->request->input('key');
        $word = Dictionary::where('key', $key)->first();

        if (!$word) {
            return json_encode([
                'status'  => 0,
                'errors' => "Can't save word"
            ]);
        }

        $validator = \Validator::make($request->all(), [
            'en' => 'required|string|min:2|max:100',
            // 'am' => 'required|string|min:2|max:100',
            // 'ru' => 'required|string|min:2|max:100'
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>0,'errors'=>$validator->errors()->all()]);
        }

        // $data = $this->request->all();

        $saveData = array();
        $saveData['en'] = $request['en'];
        // $saveData['ru'] = $request['ru'];
        // $saveData['am'] = $request['am'];

        DB::table('dictionary')->where('key', $key)->update($saveData);
        // DB::table('settings')->where('key', 'dictionary_sync')->update(['value' => 0]);
        DB::table('settings')->where('key', 'sync_time')->update(['value' => date("Y-m-d H:i:s")]);

        $data = json_encode(array('status' => 1));
        return $data;
    }

    public function loadDataFromSource()
    {
        $this->initPaths();
        $en = File::getRequire(base_path() . '/resources/lang/en/app.php');
        // $ru = File::getRequire(base_path() . '/resources/lang/ru/app.php');
        // $am = File::getRequire(base_path() . '/resources/lang/am/app.php');

        if (is_array($en)) {
            foreach ($en as $key => $value) {
                $word = Dictionary::where('key', $key)->first();
                if (!$word) {
                    $data['key'] = $key;
                    $data['type'] = 'dictionary';
                    if (isset($en[$key])) {
                        $data['en'] = $en[$key];
                    }
                    // if (isset($ru[$key])) {
                    //     $data['ru'] = $ru[$key];
                    // }
                    // if (isset($am[$key])) {
                    //     $data['am'] = $am[$key];
                    // }

                    DB::table('dictionary')->insert($data);
                }
            }
        }

        return true;
    }

    public function backup($prefix)
    {
        // Initialize archive object
        $date = date('d.m.y') . '-' . time();

        $zip = new ZipArchive();
        $zip->open(base_path() . '/resources/langBackup/dictionaryBackUp' . $date . '_' . $prefix . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $rootPath = base_path() . '/resources/lang';

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);


        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();

                $relativePath = substr($filePath, strlen($rootPath) + 1);
                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        // Zip archive will be created only after closing object
        return $zip->close();
    }

    public function sync()
    {
        if (!$this->loadDataFromSource()) {
            return json_encode(array('status' => 0, 'message' => "Can't load new data"));
        }
        if (!$this->backup("1")) {
            return json_encode(array('status' => 0, 'message' => "Can't create backup"));
        }

        $query = DB::table('dictionary');
        $query->select('*');
        $data = $query->get();

        $enString = '';
        // $ruString = '';
        $amString = '';
        foreach ($data as $key => $value) {
            $enString .= "\t\"" . $value->key . '" => "' . str_replace('"', '\"', $value->en) . "\",\r\n";
            // $ruString .= "\t\"" . $value->key . '" => "' . str_replace('"', '\"', $value->ru) . "\",\r\n";
            // $amString .= "\t\"" . $value->key . '" => "' . str_replace('"', '\"', $value->am) . "\",\r\n";
        }

        $startString = "<?php\r\n return[\r\n";
        $endString = "];";

        $write = $startString . $enString . $endString;
        $outputEn = fopen(base_path() . '/resources/lang/en/app.php', 'w');
        fputs($outputEn, $write);

        // $write = $startString . $ruString . $endString;
        // $outputRu = fopen(base_path() . '/resources/lang/ru/app.php', 'w');
        // fputs($outputRu, $write);

        // $write = $startString . $amString . $endString;
        // $outputAm = fopen(base_path() . '/resources/lang/am/app.php', 'w');
        // fputs($outputAm, $write);
        

        DB::table('settings')->where('key', 'dictionary_sync')->update(['value' => 1]);

        Log::info('Sync dictionary - ' . date("d-m-Y h:m:s"));

        if (!$this->backup("2")) {
            return json_encode(array('status' => 0, 'message' => "Can't create backup"));
        }

        return json_encode(array('status' => 1, 'message' => "done"));

        exit();
    }

    private function initPaths()
    {
        $path = base_path() . '/resources/lang/en/app.php';
        if (!file_exists($path)) {
            mkdir(dirname($path), 0755, true);
            fopen($path, 'w');
        }

        $backupPath = base_path() . '/resources/langBackup';
        if (!file_exists($backupPath)) {
            mkdir(dirname($backupPath), 0755, true);
        }
    }
}
