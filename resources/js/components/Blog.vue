<template>
    <v-form @submit.prevent="savePost">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <h2>Create a New Blog</h2>
                </v-col>
                <v-col cols="12">
                    <v-text-field v-model="title" label="Title" variant="outlined" density="compact"
                        :rules="titleRules"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <ckeditor v-model="content" :editor="editor"></ckeditor>
                </v-col>
                <v-col cols="12">
                    <v-btn type="submit" color="primary">Save Post</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>
<script>
import { ref } from "vue";
import axios from "axios";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import { ImageUpload, PictureEditing } from '@ckeditor/ckeditor5-image';
// import { CKBox, CKBoxImageEdit } from "@ckeditor/ckeditor5-ckbox";
// import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
// import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';
// import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
// import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
// import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
// import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';
// import SimpleUploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter';
// import SimpleUploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter';
// import FileRepository from "@ckeditor/ckeditor5-upload/src/filerepository";
export default {
    components: {
        ckeditor: CKEditor.component,
    },
    setup() {
        const content = ref('');
        const title = ref('');
        // const editor = ref(ClassicEditor);
        const titleRules = [
            (v) => !!v || "Title is required",
        ];
        const savePost = async () => {
            await axios.post('/admin/save-blog/post', {
                title: title.value,
                htmlContent: content.value
            })
                .then(response => {
                    console.log('Response:', response.data);
                    if (response.data.status == true) {
                        window.Swal.fire({
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            showConfirmButton: false,
                            icon: 'success',
                            title: `Blog Posted Successfully`,
                        });
                        content.value = '';
                        title.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error saving blog post:', error);
                });
        };
        return {
            titleRules,
            editor: ClassicEditor,
            editorConfig: {
                // plugins: [Essentials, Paragraph, Bold, Italic],
                // toolbar: ['bold', 'italic']
            },
            content,
            savePost, title
            // ckfinder: {
            //     // Upload the images to the server using the CKFinder QuickUpload command.
            //     uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
            // },
            // simpleuploadadapter: {
            //     // The URL that the images are uploaded to.
            //     uploadUrl: 'http://127.0.0.1:8000/upload-blog/image',
            //     // Enable the XMLHttpRequest.withCredentials property.
            //     withCredentials: true,
            //     // Headers sent along with the XMLHttpRequest to the upload server.
            //     headers: {
            //         'X-CSRF-TOKEN': 'CSRF-Token',
            //         Authorization: 'Bearer <JSON Web Token>'
            //     }
            // },
        };
    },
};
</script>
<style>
.ck-editor__editable {
    min-height: 250px;
}
</style>
