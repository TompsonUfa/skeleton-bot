<template>
    <div class="mb-4">
        <label
            v-if="label"
            class="form-label"
        >
            {{ label }}
        </label>

        <QuillEditor
            v-model:content="textContent"
            :options="options"
            ref="myEditor"
            content-type="html"
        ></QuillEditor>

        <input
            :id="id"
            :name="name"
            :value="textContent"
            type="hidden"
        >

        <div
            v-if="error"
            class="invalid-feedback"
        >
            {{ error }}
        </div>
    </div>
</template>

<script>
import {QuillEditor} from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    name: 'CustomEditorComponent',
    components: {
        QuillEditor,
    },
    props: {
        id: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        value: {
            default: '',
        },
        placeholder: {
            type: String
        },
        label: {
            type: String
        },
        error: {
            type: String
        },
        rows: {
            type: [String, Number],
            default: 4,
        }
    },
    mounted() {
        this.textContent = this.value;
    },
    data() {
        return {
            textContent: '',
            options: {
                modules: {
                    toolbar: [
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'code',
                    ],
                },
                placeholder: this.placeholder || 'Enter message',
                theme: 'snow',
            },
        };
    },
};
</script>

<style lang="sass" scoped>
.form-label
    font-weight: 600
</style>
