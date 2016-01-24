import { BROWSE_HORSE } from '../constants';
import { setInitialFamilyTree } from '../actions';
import { take, put, call } from 'redux-saga';

const headers = new Headers({
  'Content-Type': 'application/json'
});

function* fetchHorse(id) {
  const response = yield fetch(`/hukkapuro/suku/${id}`, {headers});
  const json = yield response.json();
  yield put(setInitialFamilyTree(json));
}

function* browseHorseDaemon() {
  while (true) { // eslint-disable-line no-constant-condition
    const nextAction = yield take(BROWSE_HORSE);
    yield call(fetchHorse, nextAction.payload);
  }
}

export default [browseHorseDaemon];
