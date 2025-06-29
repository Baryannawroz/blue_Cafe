<x-add-modal title="{{ __('all.add category') }}" btnText="{{ __('all.category') }}" id="add-category"
    class="{{ $class }}">
    <form method="POST" action="/cats/add" autocomplete="off">
        {{ csrf_field() }}
        <div class="col-md-6 d-none">
            <label class="form-label">{{ __('all.stock') }}</label>
            <select name="store_id" class="form-control" required>
                <option value="1" selected></option>
                {{-- @foreach ($stores as $store)
                <option value="{{ $store->id }}">{{ $store->name }}</option>كؤ
                @endforeach --}}
            </select>
        </div>
        <div class="col-12">
            <label class="form-label"> {{ __('all.category') }}</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label"> {{ __('all.priority') }}</label>
            <input type="number" name="priority" class="form-control" required>
        </div>
</x-add-modal>
