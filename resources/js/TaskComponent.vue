<template>
    <div class="table-responsive scrollbar">
        <table class="table table-bordered fs--1 mb-0 mt-4">
            <thead class="thead">
            <tr>
                <th>Name</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody class="tbody">
            <tr>
                <td><label for="name" class="form-label">Caption</label></td>
                <td><input type="text" class="form-control" name="name" id="name" v-model="task.name" required>
                </td>
            </tr>

            <tr>
                <td><label for="description" class="form-label">Description</label></td>
                <td>
                    <custom-editor-component id="description" name="description" :value="task.description" :rows="15"/>
                </td>
            </tr>

            <tr>
                <td><label for="type">Type</label></td>
                <td>
                    <select class="form-select" id="type" name="type" v-model="task.type">
                        <option v-for="(type, type_id) in taskTypes" :value="type_id" :selected="task.type === type_id">{{ type }}</option>
                    </select>
                </td>
            </tr>


            <tr v-if="task.type === TYPE_TELEGRAM_CHAT || task.type === TYPE_TELEGRAM_CHANNEL">
                <td><label for="telegram_group">Select telegram channel/group</label></td>
                <td>
                    <select class="form-select" id="telegram_group" name="telegram_group">
                        <template v-for="group in telegramGroups">
                            <option  :value="group.id"
                                    v-if="(group.type === 'channel' && task.type === TYPE_TELEGRAM_CHANNEL) ||
                                    ((group.type === 'group' || group.type === 'supergroup') &&
                                    task.type === TYPE_TELEGRAM_CHAT)"
                                    :selected="task.data.telegram_group_id == group.id">{{ group.name }}
                            </option>
                        </template>
                    </select>
                    <div class="text-muted">Bot must be an administrator in a group/channel</div>
                </td>
            </tr>

            <tr>
                <td><label for="link">Link</label></td>
                <td><input class="form-control" type="text" id="link" name="link" v-model="task.link"></td>
            </tr>

            <tr v-if="task.type === TYPE_LINK_REDIRECT">
                <td><label for="delay">Delay in minutes</label></td>
                <td><input class="form-control" type="number" min="0" id="delay"
                           name="delay" v-model="task.data.delay"></td>
            </tr>

            <tr>
                <td><label for="points">Points</label></td>
                <td><input class="form-control" type="number" id="points" name="points" v-model="task.points" required></td>
            </tr>

            <tr>
                <td><label for="go_it">Link button text</label></td>
                <td><input class="form-control" type="text" id="go_it" name="go_it" v-model="task.go_it"></td>
            </tr>

            <tr>
                <td><label for="project_id">Season</label></td>
                <td>
                    <select class="form-select"
                            id="season_id"
                            name="season_id"
                            v-model="task.season_id"
                    >
                        <option :value="0" :selected="task.season_id === 0">
                            None
                        </option>
                        <option v-for="season in seasons" :value="season.id"
                                :selected="task.season_id === season.id">
                            {{ season.caption }}
                        </option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

const TYPE_LINK_REDIRECT = 0;
const TYPE_TELEGRAM_CHANNEL = 1;
const TYPE_TELEGRAM_CHAT = 2;

export default {
    props: [
        'propTask',
        'telegramGroups',
        'taskTypes',
        'seasons'
    ],
    data() {
        return {
            task: {
                name: "",
                description: "",
                type: "link",
                link: "",
                go_it: "",
                data: {
                    telegram_group_id: 0,
                    delay: 0,
                },
                season_id: 0,
                points: 0
            },
            TYPE_LINK_REDIRECT,
            TYPE_TELEGRAM_CHANNEL,
            TYPE_TELEGRAM_CHAT
        };
    },
    created() {
        if (this.propTask) {
            this.task = this.propTask;
        }
    }
}
</script>
<style>

</style>
