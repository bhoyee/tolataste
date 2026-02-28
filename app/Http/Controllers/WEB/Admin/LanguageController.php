<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LanguageController extends Controller
{

    public function adminLnagugae($code)
    {
        $parentDir = dirname(app_path());

        $data = include($parentDir . "/lang/{$code}/admin.php");

        return view('admin.admin_language', compact('data'));
    }

    public function updateAdminLanguage(Request $request, $code)
    {
        $parentDir = dirname(app_path());
        $dataArray = [];
        foreach ($request->values as $index => $value) {
            $dataArray[$index] = $value;
        }

        file_put_contents($parentDir . "/lang/{$code}/admin.php", "");
        $dataArray = var_export($dataArray, true);
        file_put_contents($parentDir . "/lang/{$code}/admin.php", "<?php\n return {$dataArray};\n ?>");

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function adminValidationLnagugae($code)
    {
        $parentDir = dirname(app_path());
        $data = include($parentDir . "/lang/{$code}/admin_validation.php");

        return view('admin.admin_validation_language', compact('data'));
    }

    public function updateAdminValidationLnagugae(Request $request, $code)
    {
        $parentDir = dirname(app_path());
        $dataArray = [];
        foreach ($request->values as $index => $value) {
            $dataArray[$index] = $value;
        }
        file_put_contents($parentDir . "/lang/{$code}/admin_validation.php", "");
        $dataArray = var_export($dataArray, true);
        file_put_contents($parentDir . "/lang/{$code}/admin_validation.php", "<?php\n return {$dataArray};\n ?>");

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function websiteLanguage($code)
    {
        $parentDir = dirname(app_path());
        $data = include($parentDir . "/lang/{$code}/user.php");

        return view('admin.language', compact('data'));
    }

    public function updateLanguage(Request $request, $code)
    {
        $parentDir = dirname(app_path());
        $dataArray = [];
        foreach ($request->values as $index => $value) {
            $dataArray[$index] = $value;
        }
        file_put_contents($parentDir . "/lang/{$code}/user.php", "");
        $dataArray = var_export($dataArray, true);
        file_put_contents($parentDir . "/lang/{$code}/user.php", "<?php\n return {$dataArray};\n ?>");

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }


    public function websiteValidationLanguage($code)
    {
        $parentDir = dirname(app_path());
        $data = include($parentDir . "/lang/{$code}/user_validation.php");

        return view('admin.website_validation_language', compact('data'));
    }

    public function updateValidationLanguage(Request $request, $code)
    {
        $parentDir = dirname(app_path());
        $dataArray = [];
        foreach ($request->values as $index => $value) {
            $dataArray[$index] = $value;
        }

        file_put_contents($parentDir . "/lang/{$code}/user_validation.php", "");
        $dataArray = var_export($dataArray, true);
        file_put_contents($parentDir . "/lang/{$code}/user_validation.php", "<?php\n return {$dataArray};\n ?>");

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
