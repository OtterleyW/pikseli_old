/* eslint-disable prefer-arrow-callback, prefer-template, no-console */

require('babel-register');
var glob = require('glob');
var test = require('tape-catch');

glob('./src/**/__test__/*.js', function(er, files) {
  if (er) throw er;

  files.forEach(function(f) {
    // console.error('Running tests in ' + f);
    require('../' + f).default(test);
  });
});
