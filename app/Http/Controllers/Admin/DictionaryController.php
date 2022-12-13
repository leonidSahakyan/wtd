<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Dictionary;
use Illuminate\Routing\Redirector;
use File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DB;

class DictionaryController extends Controller
{
    protected $request;

    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }


    public function index()
    {
        $synced =  DB::table('settings')->select('value')->where('key', 'dictionary_sync')->first();
        // $synced = Settings::where('key', 'dictionary_sync')->first();
        view()->share('synced', $synced->value);
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
            'title' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>0,'errors'=>$validator->errors()->all()]);
        }

        if (str_contains($word->en, ':sku') && !str_contains($request['title'], ':sku')) { 
            return json_encode(array('status' => 0, 'errors' => "Text should have :sku tag"));
        }
        $saveData = array();
        $saveData['en'] = $request['title'];

        DB::table('dictionary')->where('key', $key)->update($saveData);
        DB::table('settings')->where('key', 'dictionary_sync')->update(['value' => 0]);

        return json_encode(array('status' => 1));
    }

    public function loadDataFromSource()
    {
        $this->initPaths();
        $dictionary = File::getRequire(base_path() . '/resources/lang/en/app.php');
        $emails = File::getRequire(base_path() . '/resources/lang/en/emails.php');
        // $sms = File::getRequire(base_path() . '/resources/lang/en/sms.php');

        if (is_array($dictionary)) {
            foreach ($dictionary as $key => $value) {
                $word = Dictionary::where('key', $key)->first();
                if (!$word) {
                    $data['key'] = $key;
                    $data['type'] = 'dictionary';
                    if (isset($dictionary[$key])) {
                        $data['en'] = $dictionary[$key];
                    }
                    DB::table('dictionary')->insert($data);
                }
            }
        }

        if (is_array($emails)) {
            foreach ($emails as $key => $value) {
                $word = Dictionary::where('key', $key)->first();
                if (!$word) {
                    $data['key'] = $key;
                    $data['type'] = 'email';
                    if (isset($emails[$key])) {
                        $data['en'] = $emails[$key];
                    }
                    DB::table('dictionary')->insert($data);
                }
            }
        }

        // if (is_array($sms)) {
        //     foreach ($sms as $key => $value) {
        //         $word = Dictionary::where('key', $key)->first();
        //         if (!$word) {
        //             $data['key'] = $key;
        //             $data['type'] = 'notification';
        //             if (isset($sms[$key])) {
        //                 $data['en'] = $sms[$key];
        //             }
        //             DB::table('dictionary')->insert($data);
        //         }
        //     }
        // }
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
        $query->select('*')->where('type','dictionary');
        $dictionary = $query->get();

        $query = DB::table('dictionary');
        $query->select('*')->where('type','email');
        $emails = $query->get();
        
        // $query = DB::table('dictionary');
        // $query->select('*')->where('type','notification');
        // $sms = $query->get();

        $startString = "<?php\r\n return[\r\n";
        $endString = "];";

        //Dictionary
        $dictionaryString = '';
        foreach ($dictionary as $key => $value) {
            $dictionaryString .= "\t\"" . $value->key . '" => "' . str_replace('"', '\"', $value->en) . "\",\r\n";
        }
        $write = $startString . $dictionaryString . $endString;
        $outputEn = fopen(base_path() . '/resources/lang/en/app.php', 'w');
        fputs($outputEn, $write);

        //emails
        $emailString = '';
        foreach ($emails as $key => $value) {
            $emailString .= "\t\"" . $value->key . '" => "' . str_replace('"', '\"', $value->en) . "\",\r\n";
        }
        $write = $startString . $emailString . $endString;
        $outputEn = fopen(base_path() . '/resources/lang/en/emails.php', 'w');
        fputs($outputEn, $write);

        //emails
        // $smsString = '';
        // foreach ($sms as $key => $value) {
        //     $smsString .= "\t\"" . $value->key . '" => "' . str_replace('"', '\"', $value->en) . "\",\r\n";
        // }
        // $write = $startString . $smsString . $endString;
        // $outputEn = fopen(base_path() . '/resources/lang/en/sms.php', 'w');
        // fputs($outputEn, $write);

        // $write = $startString . $ruString . $endString;
        // $outputRu = fopen(base_path() . '/resources/lang/ru/app.php', 'w');
        // fputs($outputRu, $write);

        // $write = $startString . $amString . $endString;
        // $outputAm = fopen(base_path() . '/resources/lang/am/app.php', 'w');
        // fputs($outputAm, $write);
        

        DB::table('settings')->where('key', 'dictionary_sync')->update(['value' => 1]);

        if (!$this->backup("2")) {
            return json_encode(array('status' => 0, 'message' => "Can't create backup"));
        }

        return json_encode(array('status' => 1, 'message' => "done"));

        exit();
    }

    private function initPaths()
    {
        // $path = base_path() . '/resources/lang/en/app.php';
        // if (!file_exists($path)) {
        //     mkdir(dirname($path), 0755, true);
        //     fopen($path, 'w');
        // }

        $backupPath = base_path() . '/resources/langBackup';
        if (!file_exists($backupPath)) {
            mkdir(dirname($backupPath), 0755, true);
        }
    }
}