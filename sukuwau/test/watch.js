/* eslint-disable prefer-arrow-callback, prefer-template, no-console */
// var require = require('really-need');
var NODE_MODULES_REGEX = /node_modules\//;
var TEST_REGEX = /\/__test__\//;
var require = require('really-need');
var chokidar = require('chokidar');
var babel = require('babel-core');
var pathUtil = require('path');
var fs = require('fs');
var tape = require('tape-catch');
var faucet = require('faucet');

function transpileSourceFiles(source, filename) {
  var code = source;
  if (NODE_MODULES_REGEX.test(filename)) {
    return code;
  }

  // process.stdout.write('Transpiling ' + filename);
  code = babel.transform(source, {
    filename: filename
  }).code;
  // console.log(' [OK]');
  delete require.cache[filename];

  return code;
}

function isTestFile(path) {
  return TEST_REGEX.test(path);
}

function loadAndTranspile(path) {
  return require(path, {
    bust: true,
    cache: false,
    pre: transpileSourceFiles
  });
}

function runTestFile(path) {
  var htest = tape.createHarness();
  htest.createStream().pipe(faucet()).pipe(process.stdout);
  loadAndTranspile(path).default(htest);
}

var watcher =
  chokidar.watch('../src/**/*.js', {
    cwd: __dirname
  });

watcher
  .on('change', function(path) {
    console.error('Changed:', path);
    if (isTestFile(path)) {
      console.log('Running tests in', path);
      runTestFile(path);
    }
    else {
      var testPath =
        pathUtil.join(
          pathUtil.dirname(path),
          '__test__',
          pathUtil.basename(path)
        );
      if (fs.existsSync(pathUtil.resolve(__dirname, testPath))) {
        console.log('Running tests in', testPath);
        runTestFile(testPath);
      }
      else {
        console.log(path, 'has no matching test in', testPath);
      }
    }
  })
  .on('add', function(path) {
    console.error('Now watching file', path);
    if (isTestFile(path)) {
      runTestFile(path);
    }
  })
  .on('unlink', function(path) {
    console.error('File was removed, unwatching', path);
  })
  .on('ready', function() {
    console.error('Initial scan complete, ready for action!');
  });
