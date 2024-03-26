<template>
    <p style="text-align: center; font-size: 20px; margin-top: 20px">Blogs</p>
    <DxDataGrid :show-borders="true" :data-source="dataSource" ref="dataGridRef" @editing-start="logEvent"
        @edit-canceling="cancelEdit(data)">
        <DxSearchPanel :visible="true" :placeholder="'Search'" :width="300" />
        <DxToolbar>
            <DxGridItem template="dropDown2" :location="'before'" />
            <DxGridItem template="addButton" :location="'after'"></DxGridItem>
            <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
        </DxToolbar>
        <DxLoadPanel :enabled="true" />
        <DxSearchPanel :visible="true" />
        <DxColumn caption="Action" :allow-editing="false" cell-template="customButtonTemplate" v-if="!showcolumn">
        </DxColumn>
        <DxColumn data-field="title" data-type="string" :visible="!showcolumn">
        </DxColumn>
        <DxColumn data-field="created_at" data-type="string" :visible="!showcolumn" v-if="!showcolumn"></DxColumn>
        <DxColumn data-field="status" data-type="string" :visible="!showcolumn" v-if="!showcolumn"> </DxColumn>
        <DxColumn data-field="published_by" data-type="string" :visible="!showcolumn" v-if="!showcolumn"> </DxColumn>
        <DxColumn cell-template="Dxbutton"></DxColumn>
        <DxColumn data-field="content" cell-template="ckeditor" edit-cell-template="ckeditor" :visible="showcolumn">
        </DxColumn>
        <template #addButton>
            <DxButton icon="add" @click="openAddDialog"></DxButton>
        </template>
        <template #Dxbutton="{ data }">
            <v-btn prepend-icon="mdi-pencil" class="edit-btn bg-primary" @click="editBlog(data.data)"></v-btn>
            <!-- <v-spacer></v-spacer> -->
            <v-btn prepend-icon="mdi-delete" class="bg-primary" @click="deleteBlog(data.data.id)"></v-btn>
        </template>
        <template #ckeditor>
            <h2>Edit Blog</h2>
            <!-- <v-text-field v-model="title" variant="outlined" label="Title" density="compact" outlined></v-text-field> -->
            <div class="editor">
                <ckeditor v-model="content" :editor="editor"></ckeditor>
            </div>
        </template>
        <template #dropDown2>
            <DxDropDownBox :accept-custom-value="true" @value-change="selectStatus" label="Select status"
                labelMode="floating" v-model:value="selectedStatus" v-model:opened="DropDown2">
                <DxList :data-source="items" selection-mode="single" @item-click="selectStatus">
                </DxList>
            </DxDropDownBox>
        </template>
        <template #customButtonTemplate="{ data }">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn height="30" color="primary" v-bind="props">
                        <v-icon>mdi-menu-down</v-icon>
                    </v-btn>
                </template>
                <v-card>
                    <v-list v-for="item in blogActions" :key="item.text">
                        <template v-if="selectedStatus === 'Draft'">
                            <v-list-item class="dropdown" @click="duplicateJob(data.row.data.id, item.text)">
                                {{ item.text }}
                            </v-list-item>
                        </template>
                        <template v-else>
                            <v-list-item v-if="item.text !== 'Post Blog'" class="dropdown">
                                {{ item.text }}
                            </v-list-item>
                        </template>
                        <!-- <v-list-item v-for="item in blogActions" :key="item.text" class="dropdown"
                            @click="duplicateBlog(data.row.data.id, item.text)">{{ item.text }}</v-list-item> -->
                    </v-list>
                </v-card>
            </v-menu>
        </template>
    </DxDataGrid>

    <v-container>
        <v-dialog max-width="1000" v-model="showDialog" persistent>
            <v-card>
                <v-card-text>
                    <v-form @submit.prevent="savePost(updateId)" ref="form">
                        <h2>Edit Blog</h2>
                        <v-text-field v-model="title" variant="outlined" label="Title" density="compact" outlined
                            :rules="titleRules"></v-text-field>
                        <v-file-input label="Select new featured Image" v-model="selectedImage" @change="previewImage"
                            accept="image/*" variant="outlined" density="compact" outlined></v-file-input>
                        <v-row class="mb-2" v-if="imagePreview">
                            <p style="font:bold;margin-left: 11px;">Selected Featured Image</p>
                            <v-col cols="12">
                                <v-img :src="imagePreview" max-width="300" max-height="300"></v-img>
                            </v-col>
                        </v-row>
                        <div class="editor">
                            <ckeditor v-model="content" :editor="editor"></ckeditor>
                        </div>
                        <v-btn type="submit">Save Post</v-btn>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-primary" text="Close Dialog" @click="showDialog = false"></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog max-width="1000" v-model="showAddDialog" persistent>
            <v-card>
                <v-card-text>
                    <v-form @submit.prevent="addPost(selectedImage)" ref="form">
                        <h2>Add Blog</h2>
                        <v-text-field v-model="title" variant="outlined" label="Title" density="compact" outlined
                            :rules="titleRules"></v-text-field>
                        <v-file-input label="Add featured Image" v-model="selectedImage" @change="previewImage"
                            accept="image/*" :rules="imageRules"></v-file-input>
                        <v-row v-if="imagePreview">
                            <v-col cols="12">
                                <v-img :src="imagePreview" max-width="300" max-height="300"></v-img>
                            </v-col>
                        </v-row>
                        <div class="editor">
                            <ckeditor v-model="content" :editor="editor"></ckeditor>
                        </div>
                        <v-btn type="submit">Add Post</v-btn>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-primary" text="Close Dialog" @click="closeAddDialog"></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import dxGridStore from "../composition/dxGridStore";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    components: {
        ckeditor: CKEditor.component,
    },
    setup() {
        const blogs = ref({});
        const showDialog = ref(false);
        const showAddDialog = ref(false);
        const form = ref(null);
        const content = ref('');
        const title = ref('');
        const updateId = ref();
        const selectedStatus = ref("All");
        const params = ref({});
        const DropDown2 = ref(false);
        const dataGridRef = ref(null);
        const blogActions = ref([
            {
                text: "Duplicate",
            },
            {
                text: "Post Blog",
            },
        ]);
        const selectStatus = (e) => {
            const value = e.itemData.text;
            params.value = { type: value };
            selectedStatus.value = value;
            DropDown2.value = false;
            refreshTable(dataGridRef);
        };
        const loadUrl = `/admin/blog/fetch/`;
        const insertURL = `/admin//save-blog/post`
        const deleteUrl = `/admin/delete/blog/`;
        const updateURL = `/admin/update/blog`;
        const items = ref([
            {
                text: "All",
                value: 1,
            },
            {
                text: "Active",
                value: 2,
            },
            {
                text: "Draft",
                value: 3,
            },
        ]);
        const selectedImage = ref(null);
        const imagePreview = ref(null);
        const titleRules = [(v) => !!v || "Title is required"];
        const imageRules = [(v) => !!v || "Featured Image is required"];
        const previewImage = (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.value = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.value = null;
            }
        };

        // Automatically clear image preview when there is no image selected
        watch(selectedImage, (newValue) => {
            if (!newValue) {
                imagePreview.value = null;
            }
        });
        const duplicateBlog = (id, value) => {
            console.log(value);
            if (value == 'Duplicate') {
                try {
                    axios.post("/admin/blog/draft/", {
                        params: {
                            id: id,
                            type: value,
                        },
                    }).then((response) => {
                        console.log(response.data);
                        window.Swal.fire({
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            showConfirmButton: false,
                            icon: 'success',
                            title: `Blog Drafted Successfully`,
                        });
                    }).catch((err) => {
                        console.log(err);
                    })
                } catch (error) {
                    console.log(error);
                }
            } else {
                axios.post("/admin/blog/post/", {
                    params: {
                        id: id,
                        type: value,
                    },
                }).then((response) => {
                    console.log(response.data);
                    window.Swal.fire({
                        toast: true,
                        position: 'top-end',
                        timer: 2000,
                        showConfirmButton: false,
                        icon: 'success',
                        title: `Blog Posted Successfully`,
                    });
                }).catch((err) => {
                    console.log(err);
                    if (err.response.status == '406') {
                        window.Swal.fire({
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            showConfirmButton: false,
                            icon: 'error',
                            title: `You already posted this blog`,
                        });
                    }
                })
            }
        }
        // try {
        //     axios.post("/admin/blog/draft/", {
        //         params: {
        //             id: id,
        //             type: value,
        //         },
        //     }).then((response) => {
        //         if (response.data.status === true) {
        //             window.Swal.fire({
        //                 toast: true,
        //                 position: 'top-end',
        //                 timer: 2000,
        //                 showConfirmButton: false,
        //                 icon: 'success',
        //                 title: 'Added',
        //             });
        //         }
        //     }).catch((error) => {
        //         console.log(error);
        //         if (error.response.status == '402') {
        //             window.Swal.fire({
        //                 toast: true,
        //                 position: 'top-end',
        //                 timer: 2000,
        //                 showConfirmButton: false,
        //                 icon: 'error',
        //                 title: `You don't have a active plan buy a plan or renew your plan`,
        //             });
        //         }
        //         else if (error.response.status == '403') {
        //             window.Swal.fire({
        //                 toast: true,
        //                 position: 'top-end',
        //                 timer: 2000,
        //                 showConfirmButton: false,
        //                 icon: 'error',
        //                 title: `You have posted number of allowed post can't post more`,
        //             });
        //         }
        //         else if (error.response.status == '406') {
        //             window.Swal.fire({
        //                 toast: true,
        //                 position: 'top-end',
        //                 timer: 2000,
        //                 showConfirmButton: false,
        //                 icon: 'error',
        //                 title: `You already posted this job`,
        //             });
        //         }
        //     });
        //     console.log(response);
        // } catch (err) { }
        const showcolumn = ref(false);
        const logEvent = (e) => {
            showcolumn.value = true;
            // DxFormItem.value = false;
            // console.log(e.data);
            // title.value = e.data.title;
            content.value = e.data.content;
        }
        const cancelEdit = (data) => {
            showcolumn.value = false;
        }
        const fetchBlogs = () => {
            try {
                axios.get('/admin/blog/fetch').then((response) => {
                    // console.log(response.data.data[0].content);
                    blogs.value = response.data.data;
                }).catch((error) => {
                    console.log(error);
                })
            } catch (error) {

            }
        };
        const deleteBlog = (id) => {
            window.Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios.delete(`/admin/delete/blog/${id}`).then((response) => {
                            // console.log(response.data);
                            if (response.data.status == true) {
                                // fetchBlogs();
                                refreshTable(dataGridRef);
                            } else {
                                console.log(
                                    "Request was not successful:",
                                    response.data.message
                                );
                            }
                        });
                    } catch (err) {
                        console.log(err);
                    }
                }
            });
        };
        // const deleteBlog = (id) => {

        //     axios.delete(`/admin/delete/blog/${id}`).then((response) => {
        //         // console.log(response.data);
        //         if (response.data.status == true) {
        //             // fetchBlogs();
        //             refreshTable(dataGridRef);
        //         }
        //     }).catch((error) => {
        //         console.log(error);
        //     })
        // }
        const editBlog = (blog) => {
            console.log(blog);
            showDialog.value = true;
            title.value = blog.title;
            content.value = blog.content;
            updateId.value = blog.id;
            // selectedImage.value = blog.featured_image;
            imagePreview.value = blog.featured_image;
            // selectedImage
            console.log(imagePreview.value);
        }
        const openAddDialog = () => {
            showAddDialog.value = true;
            imagePreview.value = null;
            selectedImage.value = null;
            title.value = '';
            content.value = '';
        }
        const closeAddDialog = () => {
            showAddDialog.value = false;
            imagePreview.value = null;
            selectedImage.value = null;
        }
        const savePost = (id) => {
            form.value.validate().then((valid) => {
                // console.log(valid.errors);
                if (!valid.valid) {
                    const errors = JSON.parse(JSON.stringify(valid.errors));

                    let errorField = form.value[errors[0].id];

                    errorField = Array.isArray(errorField) ? errorField[0] : errorField;
                    errorField.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                        inline: "center",
                    });
                } else {
                    const formData = new FormData();
                    console.log(selectedImage.value);
                    if (selectedImage.value) {
                        formData.append('featured_image', selectedImage.value[0]);
                    } else {
                        formData.append('featured_image',
                            selectedImage.value);
                    }
                    // console.log('featured_image', selectedImage.value[0]);
                    formData.append('title', title.value);
                    formData.append('htmlContent', content.value);
                    // console.log()
                    axios.post(`/admin/update/blog/${id}`, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }).then((response) => {
                        // console.log(response.data);
                        if (response.data.status == true) {
                            showDialog.value = false;
                            // fetchBlogs();
                            refreshTable(dataGridRef);
                            window.Swal.fire({
                                toast: true,
                                position: 'top-end',
                                timer: 2000,
                                showConfirmButton: false,
                                icon: 'success',
                                title: `Blog Updated Successfully`,
                            });
                        }
                    }).catch((error) => {
                        console.log(error);
                    })
                }
            })
        };
        const addPost = (data) => {
            form.value.validate().then((valid) => {
                // console.log(valid.errors);
                if (!valid.valid) {
                    const errors = JSON.parse(JSON.stringify(valid.errors));

                    let errorField = form.value[errors[0].id];

                    errorField = Array.isArray(errorField) ? errorField[0] : errorField;
                    errorField.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                        inline: "center",
                    });
                } else {
                    console.log(data[0]);
                    const formData = new FormData();
                    formData.append('featured_image', data[0]);
                    // console.log('featured_image', data[0]);
                    formData.append('title', title.value);
                    formData.append('htmlContent', content.value);
                    // console.log('htmlContent', content.value);
                    axios.post('/admin/save-blog/post',
                        formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }).then((response) => {
                        if (response.data.status == true) {
                            showAddDialog.value = false;
                            window.Swal.fire({
                                toast: true,
                                position: 'top-end',
                                timer: 2000,
                                showConfirmButton: false,
                                icon: 'success',
                                title: `Blog Posted Successfully`,
                            });
                            refreshTable(dataGridRef);
                        }
                    })
                }
            })

        }
        const { dataSource, refreshTable } = dxGridStore(
            loadUrl,
            params,
            insertURL,
            updateURL,
            deleteUrl
        );
        onMounted(() => {
            fetchBlogs();
        })
        return {
            blogs,
            showDialog,
            editBlog,
            editor: ClassicEditor,
            title,
            content,
            savePost,
            updateId,
            deleteBlog,
            openAddDialog,
            showcolumn,
            items,
            updateURL,
            deleteUrl, insertURL,
            loadUrl,
            dataSource,
            refreshTable,
            logEvent,
            cancelEdit,
            selectStatus,
            selectedStatus,
            DropDown2,
            showAddDialog,
            addPost,
            dataGridRef,
            blogActions,
            duplicateBlog,
            selectedImage,
            imagePreview,
            previewImage,
            closeAddDialog,
            form,
            titleRules,
            imageRules
        }
    }
}
</script>
<style>
.edit-btn {
    margin-right: 10px;
    /* Adjust margin as needed */
}
</style>