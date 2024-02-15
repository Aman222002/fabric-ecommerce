import { ref } from "vue";
import axios from "axios";
import CustomStore from "devextreme/data/custom_store";
export default function useDataSource(
    url,
    insertURL = null,
    updateURL = null,
    deleteURL = null
) {
    const skipLoader = ref(true);

    const dataSource = new CustomStore({
        byKey: (key) => {
            return fetch(url + "?id=" + key);
        },
        load: (loadOptions) => {
            const dxKeys = [
                "skip",
                "take",
                "requireTotalCount",
                "requireGroupCount",
                "sort",
                "filter",
            ];
            console.log(url);
            
            return axios
                .get(url)
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
            console.log(deleteURL+ "/" + key.id);
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

    return {
        dataSource,
        skipLoader,
    };
}
