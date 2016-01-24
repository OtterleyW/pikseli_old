import { createStore, applyMiddleware, compose } from 'redux';
import reducer from './reducers/index';

export default function configureStore(initialState) {
  const finalCreateStore = compose(
    applyMiddleware(),
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
