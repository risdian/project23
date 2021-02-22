<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Payment Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group pt-2">
                <label class="control-label" for="toyyibpay_payment_method">Toyyibpay Payment Method</label>
                <select name="toyyibpay_payment_method" id="toyyibpay_payment_method" class="form-control">
                    <option value="1" {{ (config('settings.toyyibpay_payment_method')) == 1 ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ (config('settings.toyyibpay_payment_method')) == 0 ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="toyyibpay_category_id">Category ID</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter toyyibpay category Id"
                    id="toyyibpay_category_id"
                    name="toyyibpay_category_id"
                    value="{{ config('settings.toyyibpay_category_id') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="toyyibpay_secret_id">Secret ID</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter toyyibpay secret id"
                    id="toyyibpay_secret_id"
                    name="toyyibpay_secret_id"
                    value="{{ config('settings.toyyibpay_secret_id') }}"
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
