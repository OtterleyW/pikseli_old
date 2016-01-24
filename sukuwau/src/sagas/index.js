/* eslint-disable no-constant-condition */

import { BROWSE_HORSE } from '../constants';
import { setInitialFamilyTree } from '../actions';
import { UPDATE_LOCATION, routeActions } from 'redux-simple-router';
import { take, put, call } from 'redux-saga';

const headers = new Headers({
  'Content-Type': 'application/json'
});

function* fetchHorse(path) {
  const response = yield fetch(path, {headers});
  const json = yield response.json();
  yield put(setInitialFamilyTree(json));
}

function* browseHorseDaemon() {
  while (true) {
    const { payload: id } = yield take(BROWSE_HORSE);
    yield put(routeActions.push(`/hukkapuro/suku/${id}`));
  }
}

function* historyDaemon() {
  while (true) {
    const { payload } = yield take(UPDATE_LOCATION);
    yield call(fetchHorse, payload.pathname);
  }
}

export default [browseHorseDaemon, historyDaemon];
