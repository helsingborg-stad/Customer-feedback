import { createViteConfig } from "vite-config-factory";

const entries = {
    'js/customer-feedback': './source/js/app.js',
    'css/customer-feedback': './source/sass/customer-feedback.scss',
    'css/admin-customer-feedback': './source/sass/admin-customer-feedback.scss',
};

export default createViteConfig(entries, {
	outDir: "assets/dist",
	manifestFile: "manifest.json",
});
