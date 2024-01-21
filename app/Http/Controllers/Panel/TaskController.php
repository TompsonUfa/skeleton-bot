<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TgGroup;
use App\Models\TgUser;
use App\Models\UserTask;
use App\Services\Season;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('simple.auth')->except('redirectLink');
    }

    public function index(): View
    {
        $tasks = Task::query()
            ->with(['season'])
            ->paginate();

        $seasons = Season::getAllSeasons();

        return view('panel.tasks.index', compact('tasks', 'seasons'));
    }

    public function add()
    {
        $groups = TgGroup::query()->where('status', 'administrator')->get();
        $seasons = \App\Models\Season::all();
        return view('panel.tasks.add', compact('groups', 'seasons'));
    }

    public function add_(Request $request)
    {
        $all = $request->all();
        $task = new Task();
        $task->name = $all['name'];
        $task->description = $all['description'];
        $task->type = $all['type'];
        $task->link = $all['link'] ?? '';
        $task->points = $all['points'] ?? 0;
        $task->season_id = $all['season_id'] ?? 0;
        $task->go_it = $all['go_it'] ?? "";

        if ($task->type == Task::TYPE_TELEGRAM_CHANNEL || $task->type == Task::TYPE_TELEGRAM_CHAT) {
            $data = ['telegram_group_id' => $all['telegram_group']];

            $group = TgGroup::query()->find($all['telegram_group']);
            if($group){
                $data['telegram_group_tid'] = $group->tid;
            }
            $task->data = $data;
        }
        if ($task->type == Task::TYPE_LINK_REDIRECT) {
            $data = ['delay' => $all['delay']];

            $task->data = $data;
        }

        $task->save();
        return redirect()->route('tasks.index');
    }

    public function detail($id)
    {
        $task = Task::query()->find($id);

        $groups = TgGroup::query()->where('status', 'administrator')->get();

        if (empty($task['data'])) {
            $task['data'] = [];
        }

        $seasons = \App\Models\Season::all();

        return view('panel.tasks.detail', compact('task', 'groups', 'seasons'));
    }

    public function detail_(Request $request, $id)
    {
        $all = $request->all();

        $task = Task::query()->find($id);

        $task->name = $all['name'];
        $task->description = $all['description'];
        $task->type = $all['type'];
        $task->link = $all['link'] ?? '';
        $task->points = $all['points'] ?? 0;
        $task->season_id = $all['season_id'] ?? 0;
        $task->go_it = $all['go_it'] ?? "";

        if ($task->type == Task::TYPE_TELEGRAM_CHANNEL || $task->type == Task::TYPE_TELEGRAM_CHAT) {
            $data = ['telegram_group_id' => $all['telegram_group']];

            $group = TgGroup::query()->find($all['telegram_group']);
            if($group){
                $data['telegram_group_tid'] = $group->tid;
            }
            $task->data = $data;
        }
        if ($task->type == Task::TYPE_LINK_REDIRECT) {
            $data = ['delay' => $all['delay']];

            $task->data = $data;
        }

        $task->save();

        return redirect()->route('tasks.index');
    }

    public function delete($id)
    {
        $task = Task::query()->find($id);
        if ($task) {
            $task->usersTasks()->delete();
            $task->delete();
        }
        return redirect()->route('tasks.index');
    }

    public function redirectLink($hash)
    {
        $userTask = UserTask::query()->where('link_hash', $hash)->first();
        if ($userTask && $userTask->task && $userTask->task->season_id == Season::getIdActiveSeason()) {
            if (!$userTask->link_redirect) {
                $userTask->link_redirect = 1;
                $userTask->save();
            }
            return redirect($userTask->task->link);
        }
        abort(404);
    }

    public function usersCompletedTask($id)
    {
        $task = Task::query()->find($id);
        if (!$task) {
            return [];
        }

        $users = $task->usersCompletedTask()->orderBy('user_tasks.updated_at')->paginate(50);

        $users->transform(function ($item) {
            $item->completed_at = Carbon::createFromTimeString($item->pivot->updated_at ?? '')
                ->timezone('Europe/Moscow')
                ->toDateTimeString();

            return $item;
        });

        return $users;
    }

    public function export(Request $request)
    {
        $task = $request->get('task');
        $season = $request->get('season');
        if ($task == 'all') {
            $tasks = Task::query()
                ->where('season_id', $season)
                ->pluck('id');
            $users = TgUser::query()
                ->whereHas('userTasks', function ($q) use ($tasks) {
                    $q->whereIn('task_id', $tasks)
                        ->where('status', UserTask::STATUS_SUCCESS);
                }, '>=', count($tasks))
                ->where('is_banned', 0)
                ->get();
        } else {
            $users = TgUser::query()
                ->whereHas('userTasks', function ($q) use ($task) {
                    $q->where('task_id', $task)
                        ->where('status', UserTask::STATUS_SUCCESS);
                })
                ->where('is_banned', 0)
                ->get();
        }

        return view('panel.tasks.export', compact('users'));
    }
}
