<input type="hidden" name="unit_add_module" value="1">

<div class="units-module mt-3 mb-3">

    <h3>List of messages</h3>

    <div class="unit-blocks">

        <div class="mb-3 border-bottom py-4 px-4 card d-none card-message" id="unit-template">

            <div class="unit-delete">Remove</div>

            <input type="hidden" name="unit_id[]" value="0">

            <div>
                <label class="form-label">Message type</label>
                <select name="unit_type[]" class="form-select unit-type" required>
                    <option value="text">Text message</option>
                    <option value="photo">Image</option>
                    <option value="photo_text">Image + text</option>
{{--                    <option value="poll">Poll</option>--}}
                </select>
            </div>

            <div class="unit-type-all unit-type-text">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="unit_text[]"></textarea>

                @include('units.addButton')

            </div>

            <div class="unit-type-all unit-type-photo">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="unit_photo[]">
                @include('units.addButton')
            </div>

            <div class="unit-type-all unit-type-photo_text">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="unit_photo_text_photo[]">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="unit_photo_text_text[]"></textarea>
                @include('units.addButton')
            </div>

{{--            <div class="unit-type-all unit-type-poll">--}}
{{--                <label class="form-label">Message</label>--}}
{{--                <textarea class="form-control" name="unit_poll_text[]"></textarea>--}}
{{--                <label class="form-label">multiple choice answer</label>--}}
{{--                <select name="unit_poll_multi[]" class="form-select">--}}
{{--                    <option value="no" selected>No</option>--}}
{{--                    <option value="yes">Yes</option>--}}
{{--                </select>--}}
{{--                <div>--}}
{{--                    <label class="form-label">Option #1</label>--}}
{{--                    <input type="text" class="form-control" name="unit_poll_option_1[]">--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <label class="form-label">Option #2</label>--}}
{{--                    <input type="text" class="form-control" name="unit_poll_option_2[]">--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <label class="form-label">Option #3</label>--}}
{{--                    <input type="text" class="form-control" name="unit_poll_option_3[]">--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <label class="form-label">Option #4</label>--}}
{{--                    <input type="text" class="form-control" name="unit_poll_option_4[]">--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <label class="form-label">Option #5</label>--}}
{{--                    <input type="text" class="form-control" name="unit_poll_option_5[]">--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>

    </div>

    <div>
        <button type="submit"  class="btn btn-custom btn-success btn-primary unit-add-button">Add message</button>
    </div>

</div>
