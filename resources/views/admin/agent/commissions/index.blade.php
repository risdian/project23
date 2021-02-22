@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cogs"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row user">

        <div class="col-md-3">
            <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <li class="nav-item"><a class="nav-link active" href="#user-commissions" data-toggle="tab">Commissions</a></li>
            </ul>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
            <div class="tab-pane active" id="user-commissions">
                <div class="tile user-commissions">
                <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
                    @csrf
                    <h3 class="tile-title">Commissions Settings</h3>
                    <hr>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="agent_commission">Agent Commission</label>
                            <input
                                class="form-control"
                                type="number"
                                placeholder="Enter Agent Commission value"
                                id="agent_commission"
                                name="agent_commission"
                                value="{{ config('settings.agent_commission') }}"
                            />
                        </div>
                    </div>
                    <div class="tile-footer">
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right">
                                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>


@endsection
