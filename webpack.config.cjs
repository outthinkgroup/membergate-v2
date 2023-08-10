const defaultConfig = require("@wordpress/scripts/config/webpack.config.js");

module.exports = {
  ...defaultConfig,
  ...{
    entry: resolve(process.cwd(), "extend-block-editor/src/index.js"),
    output: {
      filename: "[name].js",
      path: resolve(process.cwd(), "extend-block-editor/build"),
    },
		
    externals: {
      ...defaultConfig.externals,
      react: "React",
      "react-dom": "ReactDom",
    },
  },
};
