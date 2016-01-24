import {
  SET_INITIAL_FAMILY_TREE,
  BROWSE_HORSE
} from './constants';

export const setInitialFamilyTree = (tree) => ({
  type: SET_INITIAL_FAMILY_TREE,
  payload: tree
});

export const browseHorse = (id) => ({
  type: BROWSE_HORSE,
  payload: id
});
