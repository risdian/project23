<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Personal Shopper Tier</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="personal_shopper_tier_1">Personal shopper tier 1 commission ( % )</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Enter personal shopper tier 1 commission %"
                    id="personal_shopper_tier_1"
                    name="personal_shopper_tier_1"
                    value="{{ config('settings.personal_shopper_tier_1') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="personal_shopper_tier_2">Personal shopper tier 2 commission ( % )</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site title"
                    id="personal_shopper_tier_2"
                    name="personal_shopper_tier_2"
                    value="{{ config('settings.personal_shopper_tier_2') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="personal_shopper_tier_3">PS 1 get commission from PS 2 ( % )</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site title"
                    id="personal_shopper_tier_3"
                    name="personal_shopper_tier_3"
                    value="{{ config('settings.personal_shopper_tier_3') }}"
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
