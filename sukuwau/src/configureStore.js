import { createStore, combineReducers, applyMiddleware, compose } from 'redux';
import { syncHistory, routeReducer } from 'redux-simple-router';
import { createHistory } from 'history';

import sagaMiddleware from 'redux-saga';
import sagas from './sagas';
import * as reducers from './reducers';

export default function configureStore(initialState) {
  const browserHistory = createHistory();
  const reduxRouterMiddleware = syncHistory(browserHistory);

  const finalCreateStore = compose(
    applyMiddleware(
      sagaMiddleware(...sagas),
      reduxRouterMiddleware
    ),
    window.devToolsExtension ? window.devToolsExtension() : f => f
  )(createStore);

  const finalReducer = combineReducers({
    ...reducers,
    routing: routeReducer
  });

  const store = finalCreateStore(finalReducer, initialState);

  // Required for replaying actions from devtools to work
  reduxRouterMiddleware.listenForReplays(store);

  if (module.hot) {
    // Enable Webpack hot module replacement for reducers
    module.hot.accept('./reducers/index', () => {
      const nextReducer = require('./reducers/index');
      store.replaceReducer(nextReducer);
    });
  }

  return store;
}
