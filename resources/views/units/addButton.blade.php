<div class="units-inline-module mt-3 mb-3">

    <div class="unit-inline-blocks">

        <div class="mb-3 border-bottom py-4 px-4 card d-none card-message" id="unit-inline-template">

            <div class="unit-delete unit-inline-delete">Remove</div>

            <input type="hidden" name="unit_inline_id[]" value="0">

            <div class="unit-type-button">
                <div>
                    <label class="form-label">Button type</label>

                    <select name="unit_inline_button_type[]" class="form-select unit-inline-button-type" required>
                        @foreach(App\Helpers\SendButtonHelper::getTypes() as $type => $caption)
                            <option value="{{$type}}" @if($type == 'url') selected @endif>{{$caption}}</option>
                        @endforeach
                    </select>

                    <label class="form-label">Button text</label>
                    <input class="form-control" type="text" name="unit_inline_caption[]">
                    <div class="button-all button-link">
                        <label class="form-label">Button link</label>
                        <input class="form-control" type="url" name="unit_inline_link[]">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <button class="unit-add-inline-button btn btn-custom btn-success btn-primary ">Add button</button>
    </div>
</div>
