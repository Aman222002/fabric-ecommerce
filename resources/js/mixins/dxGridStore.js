import CustomStore from "devextreme/data/custom_store";
export default {
    setup() {
        return {
            displayMode: "standard",
            pageSizes: window.isMobile ? [25, 35, 50] : [15, 25, 50],
            pageSize: window.isMobile ? 25 : 15,
            childPageSizes: window.isMobile ? [10, 15, 20] : [7, 10, 15],
            childPageSize: window.isMobile ? 10 : 7,
            showPageSizeSelector: true,
            showNavButtons: true,
            showInfo: true,
            skipLoader: true,
            dataGridRefName: "dataGrid",
            showColumnLines: false,
            showRowLines: false,
            refKey: "dataGrid",
        };
    },
    methods: {
        dataSource(
            url,
            params,
            insertURL = null,
            updateURL = null,
            deleteURL = null
        ) {
            return new CustomStore({
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

                    return window.axios
                        .get(url, { params })
                        .then(({ data }) => {
                            if (this.skipLoader) {
                                this.skipLoader = false;
                            }
                            console.log(data);
                            return {
                                data: data.users || [],
                                summary: data.summary || [],
                                totalCount: data.totalCount ?? 10,
                            };
                        })
                        .catch(() => {
                            if (this.skipLoader) {
                                this.skipLoader = false;
                            }
                            throw new Error("Data Loading Error");
                        });
                },
            });
        },
    },
};
