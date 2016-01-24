/* eslint-disable no-constant-condition */

import { BROWSE_HORSE } from '../constants';
import { setFamilyTree } from '../actions';
import { UPDATE_LOCATION, routeActions } from 'redux-simple-router';
import { take, put, call } from 'redux-saga';

const headers = new Headers({
  'Content-Type': 'application/json'
});

function* fetchHorse(path) {
  try {
    const response = yield fetch(path, {headers});
    const json = yield response.json();
    yield put(setFamilyTree(json));
  }
  catch (e) {
    console.error(e);
  }
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
    yield call(fetchHorse, `${payload.pathname}.json`);
  }
}

export default [browseHorseDaemon, historyDaemon];
