<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminsController extends Controller {
	public function index() {
		$admins = Admin::whereHas('roles', function ($q) {
			$q->where('key', 'super-admin');
		})->paginate(20);

		return view('admin.admins.index', [
			'admins' => $admins
		]);
	}

	public function create() {
		return view('admin.admins.create');
	}

	public function edit($id) {
		$user = Admin::find($id);

		return view('admin.admins.edit', [
			'user' => $user
		]);
	}

	public function store(StoreAdminRequest $request) {

		$role = Role::where('key', 'super-admin')->first();

		if (!$role) {
			throw new \Exception('Кто-то проебал запустить сид?!!!!');
		}
		$data = $request->all();
		Admin::create($data)->roles()->attach($role->id);

		return redirect()->action('Admin\AdminsController@index')->with('success-message', 'Super admin successfully created');
	}

	public function update(UpdateAdminRequest $request, $id) {
		$user = Admin::find($id);
		$data = array_filter($request->all());

		$user->update($data);
		return redirect()->action('Admin\AdminsController@index')->with('success-message', 'Super Admin successfully updated');
	}
}
