/* eslint-disable prefer-arrow-callback, prefer-template */

require('babel-register');
var glob = require('glob');

glob('src/**/__test__/*.js', function(er, files) {
  if (er) throw er;

  files.forEach(function(f) {
    require('./' + f);
  });
});
