<template>
  <p style="text-align: center; font-size: 30px; margin-top: 20px">Blogs</p>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    ref="dataGridRef"
    @editing-start="logEvent"
    @edit-canceling="cancelEdit(data)"
  >
    <DxSearchPanel :visible="true" :placeholder="'Search'" :width="300" />
    <DxToolbar>
      <DxGridItem template="dropDown2" :location="'before'" />
      <DxGridItem template="addButton" :location="'after'"></DxGridItem>
      <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
    </DxToolbar>
    <DxLoadPanel :enabled="true" />
    <DxSearchPanel :visible="true" />
    <DxColumn
      caption="Action"
      :allow-editing="false"
      cell-template="customButtonTemplate"
      v-if="!showcolumn"
      width="auto"
    >
    </DxColumn>
    <DxColumn data-field="title" data-type="string" :visible="!showcolumn">
    </DxColumn>
    <DxColumn
      caption="Posted_At"
      data-type="string"
      :visible="!showcolumn"
      v-if="!showcolumn"
      cell-template="CreatedTemplate"
    >
    </DxColumn>
    <template #CreatedTemplate="{ data }">
      {{ formatCreatedAt(data.data.created_at) }}
    </template>
    <DxColumn
      data-field="status"
      data-type="string"
      :visible="!showcolumn"
      v-if="!showcolumn"
      width="auto"
    >
    </DxColumn>
    <DxColumn
      data-field="published_by"
      data-type="string"
      :visible="!showcolumn"
      v-if="!showcolumn"
      width="auto"
    >
    </DxColumn>
    <DxColumn cell-template="Dxbutton" width="auto"></DxColumn>
    <DxColumn
      data-field="content"
      cell-template="ckeditor"
      edit-cell-template="ckeditor"
      :visible="showcolumn"
    >
    </DxColumn>
    <template #addButton>
      <DxButton icon="add" @click="openAddDialog"></DxButton>
    </template>
    <template #Dxbutton="{ data }">
      <v-btn
        prepend-icon="mdi-pencil"
        class="edit-btn"
        @click="editBlog(data.data)"
      ></v-btn>

      <v-btn
        prepend-icon="mdi-delete"
        class="btn_delete"
        @click="deleteBlog(data.data.id)"
      ></v-btn>
    </template>
    <template #ckeditor>
      <h2 class="mb-3">Edit Blog</h2>

      <div class="editor">
        <ckeditor v-model="content" :editor="editor"></ckeditor>
      </div>
    </template>
    <template #dropDown2>
      <DxDropDownBox
        :accept-custom-value="true"
        @value-change="selectStatus"
        label="Select status"
        labelMode="floating"
        v-model:value="selectedStatus"
        v-model:opened="DropDown2"
      >
        <DxList
          :data-source="items"
          selection-mode="single"
          @item-click="selectStatus"
        >
        </DxList>
      </DxDropDownBox>
    </template>
    <template #customButtonTemplate="{ data }">
      <v-menu>
        <template v-slot:activator="{ props }">
          <v-btn height="30" class="btn_cts action_button" v-bind="props">
            <v-icon>mdi-menu-down</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-list v-for="item in blogActions" :key="item.text">
            <template v-if="selectedStatus === 'Draft'">
              <v-list-item
                class="dropdown blog_actions"
                @click="duplicateBlog(data.row.data.id, item.text)"
              >
                {{ item.text }}
              </v-list-item>
            </template>
            <template v-else>
              <v-list-item
                v-if="item.text !== 'Post Blog' || selectedStatus == 'All'"
                class="dropdown blog_actions"
                @click="duplicateBlog(data.row.data.id, item.text)"
              >
                {{ item.text }}
              </v-list-item>
            </template>
          </v-list>
        </v-card>
      </v-menu>
    </template>
    <DxPaging :page-size="pageSize" />
    <DxPager
      :visible="true"
      :allowed-page-sizes="[15, 20, 30]"
      :display-mode="'compact'"
      :show-page-size-selector="true"
      :show-navigation-buttons="true"
      :show-info="true"
    />
  </DxDataGrid>

  <v-container>
    <v-dialog max-width="1000" v-model="showDialog" persistent>
      <v-card>
        <v-card-text>
          <v-form @submit.prevent="savePost(updateId)" ref="form">
            <h2 class="mb-3">
              Edit Blog
              <v-icon style="float: right" @click="showDialog = false"
                >mdi-close</v-icon
              >
            </h2>
            <v-text-field
              v-model="title"
              variant="outlined"
              label="Title"
              density="compact"
              outlined
              :rules="titleRules"
            ></v-text-field>
            <v-file-input
              label="Select new featured Image"
              v-model="selectedImage"
              @change="previewImage"
              accept="image/*"
              variant="outlined"
              density="compact"
              outlined
            ></v-file-input>
            <v-row class="mb-2" v-if="imagePreview">
              <p style="font: bold; margin-left: 11px">
                Selected Featured Image
              </p>
              <v-col cols="12">
                <v-img
                  :src="imagePreview"
                  max-width="300"
                  max-height="300"
                ></v-img>
              </v-col>
            </v-row>
            <div class="editor">
              <ckeditor v-model="content" :editor="editor"></ckeditor>
            </div>

            <v-card-actions>
              <v-btn class="btn_cts" type="submit">Edit Blog</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog max-width="1000" v-model="showAddDialog" persistent>
      <v-card>
        <v-card-text>
          <v-form @submit.prevent="addPost(selectedImage)" ref="form">
            <h2 class="mb-2">
              Add Blog
              <v-icon style="float: right" @click="showAddDialog = false"
                >mdi-close</v-icon
              >
            </h2>
            <v-text-field
              v-model="title"
              variant="outlined"
              label="Title"
              density="compact"
              outlined
              :rules="titleRules"
            ></v-text-field>
            <v-file-input
              label="Add featured Image"
              v-model="selectedImage"
              @change="previewImage"
              accept="image/*"
              :rules="imageRules"
              variant="outlined"
              density="comfortable"
            ></v-file-input>
            <v-row v-if="imagePreview">
              <v-col cols="12">
                <v-img
                  :src="imagePreview"
                  max-width="300"
                  max-height="300"
                ></v-img>
              </v-col>
            </v-row>
            <div class="editor">
              <ckeditor v-model="content" :editor="editor"></ckeditor>
            </div>
            <v-card-actions>
              <v-btn class="btn_cts" type="submit">Add Blog</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>
