@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search Vehicle
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Vehicle Form -->
                    <form action="{{ url('filtervehicles')}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}



                    <!-- Vehicle Model -->
                        <div class="form-group">
                            <label for="vehicle-make" class="col-sm-3 control-label">Vehicle Brand</label>
                            <div class="col-sm-6">
                                <input type="text" name="make" id="vehicle-make" class="form-control" value="">
                            </div>
                        </div>

                        <!-- Vehicle model -->
                        <div class="form-group">
                            <label for="vehicle-model" class="col-sm-3 control-label">Vehicle Model</label>

                            <div class="col-sm-6">
                                <input type="number" name="model" id="vehicle-model" class="form-control" value="">
                            </div>
                        </div>


                        <!-- Add Vehicle Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-search"></i>Find
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($vehicles) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Filtered Vehicels : <p> {{count($vehicles) }} </p>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped vehicle-table">
                            <thead>
                            <th>Model</th>
                            <th>Make</th>
                            <th></th>
                            </thead>
                            <tbody>

                            @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td class="table-text"><div>{{ $vehicle->model }}</div></td>
                                    <td class="table-number"><div>{{ $vehicle->make}}</div></td>
                                    <!-- Vehicle Delete Button -->
                                    <td>
                                        <form action="{{ url('vehicle/'.$vehicle->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
