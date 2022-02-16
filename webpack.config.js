const path = require('path');
const autoprefixer = require('autoprefixer');
const { CleanWebpackPlugin }= require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const RemoveEmptyScripts = require('webpack-remove-empty-scripts');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

const devMode = process.env.NODE_ENV !== 'production';

module.exports = {
  externals: {
    jquery: 'jQuery',
  },

  mode: devMode ? 'development' : 'production',

  /**
   * Entry files - Add more entries if needed.
   */
  entry: {
    'js/customer-feedback': './source/js/app.js',
    'css/customer-feedback': './source/sass/customer-feedback.scss',
    'css/admin-customer-feedback': './source/sass/admin-customer-feedback.scss',
  },

  /**
   * Output files
   */
  output: {
    filename: devMode ? '[name].js' : '[name].[contenthash:8].js',
    chunkFilename: devMode ? '[id].js' : '[id].[contenthash:8].js',
    path: path.resolve(process.cwd(), 'dist'),
    publicPath: '',
  },

  module: {
    rules: [
      /**
       * Babel
       */
      {
        test: /\.jsx?/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            // Babel config here
            presets: ['@babel/preset-env', '@babel/preset-react'],
            plugins: [
              '@babel/plugin-syntax-dynamic-import',
              '@babel/plugin-proposal-export-default-from',
              '@babel/plugin-proposal-class-properties',
              'react-hot-loader/babel',
            ],
          },
        },
      },

      /**
       * Compile sass to css
       */
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 2, // 0 => no loaders (default); 1 => postcss-loader; 2 => sass-loader
            },
          },
          {
            loader: 'postcss-loader',
            options: {
                postcssOptions: {
                    plugins: [autoprefixer],
                }
            },
          },
          'sass-loader',
        ],
      },
      /**
       * Images
       */
      {
        test: /\.(png|svg|jpg|gif)$/,
        type: 'asset/resource',
        generator: {
            filename: 'images/action_icons/[name][ext]',
        },
      },
    ],
  },

  /**
   * Plugins
   */
  plugins: [
    new CleanWebpackPlugin(),
    new RemoveEmptyScripts(),
    // Minify css and create css file
    new MiniCssExtractPlugin({
      filename: devMode ? '[name].css' : '[name].[contenthash:8].css',
      chunkFilename: devMode ? '[name].css' : '[name].[contenthash:8].css',
    }),
    new WebpackManifestPlugin({
      fileName: 'manifest.json',
      // Filter manifest items
      filter(file) {
        // Don't include source maps
        if (file.path.match(/\.(map)$/)) {
          return false;
        }
        return true;
      },
      // Custom mapping of manifest item goes here
      map(file) {
        // Fix incorrect key for fonts
        if (file.isAsset && file.isModuleAsset && file.path.match(/\.(woff|woff2|eot|ttf|otf)$/)) {
          const pathParts = file.path.split('.');
          const nameParts = file.name.split('.');

          // Compare extensions
          if (pathParts[pathParts.length - 1] !== nameParts[nameParts.length - 1]) {
            file.name = pathParts[0].concat('.', pathParts[pathParts.length - 1]);
          }
        }
        return file;
      },
    }),
  ],
  devtool: 'source-map',
  stats: {children: false}
};