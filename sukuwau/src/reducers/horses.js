import {
  SET_FAMILY_TREE
} from '../constants';

export default (state = {}, action) => {
  switch (action.type) {
    case SET_FAMILY_TREE:
      return action.payload;
    default:
      return state;
  }
};
