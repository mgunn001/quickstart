<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use App\Vehicle;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {


    /**
     * Show a welcome Dashboard
     */
    Route::get('/welcome', function () {
        return view('welcome');
    });


    /**
     * Show Vehicle Dashboard
     */
    Route::get('/viewvehicles', function () {
        return view('vehicles', [
            'vehicles' => Vehicle::orderBy('created_at', 'asc')->get()
        ]);
    });

    /**
     * Show Vehicle Dashboard
     */
    Route::get('/searchvehicles', function () {



        return view('filteredvehicles', [
            'vehicles' => Vehicle::orderBy('created_at', 'asc')->get()
        ]);
    });


    /**
     * Show Search Dashboard
     */
    Route::post('/filtervehicles', function (Request $request) {

        $validator = Validator::make($request->all(), [
            'make' => 'required|max:255',
            'model' => 'required|max:4|min:4',
        ]);

        if ($validator->fails()) {
            return redirect('/searchvehicles')
                ->withInput()
                ->withErrors($validator);
        }

        return view('filteredvehicles', [
            'vehicles' => Vehicle::where('make','like', '%'.$request->make.'%')
                            ->where('model',$request->model)
                            ->orderBy('created_at', 'asc')->get()


        ]);
    });

    /**
     * Show Task Dashboard
     */
    Route::get('/viewtasks', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });



    /**
     * Add New Task
     */
    Route::post('/vehicle', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'make' => 'required|max:255',
            'model' => 'required|max:4|min:4',
        ]);

        if ($validator->fails()) {
            return redirect('/viewvehicles')
                ->withInput()
                ->withErrors($validator);
        }

        $vehicle = new Vehicle;
        print "model from request object";
        $vehicle->model = $request->model;
        $vehicle->make = $request->make;
        $vehicle->save();

        return redirect('/viewvehicles');
    });




    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/viewtasks')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/viewtasks');
    });

    /**
     * Delete Vehicle
     */
    Route::delete('/vehicle/{id}', function ($id) {
        Vehicle::findOrFail($id)->delete();

        return redirect('/viewvehicles');
    });


    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/viewtasks');
    });
});