<script>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import dxGridStore from "../composition/dxGridStore";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { Sweetalert } from "../utils/sweetalert";
export default {
  components: {
    ckeditor: CKEditor.component,
  },
  setup() {
    const blogs = ref({});
    const showDialog = ref(false);
    const showAddDialog = ref(false);
    const form = ref(null);
    const content = ref("");
    const pageSize = ref(15);
    const title = ref("");
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
    const loadUrl = `/admin/blog/fetch`;
    const insertURL = `/admin/save-blog/post`;
    const deleteUrl = `/admin/delete/blog`;
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

    watch(selectedImage, (newValue) => {
      if (!newValue) {
        imagePreview.value = null;
      }
    });
    const duplicateBlog = (id, value) => {
      console.log(value);
      if (value == "Duplicate") {
        try {
          axios
            .post("/admin/blog/draft/", {
              params: {
                id: id,
                type: value,
              },
            })
            .then((response) => {
              console.log(response.data);

              Sweetalert.success("Blog Drafted Successfully");
              refreshTable(dataGridRef);
            })
            .catch((err) => {
              console.log(err);
            });
        } catch (error) {
          console.log(error);
        }
      } else {
        axios
          .post("/admin/blog/post/", {
            params: {
              id: id,
              type: value,
            },
          })
          .then((response) => {
            console.log(response.data);

            Sweetalert.success("Blog Posted Successfully");
            refreshTable(dataGridRef);
          })
          .catch((err) => {
            console.log(err);
            if (err.response.status == "406") {
              Sweetalert.error("You already posted this blog");
            }
          });
      }
    };

    const showcolumn = ref(false);
    const logEvent = (e) => {
      showcolumn.value = true;
      content.value = e.data.content;
    };
    const cancelEdit = (data) => {
      showcolumn.value = false;
    };
    const fetchBlogs = () => {
      try {
        axios
          .get("/admin/blog/fetch")
          .then((response) => {
            blogs.value = response.data.data;
          })
          .catch((error) => {
            console.log(error);
          });
      } catch (error) {}
    };
    const deleteBlog = (id) => {
      Sweetalert.confirm("Are you sure?").then((result) => {
        if (result.isConfirmed) {
          try {
            axios.delete(`/admin/delete/blog/${id}`).then((response) => {
              if (response.data.status == true) {
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

    const editBlog = (blog) => {
      console.log(blog);
      showDialog.value = true;
      title.value = blog.title;
      content.value = blog.content;
      updateId.value = blog.id;

      imagePreview.value = blog.featured_image;

      console.log(imagePreview.value);
    };
    const openAddDialog = () => {
      showAddDialog.value = true;
      imagePreview.value = null;
      selectedImage.value = null;
      title.value = "";
      content.value = "";
    };
    const closeAddDialog = () => {
      showAddDialog.value = false;
      imagePreview.value = null;
      selectedImage.value = null;
    };
    const savePost = (id) => {
      form.value.validate().then((valid) => {
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
            formData.append("featured_image", selectedImage.value[0]);
          } else {
            formData.append("featured_image", selectedImage.value);
          }

          formData.append("title", title.value);
          formData.append("htmlContent", content.value);

          axios
            .post(`/admin/update/blog/${id}`, formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((response) => {
              if (response.data.status == true) {
                showDialog.value = false;

                refreshTable(dataGridRef);

                Sweetalert.success("Blog Updated Successfully");
              }
            })
            .catch((error) => {
              console.log(error);
            });
        }
      });
    };
    const addPost = (data) => {
      form.value.validate().then((valid) => {
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
          formData.append("featured_image", data[0]);

          formData.append("title", title.value);
          formData.append("htmlContent", content.value);

          axios
            .post("/admin/save-blog/post", formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((response) => {
              if (response.data.status == true) {
                showAddDialog.value = false;
                Sweetalert.success("Blog Posted Successfully");
                refreshTable(dataGridRef);
              }
            });
        }
      });
    };
    const { dataSource, refreshTable } = dxGridStore(
      loadUrl,
      params,
      insertURL,
      updateURL,
      deleteUrl
    );
    onMounted(() => {
      fetchBlogs();
    });
    const formatCreatedAt = (created_at) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(created_at).toLocaleDateString(undefined, options);
    };
    return {
      pageSize,
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
      deleteUrl,
      insertURL,
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
      imageRules,
      formatCreatedAt,
    };
  },
};
</script>
<style>
.edit-btn {
  margin-right: 10px;
  /* Adjust margin as needed */
}
.btn_delete {
  min-width: 15px;
  font-size: 13px;
  text-align: center;
  box-shadow: unset;
  color: #b00020 !important;
  padding: 0 !important;
}
button.edit-btn {
  min-width: 18px;
  padding: 0;
  font-size: 13px;
  text-align: center;
  box-shadow: unset;
  color: #0146a6;
}
.edit-btn:hover {
  box-shadow: unset;
  background-color: transparent !important;
}
.action_button {
  min-width: 18px;
  max-width: 18px;
}
</style>