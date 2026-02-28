<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageManagerController extends Controller
{
    public function index()
    {
        return view('admin.languages', [
            'languages' => Language::all(),
        ]);
    }

    public function create()
    {
        return view('admin.create_language');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:languages',
            'code' => 'required|unique:languages',
            'direction' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'code.required' => trans('admin_validation.Code is required'),
            'direction.required' => trans('admin_validation.Direction is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $lang = Language::create($request->only('name', 'code', 'direction'));

        if ($lang) {
            $code = strtolower($lang->code);
            $parentDir = dirname(app_path());

            $files = [
                'admin_validation.php',
                'admin.php',
                'user.php',
                'user_validation.php'
            ];

            foreach ($files as $file) {
                $sourcePath = $parentDir . "/lang/en/{$file}";
                $destinationPath = $parentDir . "/lang/{$code}/{$file}";

                if (file_exists($sourcePath)) {
                    if (!file_exists(dirname($destinationPath))) {
                        mkdir(dirname($destinationPath));
                    }

                    copy($sourcePath, $destinationPath);
                }
            }
        }

        $notification = trans('admin_validation.Created Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.languages.index')->with($notification);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);

        return view('admin.edit_language', [
            'language' => $language,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:languages,name,' . $id,
            'direction' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'code.required' => trans('admin_validation.Code is required'),
            'name.unique' => trans('admin_validation.Name is taken'),
            'code.unique' => trans('admin_validation.Code is taken'),
            'direction.required' => trans('admin_validation.Direction is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $lang = Language::findOrFail($id);
        $oldCode = $lang->code;
        $language = $lang->update($request->only('name', 'direction'));
        $code = strtolower($lang->code);

        if ($language && ($oldCode !== $code) && ($code !== 'en')) {
            $parentDir = dirname(app_path());

            $files = [
                'admin_validation.php',
                'admin.php',
                'user.php',
                'user_validation.php'
            ];

            foreach ($files as $file) {
                $sourcePath = $parentDir . "/lang/en/{$file}";
                $destinationPath = $parentDir . "/lang/{$code}/{$file}";

                if (file_exists($sourcePath)) {
                    if (!file_exists(dirname($destinationPath))) {
                        mkdir(dirname($destinationPath));
                    }

                    copy($sourcePath, $destinationPath);
                }
            }

            if ($oldCode !== $code && $code !== 'en') {
                $parentDir = dirname(app_path());
                $destinationPath = $parentDir . "/lang/{$oldCode}";
                try {
                    $this->deleteFolder($destinationPath);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');

        return redirect()->route('admin.languages.index')->with($notification);
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $code = $language->code;
        if ($language->code == app()->getLocale() || $language->code == 'en') {
            $notification = trans('admin.Deleting Failed');
            $notification = array('messege' => $notification, 'alert-type' => 'error');

            return redirect()->route('admin.languages.index')->with($notification);
        }

        if ($language->delete() && $code !== 'en') {
            $parentDir = dirname(app_path());
            $destinationPath = $parentDir . "/lang/{$code}";
            $this->deleteFolder($destinationPath);
        }

        $notification = trans('admin_validation.Deleted Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');

        return redirect()->route('admin.languages.index')->with($notification);
    }

    private function deleteFolder($folderPath)
    {
        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $this->deleteFolder($folderPath . '/' . $file);
                }
            }
            rmdir($folderPath);
        } else {
            unlink($folderPath);
        }
    }
}
