<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class AdminAuthController extends Controller
{
    public function viewData(Request $request)
    {

        if ($request->has('search')) {
            $users = User::where('name', 'LIKE', "%{$request->search}%")
                ->orWhere('email', 'LIKE', "%{$request->search}%")
                ->orWhere('mobile_no', 'LIKE', "%{$request->search}%")
                ->orWhere('status', 'LIKE', "%{$request->search}%")
                ->get();
        } else {
            $users = User::get();
        }

        return view('admin.auth.view', compact('users'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->status == 'active') {
            $status = 'inactive';
        } else {
            $status = 'active';
        }
        $values = array('status' => $status);
        $user = $user->update($values);

        return back()->withSuccess('Status change successfully.');
    }

    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (auth()->guard('admin')->attempt(array($fieldType => $request->username, 'password' => $request->password))) {
            $user = auth()->guard('admin')->user();
            return redirect()->route('adminDashboard')->withSuccess('You have Successfully loggedin');
        } else {
            return back()->withDanger('Oppes! You have entered invalid credentials');
        }
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        return redirect()->route('adminLogin')->withSuccess('You are logout sucessfully');
    }

    public function exportCSV(Request $request)
    {

        $fileName = 'tasks.csv';
        $tasks = User::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Name', 'Email', 'Created_at', 'Updated_at', 'Mobile_no', 'Username', 'Status');

        $callback = function () use ($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                fputcsv($file, array($task->name, $task->email, $task->created_at, $task->updated_at, $task->mobile_no,$task->username,$task->status));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
