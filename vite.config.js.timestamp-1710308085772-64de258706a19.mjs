// vite.config.js
import { defineConfig } from "file:///D:/xampp8.1.12/htdocs/job-search%20project/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/xampp8.1.12/htdocs/job-search%20project/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///D:/xampp8.1.12/htdocs/job-search%20project/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var vite_config_default = defineConfig({
  // server: {
  //     host: '0.0.0.0',
  //     hmr: {
  //         host: '192.168.1.21',
  //     },
  // },
  plugins: [
    laravel({
      input: ["resources/sass/app.scss", "resources/js/app.js"],
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    })
  ],
  resolve: {
    alias: {
      vue: "vue/dist/vue.esm-bundler.js"
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFx4YW1wcDguMS4xMlxcXFxodGRvY3NcXFxcam9iLXNlYXJjaCBwcm9qZWN0XCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJEOlxcXFx4YW1wcDguMS4xMlxcXFxodGRvY3NcXFxcam9iLXNlYXJjaCBwcm9qZWN0XFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9EOi94YW1wcDguMS4xMi9odGRvY3Mvam9iLXNlYXJjaCUyMHByb2plY3Qvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tIFwidml0ZVwiO1xuaW1wb3J0IGxhcmF2ZWwgZnJvbSBcImxhcmF2ZWwtdml0ZS1wbHVnaW5cIjtcbmltcG9ydCB2dWUgZnJvbSBcIkB2aXRlanMvcGx1Z2luLXZ1ZVwiO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIC8vIHNlcnZlcjoge1xuICAgIC8vICAgICBob3N0OiAnMC4wLjAuMCcsXG4gICAgLy8gICAgIGhtcjoge1xuICAgIC8vICAgICAgICAgaG9zdDogJzE5Mi4xNjguMS4yMScsXG4gICAgLy8gICAgIH0sXG4gICAgLy8gfSxcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIFxuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXCJyZXNvdXJjZXMvc2Fzcy9hcHAuc2Nzc1wiLCBcInJlc291cmNlcy9qcy9hcHAuanNcIl0sXG4gICAgICAgICAgIFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgICAgIFxuICAgICAgICB2dWUoe1xuICAgICAgICAgICAgdGVtcGxhdGU6IHtcbiAgICAgICAgICAgICAgICB0cmFuc2Zvcm1Bc3NldFVybHM6IHtcbiAgICAgICAgICAgICAgICAgICAgYmFzZTogbnVsbCxcbiAgICAgICAgICAgICAgICAgICAgaW5jbHVkZUFic29sdXRlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfSksXG4gICAgXSxcblxuICAgIHJlc29sdmU6IHtcbiAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgIHZ1ZTogXCJ2dWUvZGlzdC92dWUuZXNtLWJ1bmRsZXIuanNcIixcbiAgICAgICAgfSxcbiAgICB9LFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQW9ULFNBQVMsb0JBQW9CO0FBQ2pWLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFFaEIsSUFBTyxzQkFBUSxhQUFhO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUEsRUFPeEIsU0FBUztBQUFBLElBRUwsUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLDJCQUEyQixxQkFBcUI7QUFBQSxNQUV4RCxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFFRCxJQUFJO0FBQUEsTUFDQSxVQUFVO0FBQUEsUUFDTixvQkFBb0I7QUFBQSxVQUNoQixNQUFNO0FBQUEsVUFDTixpQkFBaUI7QUFBQSxRQUNyQjtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxFQUNMO0FBQUEsRUFFQSxTQUFTO0FBQUEsSUFDTCxPQUFPO0FBQUEsTUFDSCxLQUFLO0FBQUEsSUFDVDtBQUFBLEVBQ0o7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
