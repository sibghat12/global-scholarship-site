const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");

/**
 * Paths
 */

const assetsFolder = "assets";

const mainAssets = path.resolve(__dirname, `${assetsFolder}`);
const entry = {
  course_button_shortcode: [__dirname + `/${assetsFolder}/src/js/course_button_shortcode.js`],
  single_scholarships_post: [__dirname + `/${assetsFolder}/src/js/single_scholarships_post.js`], // Single Scholarships Posts
  single_post: [__dirname + `/${assetsFolder}/src/js/single_post.js`], // Single  Posts
  scholarship_search_filter: [__dirname + `/${assetsFolder}/src/js/scholarship_search_filter.js`], // Single  Posts
  opencourses_template: [__dirname + `/${assetsFolder}/src/js/opencourses_template.js`],
  partner_template: [__dirname + `/${assetsFolder}/src/js/partner_template.js`],
  courses_filter_widget: [__dirname + `/${assetsFolder}/src/js/courses_filter_widget.js`],
  wise: [__dirname + `/${assetsFolder}/src/js/wise.js`],
  table_of_content: [__dirname + `/${assetsFolder}/src/js/table_of_content.js`],
  single_scholarships: [__dirname + `/${assetsFolder}/src/js/single_scholarships.js`],
  single_institution: [__dirname + `/${assetsFolder}/src/js/single_institution.js`],
  single_external_scholarships: [__dirname + `/${assetsFolder}/src/js/single_external_scholarships.js`],
  gs_login_modal: [__dirname + `/${assetsFolder}/src/js/gs_login_modal.js`],
  currently_open_template: [__dirname + `/${assetsFolder}/src/js/currently_open_template.js`],
  scholarship_institution_responsive: [__dirname + `/${assetsFolder}/src/js/scholarship_institution_responsive.js`],
  //feature_related_courses: [__dirname + `/${assetsFolder}/src/js/feature_related_courses.js`],
  homepage_template: [__dirname + `/${assetsFolder}/src/js/homepage_template.js`],
  gs_course_box: [__dirname + `/${assetsFolder}/src/js/gs_course_box.js`],
  email_subscription_page: [__dirname + `/${assetsFolder}/src/js/email_subscription_page.js`],
  scholarship_receipents_post_category: [__dirname + `/${assetsFolder}/src/js/scholarship_receipents_post_category.js`],
  recent_scholarship_receipents: [__dirname + `/${assetsFolder}/src/js/recent_scholarship_receipents.js`],
  general_style: [__dirname + `/${assetsFolder}/src/js/general_style.js`],

 

};
const mainDistentation = path.resolve(__dirname, `${assetsFolder}/dist`);
const output = {
  filename: "js/[name].js",
  path: mainDistentation,
};

const rules = [
  {
    test: /\.(png|jpe?g|gif|ico)$/i,
    exclude: /node_modules/,
    use: [
      {
        loader: "file-loader",
      },
    ],
  },
  {
    test: /\.(woff2?|ttf|otf|eot|svg)$/,
    exclude: /node_modules/,
    loader: "file-loader",
    options: {
      name: "[path][name].[ext]",
    },
  },
  {
    test: /\.scss$/,
    exclude: /node_modules/,
    use: [
      MiniCssExtractPlugin.loader,
      "css-loader",
      "resolve-url-loader",
      "sass-loader",
    ],
  },
  {
    test: /\.js$/,
    exclude: /node_modules/,
    use: {
      loader: "babel-loader",
      options: {
        presets: [["@babel/preset-env", { targets: "defaults" }]],
      },
    },
  },
];

const minimizing = [
  new CssMinimizerPlugin({
    parallel: true,
    minimizerOptions: {
      preset: [
        "default",
        {
          discardComments: { removeAll: true },
        },
      ],
    },
  }),

  new UglifyJsPlugin({
    extractComments: true,
    cache: false,
    parallel: true,
    sourceMap: false,
  }),
];

/**
 * Note: argv.mode will return 'development' or 'production'.
 *
 * @param  argv
 */
const plugins = (argv) => [
  new CleanWebpackPlugin({
    cleanStaleWebpackAssets: "production" === argv.mode, // Automatically remove all unused webpack assets on rebuild, when set to true in production. ( https://www.npmjs.com/package/clean-webpack-plugin#options-and-defaults-optional )
  }),

  new MiniCssExtractPlugin({
    filename:"css/[name].css",
  }),
];

/**
 * Module Exports
 *
 * @param  env
 * @param  argv
 */
module.exports = (env, argv) => ({
  mode: "development",
  context: mainAssets,
  entry,
  output,
  devtool: "source-map",
  optimization: {
    minimize: true,
    minimizer: minimizing,
  },
  plugins: plugins(argv),
  module: {
    rules,
  },
});
