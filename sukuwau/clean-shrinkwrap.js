#!/usr/bin/env node

/**
 * this script is just a temporary solution to deal with the issue of npm outputting the npm
 * shrinkwrap file in an unstable manner.
 *
 * See: https://github.com/npm/npm/issues/3581
 */

var fs = require('fs');
var path = require('path');

function cleanModule(moduleToClean) {

  // keep `resolve` properties for git dependencies, delete otherwise
  delete moduleToClean.from;
  if (!(moduleToClean.resolved && moduleToClean.resolved.match(/^git(\+[a-z]+)?:\/\//))) {
    delete moduleToClean.resolved;
  }

  Object.keys(moduleToClean.dependencies || {}).forEach(function(modKey) {
    var mod = moduleToClean.dependencies[modKey];
    cleanModule(mod);
  });
}

function deepSorted(objToSort) {
  return Object.keys(objToSort).sort().reduce(function(result, key) {
    var current = objToSort[key];
    if (typeof current === 'object') {
      result[key] = deepSorted(current);
    } else {
      result[key] = current;
    }
    return result;
  }, {});
}


console.log('Reading npm-shrinkwrap.json');
var shrinkwrap = require('./npm-shrinkwrap.json');

console.log('Cleaning shrinkwrap object');
cleanModule(shrinkwrap, shrinkwrap.name);

var cleanShrinkwrapPath = path.join(__dirname, 'npm-shrinkwrap.json');
console.log('Writing cleaned to', cleanShrinkwrapPath);
fs.writeFileSync(cleanShrinkwrapPath, JSON.stringify(deepSorted(shrinkwrap), null, 2) + "\n");
