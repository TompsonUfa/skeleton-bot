<?php


namespace App\Services;

use App\Models\TgUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UnitService
{

    public function removeUnits($model_type, $model_id)
    {
        $units = TgUnit::query()
            ->where('model_type', $model_type)
            ->where('model_id', $model_id)
            ->get();
        foreach ($units as $unit)
            $unit->delete();
    }

    public function makeUnits($model_type, $model_id, $user_id, $request)
    {
        $all = $request->all();

        foreach ($all['unit_type'] as $i => $type) {
            $data = [];
            if ($type == 'text') {
                if (!empty($all['unit_text'][$i])) {
                    $data['text'] = $all['unit_text'][$i];
                }

                if (!empty($all['unit_inline_id'][$i])) {
                    $data['buttons'] = [];
                    foreach ($all['unit_inline_id'][$i] as $j => $value) {
                        $data['buttons'][] = $all['unit_inline_id'][$i][$j];
                    }
                }
            }
            if ($type == 'photo') {
                if (!empty($all['unit_photo'][$i])) {
                    $data['image'] = $all['unit_photo'][$i]->store('images');
                }

                if (!empty($all['unit_inline_id'][$i])) {
                    $data['buttons'] = [];
                    foreach ($all['unit_inline_id'][$i] as $j => $value) {
                        $data['buttons'][] = $all['unit_inline_id'][$i][$j];
                    }
                }

            }
            if ($type == 'photo_text') {
                if (!empty($all['unit_photo_text_photo'][$i])) {
                    $data['image'] = $all['unit_photo_text_photo'][$i]->store('images');
                }
                if (!empty($all['unit_photo_text_text'][$i])) {
                    $data['text'] = $all['unit_photo_text_text'][$i];
                }

                if (!empty($all['unit_inline_id'][$i])) {
                    $data['buttons'] = [];
                    foreach ($all['unit_inline_id'][$i] as $j => $value) {
                        $data['buttons'][] = $all['unit_inline_id'][$i][$j];
                    }
                }

            }
            if ($type == 'poll') {
                if (!empty($all['unit_poll_text'][$i])) {
                    $data['text'] = $all['unit_poll_text'][$i];
                }
                if (!empty($all['unit_poll_multi'][$i])) {
                    $data['multi'] = $all['unit_poll_multi'][$i];
                }
                if (!empty($all['unit_poll_option_1'][$i])) {
                    $data['option_1'] = $all['unit_poll_option_1'][$i];
                }
                if (!empty($all['unit_poll_option_2'][$i])) {
                    $data['option_2'] = $all['unit_poll_option_2'][$i];
                }
                if (!empty($all['unit_poll_option_3'][$i])) {
                    $data['option_3'] = $all['unit_poll_option_3'][$i];
                }
                if (!empty($all['unit_poll_option_4'][$i])) {
                    $data['option_4'] = $all['unit_poll_option_4'][$i];
                }
                if (!empty($all['unit_poll_option_5'][$i])) {
                    $data['option_5'] = $all['unit_poll_option_5'][$i];
                }
            }

            if (!empty($data)) {
                $unit = new TgUnit();
                $unit->type = $type;
                $unit->model_type = $model_type;
                $unit->model_id = $model_id;
                $unit->user_id = $user_id;
                $unit->data = json_encode($data);
                $unit->save();
            }
        }

    }

    public function updateUnits($model_type, $model_id, $user_id, $request)
    {
        $all = $request->all();

        $units = TgUnit::query()
            ->where('model_type', $model_type)
            ->where('model_id', $model_id)
            ->get();

        foreach ($units as $unit) {
            $b = false;
            foreach ($all['unit_id'] as $item) {
                if ($item == $unit->id) {
                    $b = true;
                    break;
                }
            }
            if (!$b) {
                $unit->delete();
            }
        }

        foreach ($all['unit_type'] as $i => $type) {
            $data = [];
            if ($type == 'text') {
                if (!empty($all['unit_text'][$i])) {
                    $data['text'] = $all['unit_text'][$i];
                }

                if (!empty($all['unit_inline_id'][$i])) {
                    $data['buttons'] = [];
                    foreach ($all['unit_inline_id'][$i] as $j => $value) {
                        $data['buttons'][] = $all['unit_inline_id'][$i][$j];
                    }
                }

                if(!empty($all['unit_respond_type'][$i])) {
                    $data['respond_type'] = $all['unit_respond_type'][$i];
                }
            }
            if ($type == 'photo') {
                if (!empty($all['unit_photo'][$i])) {
                    $data['image'] = $all['unit_photo'][$i]->store('images');
                } else {
                    if (!empty($all['unit_id'][$i])) {
                        $unit = TgUnit::query()
                            ->find($all['unit_id'][$i]);
                        $data = json_decode($unit->data, true);
                    }
                }

                if (!empty($all['unit_inline_id'][$i])) {
                    $data['buttons'] = [];
                    foreach ($all['unit_inline_id'][$i] as $j => $value) {
                        $data['buttons'][] = $all['unit_inline_id'][$i][$j];
                    }
                }

            }

            if ($type == 'photo_text') {
                if (!empty($all['unit_photo_text_photo'][$i])) {
                    $data['image'] = $all['unit_photo_text_photo'][$i]->store('images');
                } else {
                    if (!empty($all['unit_id'][$i])) {
                        $unit = TgUnit::query()
                            ->find($all['unit_id'][$i]);
                        $data['image'] = json_decode($unit->data, true)['image'];
                    }
                }
                if (!empty($all['unit_photo_text_text'][$i])) {
                    $data['text'] = $all['unit_photo_text_text'][$i];
                }

                if (!empty($all['unit_inline_id'][$i])) {
                    $data['buttons'] = [];
                    foreach ($all['unit_inline_id'][$i] as $j => $value) {
                        $data['buttons'][] = $all['unit_inline_id'][$i][$j];
                    }
                }

            }

            if ($type == 'poll') {
                if (!empty($all['unit_poll_text'][$i])) {
                    $data['text'] = $all['unit_poll_text'][$i];
                }
                if (!empty($all['unit_poll_multi'][$i])) {
                    $data['multi'] = $all['unit_poll_multi'][$i];
                }
                if (!empty($all['unit_poll_option_1'][$i])) {
                    $data['option_1'] = $all['unit_poll_option_1'][$i];
                }
                if (!empty($all['unit_poll_option_2'][$i])) {
                    $data['option_2'] = $all['unit_poll_option_2'][$i];
                }
                if (!empty($all['unit_poll_option_3'][$i])) {
                    $data['option_3'] = $all['unit_poll_option_3'][$i];
                }
                if (!empty($all['unit_poll_option_4'][$i])) {
                    $data['option_4'] = $all['unit_poll_option_4'][$i];
                }
                if (!empty($all['unit_poll_option_5'][$i])) {
                    $data['option_5'] = $all['unit_poll_option_5'][$i];
                }
            }


            if (!empty($data)) {
                if (!empty($all['unit_id'][$i])) {
                    $unit = TgUnit::query()
                        ->find($all['unit_id'][$i]);
                } else {
                    $unit = new TgUnit();
                    $unit->model_type = $model_type;
                    $unit->model_id = $model_id;
                    $unit->user_id = $user_id;
                }
                $unit->type = $type;
                $unit->data = json_encode($data);
                $unit->save();
            }
        }


    }

}
