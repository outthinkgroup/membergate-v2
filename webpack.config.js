import defaultConfig from  "@wordpress/scripts/config/webpack.config.js";

export default {
  ...defaultConfig,
  ...{
    entry: {
      ...defaultConfig.entry(),
      overlaySettings:   './extend-block-editor/src/overlaySettings/index.js',
    },
  },
};
