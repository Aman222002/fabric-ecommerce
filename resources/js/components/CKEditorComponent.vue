<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { ref } from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
export default {
    name: 'CKEditorComponent',
    components: {
        ckeditor: CKEditor,
    },
    setup() {
        const editorData = ref('<p>Initial content</p>');
        const editorConfig = {
            toolbar: ['bold', 'italic', '|', 'undo', 'redo'],
        };

        return {
            editor: ClassicEditor,
            editorData,
            editorConfig,
        };
    },
};
</script>