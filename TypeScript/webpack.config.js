const conf = {
    src: __dirname + '/src',
    dist: __dirname + '/dist'
  };
  
  module.exports = {
    entry: [
      conf.src + '/app.ts'
    ],
    output: {
      filename: 'bundle.js',
      path: conf.dist
    },
    module: {
      rules: [{
          test: /\.tsx?$/,
          use: 'ts-loader',
          exclude: /node_modules/
        }
      ]
    }
  };