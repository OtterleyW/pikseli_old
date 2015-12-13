/* eslint-disable no-undefined */

import test from 'tape';
import reducers from '../index';

test('returns state for unknown actions', (t) => {
  const state = { foo: 'bar' };
  t.equal(reducers(state, {}), state);
  t.end();
});

test('stores initial family tree', (t) => {
  const payload = {
    name: 'My name',
    mother: {},
    father: {}
  };
  const action = {
    type: 'SET_INITIAL_FAMILY_TREE',
    payload: payload
  };
  t.deepEqual(reducers(undefined, action), payload);
  t.end();
});
