import { BROWSE_HORSE } from '../constants';
import { take } from 'redux-saga';

function* browseHorseDaemon() {
  while (true) { // eslint-disable-line no-constant-condition
    const nextAction = yield take(BROWSE_HORSE);
    console.log(nextAction);
  }
}

export default [browseHorseDaemon];
