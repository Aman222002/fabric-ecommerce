import { ref } from "vue";
import axios from "axios";
import CustomStore from "devextreme/data/custom_store";
export default function useDataSource(
    url,
    params,
    insertURL = null,
    updateURL = null,
    deleteURL = null
) {
    const skipLoader = ref(true);
    const pageSizes = ref([10, 15, 20]);
    const user_id = ref("");
    const isNotEmpty = (value) => {
        return value !== undefined && value !== null && value !== "";
    };
    const dataSource = new CustomStore({
        byKey: (key) => {
            return fetch(url + "?id=" + key);
        },
        load: async function (loadOptions) {
            const dxKeys = [
                "skip",
                "take",
                "requireTotalCount",
                "requireGroupCount",
                "sort",
                "filter",
            ];
            let paramsObject = {};
            dxKeys.forEach((i) => {
                if (i in loadOptions && loadOptions[i]) {
                    paramsObject[i] = JSON.stringify(loadOptions[i]);
                }
            });
            if (!params) {
                params = {};
            }
            // if (params) {
            //     user_id.value = params.value;
            //     paramsObject = user_id.value;
            // }
            return axios
                .get(url, { params: paramsObject })
                .then(({ data }) => {
                    if (skipLoader.value) {
                        skipLoader.value = false;
                    }
                    console.log(data);
                    return {
                        data: data.data || [],
                        summary: data.summary || [],
                        totalCount: data.totalCount ?? 10,
                    };
                })
                .catch(() => {
                    if (skipLoader.value) {
                        skipLoader.value = false;
                    }
                    throw new Error("Data Loading Error");
                });
        },
        insert: (values) => {
            return axios
                .post(insertURL, values)
                .then(() => {
                    return true;
                })
                .catch((error) => {
                    console.log("err", error);
                    throw new Error("Error while adding record");
                });
        },
        update: (key, values) => {
            return axios
                .post(updateURL + "/" + key.id, values)
                .then(() => {
                    return true;
                })
                .catch((error) => {
                    console.log("err 1", error);
                    throw new Error("Error while updating record.");
                });
        },
        remove: (key) => {
            return axios
                .delete(deleteURL + "/" + key.id)
                .then(() => {
                    return true;
                })
                .catch((error) => {
                    console.log("err 2", error);
                    throw new Error("Error while deleting record.");
                });
        },
    });
    const refreshTable = (dataGridRef, changedOnly = false) => {
        if (!dataGridRef) {
            console.error("DataGrid ref not provided.");
            return;
        }
        const dataGrid = dataGridRef.value.instance;
        if (!dataGrid) {
            console.error("DataGrid instance not found.");
            return;
        }

        dataGrid.refresh(changedOnly);
    };
    return {
        dataSource,
        skipLoader,
        isNotEmpty,
        pageSizes,
        user_id,
        refreshTable,
    };
}
