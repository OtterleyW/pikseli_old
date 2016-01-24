import { createStore, applyMiddleware, compose } from 'redux';
import sagaMiddleware from 'redux-saga';
import sagas from './sagas';
import reducer from './reducers/index';

export default function configureStore(initialState) {
  const finalCreateStore = compose(
    applyMiddleware(
      sagaMiddleware(...sagas)
    ),
    window.devToolsExtension ? window.devToolsExtension() : f => f
  )(createStore);

  const store = finalCreateStore(reducer, initialState);

  if (module.hot) {
    // Enable Webpack hot module replacement for reducers
    module.hot.accept('./reducers/index', () => {
      const nextReducer = require('./reducers/index');
      store.replaceReducer(nextReducer);
    });
  }

  return store;
}
